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
});
