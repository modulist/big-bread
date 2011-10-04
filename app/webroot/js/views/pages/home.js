$(document).ready( function() {
  $('#login-trigger a').click( function( e ) {
    e.preventDefault();
    
    $('#login-popup').toggleClass( 'active' );
  });
});