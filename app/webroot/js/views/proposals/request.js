$(document).ready( function() {
  if( $( '#AddressZipCode' ).length ) {
    $( '#AddressZipCode' ).change( function( e ) {
      load_utilities( $( '#AddressZipCode' ).val() ); // @see application.js
    });
  }
  else if( $( '.zip-code' ).length ) {
    load_utilities( $( '.zip-code' ).text() ); // @see application.js
  }

  $( '[name="data[Proposal][under_warranty]"]' ).change( function( e ) {
    var $this = $(this);

    if( $this.val() == 1 ) {
      $( '.permission-to-examine' ).slideDown();
    }
    else {
      $( '.permission-to-examine' ).slideUp();
    }
  });
});