$(document).ready( function() {
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
