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
  
  $('.quote-button, .details').click( function( e ) {
    e.preventDefault();
    
    var $this = $(this);
    
    $( '<div/>' ).load( $this.attr( 'href' ) ).dialog({
      height: 'auto',
      resizable: false,
      title: $this.attr( 'title' ).length > 0 ? $this.attr( 'title' ) : false,
      width: 'auto',
      resize: function( e, ui ) {
        $(this).dialog( 'option', 'position', 'center' );
      }
    });
  });
  
  $('.star').click( function( e ) {
    e.preventDefault();
    
    var $this    = $(this);
    var base_url = '/api/v1/users/';
    var url      = $this.hasClass( 'active' )
      ? base_url + 'unwatch_technology/'
      : base_url + 'watch_technology/';
    
    url += $this.attr( 'data-user-id' ) + '/' + $this.attr( 'data-technology-id' ) + ( $this.attr( 'data-location-id' ) ? '/' + $this.attr( 'data-location-id' ) : '' );
    url += '.json';
    
    $.ajax({
      url: url,
      type: 'POST',
      beforeSend: function( jqXHR, settings ) {
        jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
      },
      success: function( data, status, jqXHR ) {
        $this.toggleClass( 'active' );
      },
      error: function( e, jqXHR, settings, thrownError ) {
        alert( 'Sorry, we were unable to modify your interests at this time.' );
      }
    });
  });
});
