$(document).ready( function() {
  // Last resort. Clear the required flag manually.
  $('#RealtorFirstName,#RealtorLastName,#RealtorEmail').parent().removeClass( 'required' );
  $('#InspectorFirstName,#InspectorLastName,#InspectorEmail').parent().removeClass( 'required' );
  
  $( '#AddressAddress1,#AddressAddress2' ).tipsy({ title: function() { return 'Please do not include city or state information here' }, gravity: 'w', trigger: 'focus', fade: true })
  $( '#AddressZipCode' ).tipsy({ title: function() { return 'We\'ll use your zip code to determine your city and state' }, gravity: 'w', trigger: 'focus', fade: true })

  // Which target are we initially activating?
  $( '.section' ).not( '.active' ).hide();

  // Save and continue by default, but allow the user to save and return
  // to the current anchor.
  $( '#btn-return[type="submit"]').click( function( e ) {
    $( '#WizardContinue' ).val( 0 );
  });

  // Toggle an editable user form (inspector, realtor)
  $('.toggle-form').click( function( e ) {
    var $this       = $(this);
    var model       = $this.attr( 'data-model' ).toLowerCase();
    var $panel      = $( '#' + model );
    
    // In some cases, there's an add form for new models and edit forms
    // for each existing model. The edits are uniquely identified by
    // the primary model identifier.
    if( $this.attr( 'data-id' ) ) {
      var id = $this.attr( 'data-id' );
      
      $panel = $( '#' + model + '-' + id );
    }
    
    $('.sliding-panel').slideUp(); // close any open panels
    
    if( $panel.is( ':visible' ) ) {
      $panel.slideUp();
    }
    else {
      // Don't clear existing data if we're editing.
      if( !$this.attr( 'data-id' ) ) {
        $( ':text', $panel ).val( '' );
      }
      
      $panel.slideDown();
    }
    
    // show/hide the Save & Return button for equipment
    if( model.toLowerCase() == 'product' ) {
      $( '#btn-return' ).parent().toggleClass( 'disabled' );
    }
    
    // In a sliding panel, the form should return to the current page
    $panel.find( 'input[value="Save"]').click( function( e ) {
      $( '#WizardContinue' ).val( 0 );
    });
    
    // Wire the cancel button in a sliding panel to close the panel
    $panel.find( 'input[value="Cancel"]').click( function( e ) {
      $this.trigger( 'click' );
      e.preventDefault();
    });
    
    e.preventDefault();
  });
  
  // If an error exists on a form, show the form
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Realtor"]' ).trigger( 'click' );
  }
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Inspector"]' ).trigger( 'click' );
  }
  
  // Retire a piece of equipment
  $( '.action.delete.retire' ).click( function( e ) {
    if( !confirm( 'Are you sure you want to retire this piece of equipment?' ) ) {
      return false;
    }
    
    var $this = $(this);
    
    $.post(
      $this.attr( 'href' ),
      null,
      function( data, status, jqXHR ) {
        $tbody = $this.closest( 'tbody' );
        $tr    = $this.closest( 'tr' );
        
        $tr
          .html( '<td colspan="5"><div class="flash success">Equipment retired successfully.</div></td>' )
          .fadeOut( 5000, function() {
            // If we just deleted the last child, display a msg to the user
            if( $tbody.children().length === 1 ) {
              $(this)
                .html( '<td colspan="5">No equipment has been added.</td>' )
                .fadeIn( 2000 );
            }
            else {
              $(this).remove();
            }
          });
      }
    );
    
    e.preventDefault();
  });
  
  // When the zip code changes, pull the city/state and utility data
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    var zip   = $this.val();
    
    // Pull the zip code's locale (city, state) info
    // Only do this if it's not faux placeholder text
    if( zip.length > 0 && zip.search( /^e.g. / ) == -1 ) {
      $this.next( 'small' )
        .removeClass( 'error' )
        .text( 'Determining locale...' );
      $.ajax({
        url: '/addresses/locale/' + zip + '.json',
        dataType: 'json',
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
              .text( 'Unrecognized zip code' );
          }
        }
      });
    }
    else {
      $this.next( 'small' )
        .removeClass( 'error' )
        .text( 'We\'ll find your city, state from the zip code.' );
    }
  });
  
  // Trigger the change event if the zip code is pre-populated
  if( $('#AddressZipCode').length > 0 && $('#AddressZipCode').val().length > 0 ) {
    // Set the locale data if zip code has been entered (and there's no validation error).
    $('#AddressZipCode').trigger( 'change' );
    
    // Retrieve known utility providers for the given zip code
    var utility_types = [ 'Electricity', 'Gas', 'Water' ];
    var zip           = $('#AddressZipCode').val();
    
    for( var i = 0; i < utility_types.length; i++ ) {
      var type = utility_types[i];
      
      $('#Building' + type + 'ProviderName').attr( 'placeholder', 'Loading provider data...' );
      
      $.getJSON( '/addresses/utilities/' + zip + '/' + type + '.json', null, function( data, status ) {
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
      });
    }
  }
  
  // Set energy source options based on the technology selected
  $('.equipment-type select').live( 'change', function() {
    var $select        = $(this);
    var $energy_select = $select.parent().nextAll( '.energy-source' ).first().find( 'select' );
    var technology_id  = $select.val();
    
    $energy_select.attr( 'disabled', 'disabled' );
    $energy_select.children( 'option' ).remove();
    
    if( technology_id.length > 0 ) {
      $energy_select.append( '<option value="">Loading...</option>' );
    }
    else {
      $energy_select.append( '<option value="">Select equipment type</option>' );
    }
    
    /** get energy sources */
    $.getJSON( '/products/energy_sources/' + technology_id + '.json', null, function( data, status ) {
      $energy_select.children( 'option' ).remove();
      
      for( var i = 0; i < data.length; i++ ) {
        $energy_select.append( '<option value="' + data[i].EnergySource.incentive_tech_energy_type_id + '">' + data[i].EnergySource.name + '</option>' );
      }
      $energy_select.removeAttr( 'disabled' );
    });
  });
});
