$(document).ready( function() {
  $('#user_type img')
    .css( 'cursor', 'pointer' )
    .click( function() {
      id = $(this).attr( 'data-for' );
      // TODO: "-a" in the UUID is being converted to "A" and messing stuff up
      $('#' + id).attr( 'checked', 'checked' );
    });
    
  $('input[type="reset"]').click( function() {
    location.href = '/';
  })
});
