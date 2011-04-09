$(document).ready( function() {
  $('a[rel="modal"]').colorbox({
    href: function() {
      return $(this).attr( 'href' );  
    },
    rel: 'nofollow'
  });
});
