$(document).ready( function() {
  $('#menu a[rel="modal"]').colorbox({
    href: function() {
      return $(this).attr( 'href' );  
    },
    rel: 'nofollow',
  });
});
