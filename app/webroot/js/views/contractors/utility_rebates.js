$( document ).ready( function() {
  /**
   * Because the CSS sucks, we're using a reset input as a back button
   * so we need to hijack the functionality.
   */
  $( 'input[type="reset"].previous' ).click( function( e ) {
    location.href = $(this).attr( 'data-previous' );
    
    e.preventDefault();
  });
});
