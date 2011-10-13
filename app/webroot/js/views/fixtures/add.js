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
  
  if( $( '#FixtureServiceIn' ).val().length > 0 ) {
    $( '#slider' ).slider( 'value', $( '#FixtureServiceIn' ).val() );
  }
  else {
    $( '#FixtureServiceIn' ).val( $( '#slider' ).slider( 'value' ) )
  }
});