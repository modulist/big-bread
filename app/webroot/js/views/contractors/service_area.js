$( document ).ready( function() {
  
  $( '#ContractorServiceAreaState' ).change( function( e ) {
    var $this         = $(this);
    var $county_lists = $( '#county_list' );
    var state_abbrev  = $this.val();
    var state_name    = $this.find( 'option[value="' + state_abbrev + '"] ').text();
    
    // Only create a column if there isn't already one for this state.
    if( $( 'li#' + state_name.toLowerCase() ).length === 0 ) {
      // loading counties message...
      var $column   = $( document.createElement( 'li' ) );
      var columns   = $county_lists.children( 'li' ).length;
      var col_width = 100 / ( columns + 1 );
      
      $column.attr( 'id', state_name.toLowerCase() );
      $column
        .append( '<h2>' + state_name + '<span>[<a href="#" class="remove column">remove</a>]</span></h2>' )
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
    }
    else {
      // If a column for the state exists, try to draw the user's
      // attention to it.
      $this
        .after( ' <span class="error">This state has already been selected</span>' )
        .next()
        .delay( 2000 )
        .fadeOut();
        
      $( 'li#' + state_name.toLowerCase() )
        .animate( { backgroundColor: '#ffc' }, 1000 )
        .delay( 1000 )
        .animate( { backgroundColor: 'transparent' }, 1000 );
    }
    
    e.preventDefault();
  });
  
  $( '.remove.column' ).live( 'click', function( e ) {
    $( this ).closest( 'li' ).remove();
    
    e.preventDefault();
  });
});
