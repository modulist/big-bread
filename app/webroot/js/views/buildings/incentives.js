$(document).ready( function() {
  $( '.incentive-note a' ).toggle(function() { 
      $(this).closest( '.itemspac' ).prevAll('.incentive').first().slideDown(); 
      $(this).html('Hide Details');
    }, 
    function() { 
      $(this).closest( '.itemspac' ).prevAll('.incentive').first().slideUp(); 
      $(this).html('Show Details');
  });
  
  $( '.item a.all-incentives' ).click( function( e ) {
    var $this = $(this);
    var technology_slug = $this.closest( 'h3' ).attr( 'id' );
    var current_text    = $this.text();
    var new_text        = /^Expand /.test( $this.text() )
      ? current_text.replace( 'Expand', 'Collapse' )
      : current_text.replace( 'Collapse', 'Expand' );
    
    $(this).text( new_text );
    $( '.incentive-note.' + technology_slug + ' a' ).trigger( 'click' );
    
    e.preventDefault();
  });
  
  // Hide the print button until we have a stylesheet
  $('.buttons input[type="submit"]').click( function() {
    window.print();
  })
});
