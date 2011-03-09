$(document).ready( function() {
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    $.getJSON( '/addresses/locale/' + $this.val() + '.json', null, function( data ) {
      /** TODO: Remove any existing value before adding new */
      $this.after( '<p>' + data.ZipCode.city + ', ' + data.ZipCode.state );
    });
  });
});
