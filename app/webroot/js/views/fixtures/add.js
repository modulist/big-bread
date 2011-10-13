$(document).ready( function() {
  var now = new Date();
  
  $( '#slider' ).slider({
    value: 0,
    min: now.getFullYear() - 15,
    max: now.getFullYear(),
    step: 1,
    slide: function( event, ui ) {
      $( '#FixtureServiceIn' ).val( ui.value );
    }
  });
  $( '#FixtureServiceIn' ).val( $( '#slider' ).slider( 'value' ) );
});