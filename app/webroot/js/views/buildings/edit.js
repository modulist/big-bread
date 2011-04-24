$(document).ready( function() {
  // Toggle an editable user form
  $('.toggle-form').click( function( e ) {
    var $this       = $(this);
    var $form       = $('#' + $this.attr( 'data-model' ).toLowerCase());
    
    $('.sliding-panel').slideUp(); // close any open panels
    
    if( $form.is( ':visible' ) ) {
      $form.slideUp();
      // $this.text( 'Change ' + $this.attr( 'data-model' ) );
    }
    else {
      $( ':text', $form ).val( '' ); // Clear existing data
      $form.slideDown();
      // $this.text( 'Cancel Change' );
    }
    
    e.preventDefault();
  });
  
  // If an error exists on a form, show the form
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Realtor"]' ).trigger( 'click' );
  }
  if( $( '#realtor form .error' ).length ) {
    $( '.toggle-form[data-model="Inspector"]' ).trigger( 'click' );
  }
  
  // Wire the cancel button to close the panel
  $( '#realtor form input[type="reset"], #inspector form input[type="reset"]' ).click( function( e ) {
    var $panel = $(this).parents( '.sliding-panel' );
    var id     = $panel.attr( 'id' );
    var model  = id.charAt(0).toUpperCase() + id.slice( 1 );
    
    $( '.toggle-form[data-model="' + model + '"]' ).trigger( 'click' );
    e.preventDefault();
  });
  
  // Inline editing...
  $( '.editable' ).editable({
    submit: 'Change',
    cancel: 'Cancel',
    onEdit: function() {
      var $this = $(this);
      
      $this.find( 'input' ).select();
    },
    onSubmit: function( content ) {
      if( content.current == content.previous ) { // Nothing changed
        return false;
      }
      
      var $this  = $(this);
      var $form  = $this.parents( 'form' );
      var model  = $this.attr( 'data-model' );
      var field  = $this.attr( 'data-field' );
      var data   = $form.serialize() + '&data[' + model + '][' + field + ']=' + content.current;
      
      // Update and report back any errors
      $.ajax({
        url: $form.attr( 'action' ),
        type: 'POST',
        data: data,
        dataType: 'json',
        error: function( jqXHR, textStatus, errorThrown ){
          var errors = $.parseJSON( jqXHR.responseText );
          
          $this.text( content.previous );
          
          for( var i in errors ) {
            alert( errors[i] );
          }
        }
      });
    }
  })
});
