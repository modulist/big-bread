/**
 * Control key codes:
 * - null, backspace, horizontal tab, return, shift, control, alt, escape, meta
 */
var control_keys = [0,8,9,13,16,17,18,27,91];
  
$(document).ready( function() {
  /** MODERNIZR */
  if( !Modernizr.input.placeholder ) {
    $('input[type=text][placeholder]').placeholder();
  }
  
  if( !Modernizr.input.autofocus ) {
    $( 'input[autofocus]' ).focus();
  }
  
  /** GENERAL APPLICATION STUFF */
  
  // Handle disabled links
  $( 'a.disabled' ).click( function( e ) {
    e.preventDefault();
  });
  
  /** FORMS */
  
  // See control_keys global above.
  
  // Disable buttons on a form being submitted
  $( 'form' ).submit( function( e ) {
    $this = $(this);
    
    $(':button', $this).attr( 'disabled', 'disabled' );
  });
  
  // Depends on the jQuery autotab plugin
  // http://www.mathachew.com/sandbox/jquery-autotab/
  $( '.phonenumber input' ).autotab_magic().autotab_filter( 'number' );
  
  /**
   * Set the datepicker date format, where applicable.
   */
  if( $( '.date' ).length ) {
    $( 'input.date' ).datepicker({ dateFormat: 'MM d, yy' });
  }
});

/**
 * Emulates the HTML5 placeholder input attribute
 */
(function( $ ) {
  $.fn.placeholder = function() {
    return this.each( function() {
      var $this = $(this);
      
      var clear = function() {
        if( $this.val() === $this.attr( 'placeholder' ) ) {
          $this
            .removeClass( 'placeholder' )
            .val( '' );
        }
        return true;
      };
  
      var placeholder = function() {
        if( $this.val() === '' ) {
          $this
            .addClass( 'placeholder' )
            .val( $this.attr('placeholder') );
        }
      };
      
      $this
        .focus( clear )
        .blur( placeholder )
        .closest('form').submit( clear );
      
      placeholder();
    });
  };
})( jQuery );
  
/**
 * Loads the utility autocomplete list
 */
function load_utilities( zip_code ) {
  // Pull known utility data for this zip code
  var utility_types = [ 'Electricity', 'Gas', 'Water' ];
  var zip           = zip_code;
  
  for( var i = 0; i < utility_types.length; i++ ) {
    var type = utility_types[i];
    
    $('#' + type + 'ProviderName').attr( 'placeholder', 'Loading provider data...' );
    
    $.ajax({
      url: '/api/v1/zip_codes/utilities/' + zip + '/' + type + '.json',
      type: 'GET',
      dataType: 'json',
      beforeSend: function( jqXHR, settings ) {
        jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
      },
      success: function( data, status ) {
        var utility_type = data.Type.name;
        var $provider_name = $('#' + utility_type + 'ProviderName');
        var $provider_id   = $('#' + utility_type + 'ProviderId');
      
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
}

