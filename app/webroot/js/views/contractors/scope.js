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
      
      $.getJSON(
        '/technologies/manufacturers/' + tech_id + '.json',
        function( data, status, jqXHR ) {
          // If at least one manufacturer is assigned to this technology
          // build a list so contractors can identify relationships.
          if( data.EquipmentManufacturer.length > 0 ) {
            $column.addClass( 'column' );
            $column.attr( 'id', 'manufacturer_' + tech_id )
            $column.append( '<h3>' + tech_name + '</h3>' );
            $manufacturer_lists.append( $column );
            $manufacturer_lists.find( 'li' ).css( 'max-width', col_width + '%' );
            
            var $manufacturer_list = $( document.createElement( 'ol' ) );
            
            for( var i = 0; i < data.EquipmentManufacturer.length; i++ ) {
              var $item    = $( document.createElement( 'li' ) );
              var input_id = 'ContractorManufacturerDealer' + data.EquipmentManufacturer[i].id;
              
              $item.html( '<input type="checkbox" class="manufacturer" name="data[ManufacturerDealer][' + i + '][equipment_manufacturer_id]" id="' + input_id + '" value="' + data.EquipmentManufacturer[i].id + '" /> <label for="' + input_id + '">' + data.EquipmentManufacturer[i].name + '</label>' );
              $item.append( '<div style="display: none; padding-left: 10px;"><input type="checkbox" name="data[ManufacturerDealer][' + i + '][incentive_participant]" id="IncentiveParticipant' + data.EquipmentManufacturer[i].id + '" value="1" /> <label for="IncentiveParticipant' + data.EquipmentManufacturer[i].id + '">I am incentive certified</label></div>' );
              $manufacturer_list.append( $item );
            }
          }
          $column.append( $manufacturer_list );
        }
      );
    }
    
    e.preventDefault();
  });
  
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
});
