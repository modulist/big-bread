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
      
      $.ajax({
        url: '/api/v1/technologies/manufacturers/' + tech_id + '.json',
        type: 'GET',
        dataType: 'json',
        beforeSend: function( jqXHR, settings ) {
          jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
        },
        success: function( data, status, jqXHR ) {
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
              var j        = $( 'ol ol li' ).length + i;
              var $item    = $( document.createElement( 'li' ) );
              var input_id = 'ContractorManufacturerDealer' + data.EquipmentManufacturer[i].id;
              
              $item.attr( 'data-manufacturer-id', data.EquipmentManufacturer[i].id );
              $item.html( '<input type="checkbox" data-for="equipment_manufacturer_id" name="data[ManufacturerDealer][' + j + '][equipment_manufacturer_id]" id="' + input_id + '" value="' + data.EquipmentManufacturer[i].id + '" /> <label for="' + input_id + '">' + data.EquipmentManufacturer[i].name + '</label>' );
              $item.append( '<div style="display: none; padding-left: 10px;"><input type="checkbox" data-for="incentive_participant" name="data[ManufacturerDealer][' + j + '][incentive_participant]" id="IncentiveParticipant' + data.EquipmentManufacturer[i].id + '" value="1" /> <label for="IncentiveParticipant' + data.EquipmentManufacturer[i].id + '">I am incentive certified</label></div>' );
              
              // If this manufacturer is already checked for another technology, check it here.
              // Also insert the hidden id field so we don't try to insert
              if( $( '[data-manufacturer-id="' + data.EquipmentManufacturer[i].id + '"] [data-for="equipment_manufacturer_id"]:checked' ).length ) {
                var $existing_hidden_input = $( '[data-manufacturer-id="' + data.EquipmentManufacturer[i].id + '"] input[type="hidden"]' ).first();
                
                $item.find( 'input[data-for="equipment_manufacturer_id"]' )
                  .attr( 'checked', 'checked' );
                
                // The hidden input defines the existing ManufacturerDealer id
                if( $existing_hidden_input ) {
                  $new_hidden_input = $existing_hidden_input.clone();
                  $new_hidden_input.attr( 'name', 'data[ManufacturerDealer][' + j + '][id]' );
                  
                  $item.prepend( $new_hidden_input );
                }
              }
              
              // If the contractor is an incentive participant under another technology, check it.
              if( $( '[data-manufacturer-id="' + data.EquipmentManufacturer[i].id + '"] [data-for="incentive_participant"]:checked' ).length ) {
                $item.find( '[data-for="incentive_participant"]' )
                  .attr( 'checked', 'checked' );
              }
              
              $manufacturer_list.append( $item );
            }
          }
          $column.append( $manufacturer_list );
          
          // If any items in the new column where selected by default,
          // trigger the change event so we can keep manufacturer data
          // sync'd across technologies.
          if( $column.find( 'input[data-for="equipment_manufacturer_id"]:checked' ).length ) {
            $column.find( 'input[data-for="equipment_manufacturer_id"]:checked' ).first().trigger( 'change' );
          }
        }
      });
    }
    
    e.preventDefault();
  });
  
  // Ensure that when a manufacturer is selected/deselected, the incentive
  // participant option shows/hides properly.
  $( 'input[type="checkbox"][data-for="equipment_manufacturer_id"]' ).live( 'change', function( e ) {
    var $this = $( this );
    var manufacturer_id = $this.closest( '[data-manufacturer-id]' ).attr( 'data-manufacturer-id' );
    
    if( $this.is( ':checked' ) ) {
      // check all the other instances of the same manufacturer
      $( '[data-manufacturer-id="' + manufacturer_id + '"] input[data-for="equipment_manufacturer_id"]' )
        .attr( 'checked', 'checked' )
        .nextAll( 'div' ).slideDown();
    }
    else {
      $( '[data-manufacturer-id="' + manufacturer_id + '"] [data-for="equipment_manufacturer_id"]' )
        .removeAttr( 'checked' )
        .nextAll( 'div' ).slideUp();
        
      $( '[data-manufacturer-id="' + manufacturer_id + '"] [data-for="incentive_participant"]' )
        .removeAttr( 'checked' )
        .trigger( 'change' );
    }
  });
  
  // Sync manufacturer selections between technologies. You're either a
  // manufacturer dealer/incentive participant or you're not.
  $( '[data-manufacturer-id] [data-for="incentive_participant"]' ).live( 'change', function( e ) {
    var $this = $( this );
    var manufacturer_id = $this.closest( '[data-manufacturer-id]' ).attr( 'data-manufacturer-id' );
    
    if( $this.is( ':checked' ) ) {
      $( '[data-manufacturer-id="' + manufacturer_id + '"] [data-for="incentive_participant"]' )
        .attr( 'checked', 'checked' );
    }
    else {
      $( '[data-manufacturer-id="' + manufacturer_id + '"] [data-for="incentive_participant"]' )
        .removeAttr( 'checked' );
    }
  });
});
