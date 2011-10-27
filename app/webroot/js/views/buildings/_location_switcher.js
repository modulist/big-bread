$(document).ready( function() {
  $( '.location-switcher' ).click( function( e ) {
    e.preventDefault();
    
    $( this + ', .other-location-list' ).toggleClass( 'active' );
  });
});