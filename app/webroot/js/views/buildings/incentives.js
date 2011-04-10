$(document).ready( function() {
  jQuery('.incentive-note a').toggle(function() { 
      $(this).closest( '.itemspac' ).prevAll('.incentive').first().slideDown(); 
      $(this).html('Hide Details');
    }, 
    function() { 
      $(this).closest( '.itemspac' ).prevAll('.incentive').first().slideUp(); 
      $(this).html('Show Details');
  });
});
