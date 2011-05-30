$(document).ready( function() {
  /** MODERNIZR */
  if( !Modernizr.input.placeholder ) {
    $('input[type=text][placeholder]').placeholder();
  }
  
  /** GENERAL APPLICATION STUFF */
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
  $( '.dialog.iframe' ).fancybox({
    'height': '50%',
    'width': '50%'
  });
  // $( '.dialog' ).fancybox({ /** OPTIONS TBD */ });
  
  // Closes fancybox dialog windows from a link
  $( 'a.dialog-close' ).click( function( e ) {
    parent.$.fancybox.close();
    e.preventDefault();
  });
  
  /** FORMS */
  
  /**
   * Control key codes:
   * - null, backspace, horizontal tab, return, shift, control, alt, escape, meta
   */
  var control_keys = [0,8,9,13,16,17,18,27,91];
  
  /**
   * Auto-skip phone number components
   */
  $('.phonenumber input[maxlength]')
    .keyup( function( e ) {
      var keycode = e.charCode || e.keyCode || 0;
      
      if( $.inArray( keycode, control_keys ) < 0 ) {
        $(this).val().length == $(this).attr( 'maxlength' ) ? $(this).next( 'input' ).select() : null;
      }
    });
    
});

/**
 * Emulates the HTML5 placeholder input attribute
 */
$.fn.placeholder = function() {
  return this.each( function() {
    var $this = $(this);
    
    var clear = function() {
      if( $this.val() === $this.attr( 'title' ) ) {
        $this
          .removeClass( 'placeholder' )
          .val( '' );
      }
      return true;
    };

    var placeholder = function() {
      if( $this.val() === '' ) {
        $this
          .addClass( 'placeholder' )
          .val( $this.attr('placeholder') );
      }
    };
    $this
      .focus( clear )
      .blur( placeholder )
      .closest('form').submit( clear );
    
    placeholder();
  });
};
