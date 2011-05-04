$(document).ready( function() {
  // Last resort. Clear the required flag manually.
  $('#RealtorFirstName,#RealtorLastName,#RealtorEmail').parent().removeClass( 'required' );
  $('#InspectorFirstName,#InspectorLastName,#InspectorEmail').parent().removeClass( 'required' );

  $( '.dismiss' ).click( function( e ) {
    var $flash  = $(this).closest( '.flash' );
    var notice = $(this).attr( 'data-notice' );
    $.get( '/users/dismiss_notice/' + notice,
      null,
      function( e ) {
        $flash.fadeOut( 'slow' );
      }
    );
    
    e.preventDefault();  
  });

  $('#AddressZipCode').change( function() {
    var $this = $(this);
    var zip   = $this.val();
    
    /** Pull the zip code's locale (city, state) info */
    $.getJSON( '/addresses/locale/' + zip + '.json', null, function( data ) {
      /** Display the city, state identified by the zip code */
      $this
        .next( 'p' ).slideUp().remove().end()
        .after( '<p>' + data.ZipCode.city + ', ' + data.ZipCode.state + '</p>' ).slideDown();
    });
    
    /** Retrieve known utility providers for the given zip code */
    var utility_types = [ 'Electricity', 'Gas', 'Water' ];
    
    for( var i = 0; i < utility_types.length; i++ ) {
      var type = utility_types[i];
      
      $.getJSON( '/addresses/utilities/' + zip + '/' + type + '.json', null, function( data, status ) {
        var utility_type = data.Type.name;
        
        var $provider_name = $('#Building' + utility_type + 'ProviderName');
        var $provider_id   = $('#Building' + utility_type + 'ProviderId');
        
        // Massage the Cake data into something autocomplete-friendly
        // @see http://stackoverflow.com/questions/5708128/jqueryui-autocomplete-doesnt-really-autocomplete
        var $friendly = $.map( data.Utilities, function( util ) {
          return { label: util.Utility.name, value: util.Utility.id };
        });
        
        if( data.Utilities.length == 1 ) {
          /** If there's only one, just set that value as a default */
          $provider_name.val( data.Utilities[0].Utility.name );
          $provider_id.val( data.Utilities[0].Utility.id );
        }
        else {
          /** If more than one, populate the provider autocomplete options */
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
      });
    }
      
    $('#utility-providers').slideDown();
  });
  
  if( $('#AddressZipCode').val().length > 0 ) {
    $('#AddressZipCode' ).change();
  }
  
  /**
   * Some building components can be entered as multiples. Each group of
   * fields that makes up a record is contained within a "cloneable" div.
   * Any number of cloneable elements can be contained by a fieldset "group"
   */
  $('.group .clone').click( function( e ) {
    $this      = $(this); // The "add another..." link
    $group     = $this.parent(); // The group fieldset
    $cloneable = $group.children( '.cloneable' ).last(); // The last cloneable set in the group
    $cloned    = $cloneable.clone(); // The new clone
    
    /** How many do we already have? */
    var i = $( '.cloneable' ).length;
    
    /** Update the CakePHP name, id values on each cloned input */
    $cloned.find( 'input, select, textarea' ).each( function() {
      var $this = $(this);
      var $label = $(this).parent().find( 'label' ).first();
      var name  = $this.attr( 'name' );
      var id    = $this.attr( 'id' );
      
      /** Empty any values cloned from the original */
      $this.val('');
      
      /** Update the cloned field index with the next value */
      var new_name = name.replace( new RegExp( '\[' + (i - 1) + '\]' ), i );
      var new_id   = id.replace( new RegExp( i - 1 ), i );
      $this.attr( 'name', new_name );
      $this.attr( 'id', new_id );
      
      /** And update the label */
      $label.attr( 'for', new_id );
      
      /** If we're cloning the energy source, clear and disable it */
      if( $this.parent().hasClass( 'energy-source' ) ) {
        $this.attr( 'disabled', 'disabled' );
        $this.children( 'option' ).remove();
        $this.append( '<option value="">Select equipment type</option>' );
      }
    });
    
    $cloneable.after( $cloned );
    e.preventDefault();
    return false;
  });
  
  
  // This is copied into edit.js
  // TODO: Make this DRY
  $('.equipment-type select').live( 'change', function() {
    var $select        = $(this);
    var $energy_select = $select.parent().nextAll( '.energy-source' ).first().find( 'select' );
    var technology_id  = $select.val();
    
    $energy_select.attr( 'disabled', 'disabled' );
    $energy_select.children( 'option' ).remove();
    $energy_select.append( '<option value="">Loading...</option>' );
    
    /** get energy sources */
    $.getJSON( '/products/energy_sources/' + technology_id + '.json', null, function( data, status ) {
      $energy_select.children( 'option' ).remove();
      
      for( var i = 0; i < data.length; i++ ) {
        $energy_select.append( '<option value="' + data[i].EnergySource.incentive_tech_energy_type_id + '">' + data[i].EnergySource.name + '</option>' );
      }
      $energy_select.removeAttr( 'disabled' );
    });
  });
  
  // Set the cancel button to return to the homepage
  $('.button input[type="reset"]').click( function() {
    location.href = '/';
  });
  // Hide the submit button. It doesn't do anything right now.
  $('.button input[value="Submit"]').css( 'display', 'none' );
});
