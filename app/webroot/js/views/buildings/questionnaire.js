$(document).ready( function() {
  // Last resort. Clear the required flag manually.
  $('#RealtorFirstName,#RealtorLastName,#RealtorEmail').parent().removeClass( 'required' );
  $('#InspectorFirstName,#InspectorLastName,#InspectorEmail').parent().removeClass( 'required' );

  // NAVIGATION
  // Which target are we initially activating?
  if( document.location.hash.length === 0 ) {
    $location = $( '#BuildingId' ).val().length === 0
      ? $( '#general' )
      : $( '#demographics' );
  }
  else {
    $location = $( document.location.hash );
    document.location.hash = ''; // reset the hash to prevent scrolling
  }
  
  // If we're in the equipment section, enable the "Save & Return" button
  if( $location.attr( 'id' ) == 'equipment' ) {
    $( '#btn-return[type="submit"]' ).parent().removeClass( 'disabled' );
  }
  // Style the active target link in the questionnaire section nav
  $( 'a[href="#' + $location.attr( 'id' ) + '"]' ).addClass( 'active' );
  // Set the current anchor in the form for later. @see BuildingsController::questionnaire()
  $( '#BuildingAnchor' ).val( $location.attr( 'id' ) );
  // Show the div specified by the anchor
  $location.addClass( 'active' );
  $( '.section' ).not( '.active' ).hide();
  
  // Allow random access to sections via the nav
  $( '#sidebar #questionnaire a[href^="#"]' ).click( function( e ) {
    var $link    = $(this);
    var $section = $( $link.attr( 'href' ) );
    
    $( '#sidebar #questionnaire a.active' ).removeClass( 'active' );
    $link.addClass( 'active' );
    
    $( '.section.active' ).slideUp( 'slow', function() {
      $deactivated = $(this);
      $section.slideDown( 'fast', function() {
        $deactivated.removeClass( 'active' );
        $(this).addClass( 'active' );
      })
    })
    
    e.preventDefault();
  });
  // END NAVIGATION

  // Save and continue by default, but allow the user to save and return
  // to the current anchor.
  $( '#btn-return[type="submit"]').click( function( e ) {
    $( '#BuildingContinue' ).val( 0 );
  });

  // Toggle an editable user form (inspector, realtor)
  $('.toggle-form').click( function( e ) {
    var $this  = $(this);
    var model  = $this.attr( 'data-model' ).toLowerCase();
    var $panel = $( '#' + model );
    
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
      // $this.text( 'Change ' + $this.attr( 'data-model' ) );
    }
    else {
      // Don't clear existing data if we're editing.
      if( !$this.attr( 'data-id' ) ) {
        $( ':text', $panel ).val( '' ); // Clear existing data
      }
      
      $panel.slideDown();
      // $this.text( 'Cancel Change' );
    }
    
    e.preventDefault();
  });
  
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
    
    /** Pull the zip code's locale (city, state) info */
    $.getJSON( '/addresses/locale/' + zip + '.json', null, function( data ) {
      /** Display the city, state identified by the zip code */
      $this
        .next( 'p' ).slideUp().remove().end()
        .after( '<p>' + data.ZipCode.city + ', ' + data.ZipCode.state + '</p>' ).slideDown();
    });
    
    // Retrieve known utility providers for the given zip code
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
  
  // Trigger the change event if the zip code is pre-populated
  if( $('#AddressZipCode').length > 0 && $('#AddressZipCode').val().length > 0 ) {
    $('#AddressZipCode' ).change();
  }
  
  // Set energy source options based on the technology selected
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
});
