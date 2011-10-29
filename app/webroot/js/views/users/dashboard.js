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
      maxHeight: 200,
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
  
  $( '#my-interests a, .rebate-category-row .star' ).click( function( e ) {
    e.preventDefault();
    
    var $this          = $(this);
    var tech_id        = $this.attr( 'data-technology-id' );
    var $interest      = $( '#my-interests a[data-technology-id=' + tech_id + ']' );
    var $tech_row      = $( '.rebate-category-row[data-technology-id=' + tech_id + ']' );
    var $tech_row_star = $tech_row.find( '.star' );
    var action         = $this.attr( 'href' ).match( /(?:un)?watch/ );
    
    $.ajax({
      url: $this.attr( 'href' ),
      type: 'GET',
      success: function( data, status, jqXHR ) {
        $interest.parent().toggleClass( 'active' );
        
        if( action == 'unwatch' ) {
          var new_url = $this.attr( 'href' ).replace( /unwatch/, 'watch' );
          
          // Adjust the URL in both places
          $interest.attr( 'href', new_url );
          $tech_row_star.attr( 'href', new_url );
          // Hide the rebate group
          $tech_row.slideUp( function() {
              if( $( '.rebates-watch-list .rebate-category-row:visible' ).length == 0 ) {
                $( '.message-empty-watchlist' ).slideDown();
              }
              else {
                $( '.message-empty-watchlist' ).slideUp();
              }
          });
          // Deactivate the star
          $tech_row_star
            .removeClass( 'active' )
            .attr( 'title', $tech_row_star.attr( 'title' ).replace( / remove /, ' add ' ) ) ;
        }
        else {
          var new_url = $this.attr( 'href' ).replace( /watch/, 'unwatch' );
          
          // Adjust the URL in both places
          $interest.attr( 'href', new_url );
          $tech_row_star.attr( 'href', new_url );
          // Activate the star
          $tech_row_star
            .addClass( 'active' )
            .attr( 'title', $tech_row_star.attr( 'title' ).replace( / add /, ' remove ' ) );
          // Show the rebate group
          $tech_row.slideDown( function() {
              if( $( '.rebates-watch-list .rebate-category-row:visible' ).length == 0 ) {
                $( '.message-empty-watchlist' ).slideDown();
              }
              else {
                $( '.message-empty-watchlist' ).slideUp();
              }
          });
        }
      }
    });
  });
});