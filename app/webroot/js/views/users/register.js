$(document).ready( function() {
  // Build a set of values that will become the technology watch list
  $('a[data-technology-id]').click( function( e ) {
    e.preventDefault();
    
    var $this                 = $(this);
    var selected_id           = $this.attr( 'data-technology-id' );
    var technology_watch_list = $('#WatchedTechnologySelected').val().split( ',' );
    
    $this.parent().toggleClass( 'active' );
    
    // Manipulate the array of selected technologies
    if( $this.parent().hasClass( 'active' ) ) { // Add technology to watchlist
      technology_watch_list.push( selected_id );
    }
    else { // Remove technology from watchlist
      var i = technology_watch_list.indexOf( selected_id );
      
      if( i != -1 ) {
        technology_watch_list.splice( i, 1 );
      }
    }
    
    // Convert the array back to a string and reset the hidden value
    $('#WatchedTechnologySelected').val( technology_watch_list.join( ',' ) );
  });
});
