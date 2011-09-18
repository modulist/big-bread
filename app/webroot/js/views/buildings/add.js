$(document).ready( function() {
  // Whenever the address value changes, we need to go get locale and
  // utility data.
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    var zip   = $this.val();
    
    // Pull the zip code's locale (city, state) info
    // Only do this if it's not faux placeholder text
    if( zip.length > 0 ) {
      $this.next( 'small' )
        .removeClass( 'error' )
        .text( 'Determining locale...' );
      $.ajax({
        url: '/api/v1/zip_codes/locale/' + zip + '.json',
        dataType: 'json',
        beforeSend: function( jqXHR, settings ) {
          jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
        },
        success: function( data ) {
          if( data ) {
            // Remove any error display
            $this
              .removeClass( 'form-error' )
              .closest( '.input' ).find( '.error-message' ).hide();
            
            // Display the city, state identified by the zip code
            $this.next( 'small' )
              .removeClass( 'error' )
              .text( data.ZipCode.city + ', ' + data.ZipCode.state );
          }
          else {
            $this.next( 'small' )
              .addClass( 'error' )
              .text( 'We don\'t recognize that zip code.' );
          }
        }
      });
    }
    else {
      $this.next( 'small' )
        .removeClass( 'error' )
        .text( 'We\'ll find your city and state.' );
    }
    
    // Pull known utility data for this zip code
    var utility_types = [ 'Electricity', 'Gas', 'Water' ];
    
    for( var i = 0; i < utility_types.length; i++ ) {
      var type = utility_types[i];
      
      $('#Building' + type + 'ProviderName').attr( 'placeholder', 'Loading provider data...' );
      
      $.ajax({
        url: '/api/v1/zip_codes/utilities/' + zip + '/' + type + '.json',
        type: 'GET',
        dataType: 'json',
        beforeSend: function( jqXHR, settings ) {
          jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
        },
        success: function( data, status ) {
          var utility_type = data.Type.name;
          
          var $provider_name = $('#Building' + utility_type + 'ProviderName');
          var $provider_id   = $('#Building' + utility_type + 'ProviderId');
        
          // Massage the Cake data into something autocomplete-friendly
          // @see http://stackoverflow.com/questions/5708128/jqueryui-autocomplete-doesnt-really-autocomplete
          var $friendly = $.map( data.Utilities, function( util ) {
            return { label: util.Utility.name, value: util.Utility.id };
          });
          
          if( $provider_id.val().length == 0 && data.Utilities.length == 1 ) {
            // If there's only one, just set that value as a default 
            $provider_name.val( data.Utilities[0].Utility.name );
            $provider_id.val( data.Utilities[0].Utility.id );
          }
          else {
            // If more than one, populate the provider autocomplete options
            $provider_name.attr( 'placeholder', utility_type + ' provider' );
            $provider_name.autocomplete({
              source: $friendly, // use the autocomplete-friendly data
              minLength: 0,
              focus: function( event, ui ) {
                $provider_name.val( ui.item.label );
                return false;
              },
              select: function( event, ui ) {
                $provider_name.val( ui.item.label );
                $provider_id.val( ui.item.value );
                return false;
              }
            }).data( 'autocomplete' )._renderItem = function( ul, item ) {
              return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( '<a>' + item.label + '</a>' )
                .appendTo( ul );
            };
          }
        }
      });
    }
  });

  // If the page loads with a zip code value, trigger the zip code's
  // change event to go get utility & locale data.
  if( $('#AddressZipCode').length > 0 && $('#AddressZipCode').val().length > 0 ) {
    $('#AddressZipCode').trigger( 'change' );
  }
});
