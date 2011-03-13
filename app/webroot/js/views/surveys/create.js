$(document).ready( function() {
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    $.getJSON( '/addresses/locale/' + $this.val() + '.json', null, function( data ) {
      /** Display the city, state identified by the zip code */
      $this.next( 'p' ).remove();
      $this.after( '<p>' + data.ZipCode.city + ', ' + data.ZipCode.state );
    });
  });
  
  /**
   * Some building components can be entered as multiples. Each group of
   * fields that makes up a record is contained within a "cloneable" div.
   * Any number of cloneable elements can be contained by a fieldset "group"
   */
  $('.group .clone').click( function( e ) {
    $this      = $(this); // The "add another..." link
    $group     = $this.parent(); // The group fieldset
    $cloneable = $group.children( '.cloneable' ).last(); // The last cloneable set in the group
    $cloned    = $cloneable.clone(); // The new clone
    
    /** How many do we already have? */
    var i = $( '.cloneable' ).length;
    
    /** Update the CakePHP name, id values on each cloned input */
    $cloned.find( 'input, select, textarea' ).each( function() {
      var $this = $(this);
      var name  = $this.attr( 'name' );
      var id    = $this.attr( 'id' );
      
      /** Empty any values cloned from the original */
      $this.val('');
      
      /** Update the cloned field index with the next value */
      $this.attr( 'name', name.replace( new RegExp( '\[' + (i - 1) + '\]' ), i ) );
      $this.attr( 'id', id.replace( new RegExp( i - 1 ), i ) );
    });
    
    $cloneable.after( $cloned );
    e.preventDefault();
    return false;
  });
});
