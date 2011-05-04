$(document).ready( function() {
  // Dismisses optional flash messages
  $( '.dismiss' ).click( function( e ) {
    var $flash  = $(this).closest( '.flash' );
    var notice = $(this).attr( 'data-notice' );
    $.get( '/users/dismiss_notice/' + notice,
      null,
      function( e ) {
        $flash.fadeOut( 'slow' );
      }
    );
    
    e.preventDefault();  
  });

  
  $('a[rel="modal"]').colorbox({
    href: function() {
      return $(this).attr( 'href' );  
    },
    title: function() {
      var title = $(this).attr( 'title' );
      return title != 'undefined' ? title : false;
    },
    rel: 'nofollow'
  });
});
