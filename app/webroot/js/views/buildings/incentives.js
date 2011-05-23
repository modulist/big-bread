$(document).ready( function() {
  $( '.incentive-note a' ).toggle(function() { 
      show_details( $(this) );
    }, 
    function() { 
      hide_details( $(this) );
  });
  
  $( '.item a.all-incentives' ).click( function( e ) {
    var $this = $(this);
    var technology_slug = $this.closest( 'h3' ).attr( 'id' );
    var $handle         = $( '.incentive-note.' + technology_slug + ' a' );
    var current_text    = $this.text();
    var action          = /^Expand /.test( $this.text() )
      ? 'expand'
      : 'collapse';
    var new_text        = action == 'expand'
      ? current_text.replace( 'Expand', 'Collapse' )
      : current_text.replace( 'Collapse', 'Expand' );
    
    $(this).text( new_text );
    if( action == 'expand' ) {
      $handle.each( function( e ) {
        show_details( $(this) );
      });
    }
    else {
      $handle.each( function( e ) {
        hide_details( $(this) );
      });
    }
    
    e.preventDefault();
  });
  
  // Print button
  $('.buttons input[type="submit"]').click( function() {
    window.print();
  });
});

function show_details( $src ) {
  $src.closest( '.itemspac' ).prevAll('.incentive').first().slideDown();
  $src.html( 'Hide Details' );
}

function hide_details( $src ) {
  $src.closest( '.itemspac' ).prevAll('.incentive').first().slideUp();
  $src.html( 'Show Details' );
}
