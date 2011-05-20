$(document).ready( function() {
  // Handle disabled links
  $( 'a.disabled' ).click( function( e ) {
    e.preventDefault();
  });
  
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
  
  // Loads dialogs (fancybox)
  $( '.dialog' ).fancybox({ /** OPTIONS TBD */ });
  
  // Closes fancybox dialog windows from a link
  $( 'a.dialog-close' ).click( function( e ) {
    parent.$.fancybox.close();
    e.preventDefault();
  });
});
