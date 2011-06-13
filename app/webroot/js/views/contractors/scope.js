$( document ).ready( function() {
  $( '.checkbox input[type="checkbox"]' ).change( function( e ) {
    var $this     = $(this);
    var tech_id   = $this.val();
    var tech_name = $this.parent().find( 'label' ).text();
    var $manufacturer_lists = $( '#manufacturer_lists' );
    
    // If unchecking, remove the technology column
    if( !$this.is( ':checked' ) ) {
      $( '#manufacturer_' + tech_id ).remove();
    }
    else {
      var $column   = $( document.createElement( 'li' ) );
      var c_columns = $manufacturer_lists.children( 'li' ).length;
      var col_width = 100 / ( c_columns + 1 );
      
      $column.addClass( 'column' );
      $column.attr( 'id', 'manufacturer_' + tech_id )
      $column.append( '<h3>' + tech_name + '</h3>' );
      $manufacturer_lists.append( $column );
      $manufacturer_lists.find( 'li' ).css( 'max-width', col_width + '%' );
      
      $.getJSON(
        '/technologies/manufacturers/' + tech_id + '.json',
        function( data, status, jqXHR ) {
          var $manufacturer_list = $( document.createElement( 'ol' ) );
          
          if( data.length === 0 ) {
            var $item    = $( document.createElement( 'li' ) );
            
            $item.html( '<strong>No manufacturers to display</strong>' );
            $manufacturer_list.append( $item );
          }
          else {
            for( var i = 0; i < data.length; i++ ) {
              var $item    = $( document.createElement( 'li' ) );
              var input_id = 'ContractorManufacturerDealer' + data[i].EquipmentManufacturer.id;
              
              $item.html( '<input type="checkbox" class="manufacturer" name="data[ManufacturerDealer][][equipment_manufacturer_id]" id="' + input_id + '" value="' + data[i].EquipmentManufacturer.id + '" /> <label for="' + input_id + '">' + data[i].EquipmentManufacturer.name + '</label>' );
              $item.append( '<div style="display: none; padding-left: 10px;"><input type="checkbox" name="data[ManufacturerDealer][][incentive_participant]" id="IncentiveParticipant' + data[i].EquipmentManufacturer.id + '" value="1" /> <label for="IncentiveParticipant' + data[i].EquipmentManufacturer.id + '">I am incentive certified</label></div>' );
              $manufacturer_list.append( $item );
            }
          }
          $column.append( $manufacturer_list );
        }
      );
      
      $( 'input[type="checkbox"].manufacturer' ).live( 'change', function( e ) {
        var $this = $( this );
        
        if( $this.is( ':checked' ) ) {
          $this.nextAll( 'div' ).slideDown();
        }
        else {
          $this.nextAll( 'div' ).find( 'input[type="checkbox"]' ).removeAttr( 'checked' );
          $this.nextAll( 'div' ).slideUp();
        }
      });
    }
    
    e.preventDefault();
  });
});
