$(document).ready( function() {
  alert( $('iframe').length );
  $.colorbox.resize({
    innerHeight: ( $('iframe').offset().top + $('iframe').height() ),
    innerWidth: ( $('iframe').offset().left + $('iframe').width() )
  });/**
  alert( 'ready' );
  $('input[type="reset"]').click( function() {
    // $.colorbox.close();
  }) */
});
