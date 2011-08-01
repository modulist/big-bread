$(document).ready( function() {
  $('#user_type img')
    .css( 'cursor', 'pointer' )
    .click( function() {
      // when the icon is clicked, select the appropriate radio option
      $(this).nextAll( 'input[type="radio"]' ).attr( 'checked', 'checked' );
    });
    
  $('input[type="reset"]').click( function() {
    location.href = '/';
  });
});
