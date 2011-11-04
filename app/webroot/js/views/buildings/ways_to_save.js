$.getScript( '/js/views/technology_incentives/details.js' );
$.getScript( '/js/views/buildings/_location_switcher.js' );

$(document).ready( function() {
  $('.rebate-description .toggle').click( function( e ) {
    e.preventDefault();
    
    var $this = $(this);
    
    if( $this.hasClass( 'collapsed' ) ) {
      $this.closest( '.rebate-category' ).find( '.rebate-content' ).slideDown( function() {
        $this.removeClass( 'collapsed' ).addClass( 'expanded' );
      });
      
    }
    else {
      $this.closest( '.rebate-category' ).find( '.rebate-content' ).slideUp( function() {
        $this.removeClass( 'expanded' ).addClass( 'collapsed' );
      });
    }
  });
  
  $('.details').click( function( e ) {
    e.preventDefault();
    
    var $this = $(this);
    
    $( '<div/>' ).load( $this.attr( 'href' ) ).dialog({
      height: 'auto',
      maxWidth: 800,
      minWidth: 600,
      position: 'center',
      resizable: false,
      title: $this.attr( 'title' ).length > 0 ? $this.attr( 'title' ) : false,
      open: function( e, ui ) {
        $(this).dialog( 'option', 'position', 'center' );
      }
    });
  });
  
  $('.star').click( function( e ) {
    e.preventDefault();

    var $this          = $(this);
    var tech_id        = $this.attr( 'data-technology-id' );
    var $tech_row      = $( '.rebate-category-row[data-technology-id=' + tech_id + ']' );
    var $tech_row_star = $tech_row.find( '.star' );
    var action         = $this.attr( 'href' ).match( /(?:un)?watch/ );
    
    $.ajax({
      url: $this.attr( 'href' ),
      type: 'GET',
      success: function( data, status, jqXHR ) {
        if( action == 'unwatch' ) {
          var new_url = $this.attr( 'href' ).replace( /unwatch/, 'watch' );
          
          // Adjust the URL in both places
          $tech_row_star.attr( 'href', new_url );
          // Deactivate the star
          $tech_row_star
            .removeClass( 'active' )
            .attr( 'title', $tech_row_star.attr( 'title' ).replace( / remove /, ' add ' ) ) ;
        }
        else {
          var new_url = $this.attr( 'href' ).replace( /watch/, 'unwatch' );
          
          // Adjust the URL in both places
          $tech_row_star.attr( 'href', new_url );
          // Activate the star
          $tech_row_star
            .addClass( 'active' )
            .attr( 'title', $tech_row_star.attr( 'title' ).replace( / add /, ' remove ' ) );
        }
      }
    });
  });
});
