$(document).ready( function() {
  $('#show-details').click( function( e ) {
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
