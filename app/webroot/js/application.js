$(document).ready( function() {
  $('a[rel="modal"]').colorbox({
    href: function() {
      return $(this).attr( 'href' );  
    },
    title: function() {
      var title = $(this).attr( 'title' );
      return title != 'undefined' ? title : false;
    },
    rel: 'nofollow'/**,
    iframe: true,
    
    initialWidth: '50%',
    initialH: '50%',
    // innerWidth: 0,
    // innerHeight: 0,
    // scrolling: false,
    onComplete:function() {
      alert( $('iframe' ).length );
      $.colorbox.resize({
        // innerHeight: ( $('iframe').offset().top + $('iframe').height() ),
        // innerWidth: ( $('iframe').offset().left + $('iframe').width() )
      })
    }*/
  });
});
