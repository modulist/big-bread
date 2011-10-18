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
});