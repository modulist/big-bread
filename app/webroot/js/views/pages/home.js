$(document).ready( function() {
  $('#login-trigger a').click( function( e ) {
    e.preventDefault();
    
    $('#login-popup').toggleClass( 'active' );
  });
  
  $('#UserLoginForm').submit( function( e ) {
    e.preventDefault();
    
    var $this = $(this);
    
    $.ajax({
      url: $this.attr( 'action' ),
      type: 'POST',
      data: $this.serialize(),
      success: function( data, status, jqXHR ) {
        location.reload();
      },
      error: function( e, jqXHR, settings, thrownError ) {
        alert( 'Invalid authentication credentials. Please try again.' );
      },
      complete: function() {
        $(':button', $this).removeAttr( 'disabled' );
      }
    });
  });
});