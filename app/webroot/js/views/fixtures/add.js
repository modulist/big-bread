$.getScript( '/js/views/buildings/_location_switcher.js' );

$(document).ready( function() {
  var now = new Date();
  
  $( '#FixtureTechnologyId' ).change( function( e ) {
    var $this = $(this);
    var tech  = $this.find( 'option:selected' ).text();
    
    if( tech == 'Central Air Conditioner' || tech == 'Heat Pump' ) {
      $( '#FixtureOutsideUnit0' ).closest( '.input.radio' ).slideDown();
    }
    else {
      $( '#FixtureOutsideUnit0' ).closest( '.input.radio' ).slideUp();
    }
  });
  
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