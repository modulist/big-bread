$(document).ready( function( e ) {
  // Which target are we initially activating?
  if( document.location.hash.length === 0 ) {
    $location = $( '#demographics' );
  }
  else {
    $location = $( document.location.hash );
    document.location.hash = ''; // reset the hash to prevent scrolling
  }
  
  // Style the active target link
  $( 'a[href="#' + $location.attr( 'id' ) + '"]' ).addClass( 'active' );
  // Show the div specified by the anchor
  $location.addClass( 'active' );
  $( '.section' ).not( '.active' ).hide();
  
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
  
  // Toggle an editable user form
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
  
  // If an error exists on a form, show the form
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Realtor"]' ).trigger( 'click' );
  }
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Inspector"]' ).trigger( 'click' );
  }
  
  // Wire the cancel button to close the panel
  $( '.sliding-panel input[type="reset"]' ).click( function( e ) {
    var $panel = $(this).closest( '.sliding-panel' );
    var id     = $panel.attr( 'id' );
    var model  = id.charAt(0).toUpperCase() + id.slice( 1 );
    
    $panel.slideUp();
    // Complex, but may want to do this later if logic is added to the close action
    // $( '.toggle-form[data-model="' + model + '"]' ).trigger( 'click' );
    e.preventDefault();
  });
  
  $( '.action.delete.retire' ).click( function( e ) {
    var $this = $(this);
    
    $.post(
      $this.attr( 'href' ),
      null,
      function( data, status, jqXHR ) {
        $tbody = $this.closest( 'tbody' );
        $tr    = $this.closest( 'tr' );
        
        $tr
          .html( '<td colspan="5" class="flash success">Equipment retired successfully.</td>' )
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
  
  // Copied from questionnaire.js
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
});
