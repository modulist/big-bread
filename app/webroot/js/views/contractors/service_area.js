$( document ).ready( function() {
  $( '#ContractorServiceAreaState' ).change( function( e ) {
    var $this = $(this);
    var state = $this.val();
    
    $.getJSON(
      '/addresses/counties/' + state + '.json',
      function( data, status, jqXHR ) {
        
      }
    );
    e.preventDefault();
  })
});
