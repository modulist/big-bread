$(document).ready( function() {
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    $.getJSON( '/addresses/locale/' + $this.val() + '.json', null, function( data ) {
      /** TODO: Remove any existing value before adding new */
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
    
    /**
     * Some systems are divided into subgroups in the interface. For example,
     * HVAC Systems are split across heating and cooling groups. This is just
     * a visual cue, but we need to account for it when we clone.
     */
    var i = $( '.group[data-system="' + $group.attr('data-system') + '"] .cloneable' ).length;
      
    $cloned.find( 'input, select, textarea' ).each( function() {
      var $this = $(this);
      var name  = $this.attr( 'name' );
      var id    = $this.attr( 'id' );
      
      /** Index of the field that was cloned */
      var cloned_i = name.replace( /^.+\[(\d+)\].+$/, "$1" );
      
      /** Update the cloned field index with the next value */
      $this.attr( 'name', name.replace( new RegExp( cloned_i ), i ) );
      $this.attr( 'id', id.replace( new RegExp( cloned_i ), i ) );
    });
    
    $cloneable.after( $cloned );
    e.preventDefault();
    return false;
  });
});
