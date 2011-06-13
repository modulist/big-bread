$( document ).ready( function() {
  $( '#ContractorServiceAreaState' ).change( function( e ) {
    var $this         = $(this);
    var $county_lists = $( '#county_list' );
    var state_abbrev  = $this.val();
    var state_name    = $this.find( 'option[value="' + state_abbrev + '"] ').text();
    
    // loading counties message...
    var $column   = $( document.createElement( 'li' ) );
    var columns   = $county_lists.children( 'li' ).length;
    var col_width = 100 / ( columns + 1 );
    
    $column.append( '<h2>' + state_name + '</h2>' );
    $county_lists.append( $column );
    $county_lists.find( 'li' ).css( 'max-width', col_width + '%' );
    
    $.getJSON(
      '/addresses/counties/' + state_abbrev + '.json',
      function( data, status, jqXHR ) {
        var $county_list = $( document.createElement( 'ol' ) );
        
        for( var i = 0; i < data.length; i++ ) {
          var $item    = $( document.createElement( 'li' ) );
          var input_id = 'ContractorCounty' + data[i].County.id;
          
          $item.html( '<input type="checkbox" name="data[County][]" id="' + input_id + '" value="' + data[i].County.id + '" /> <label for="' + input_id + '">' + data[i].County.county + '</label>' );
          $county_list.append( $item );
        }

        // If only one county, select automagically
        if( data.length === 1 ) {
          $item.find( 'input[type="checkbox"]' ).attr( 'checked', 'checked' );
        }
        
        $column.append( $county_list );
      }
    );
    
    e.preventDefault();
  });
});
