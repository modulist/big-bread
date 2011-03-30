$(document).ready( function() {
  /** FOR TESTING, DO SOME WORK AUTOMATICALLY */
  /** TODO: REMOVE THIS BEFORE DEPLOYMENT */
  alert( 'loading test data...' );
  
  $('#RealtorFirstName').val( 'realfirst' );
  $('#RealtorLastName').val( 'reallast' );
  $('#RealtorEmail').val( 'real@tor.com' );
  $('#InspectorFirstName').val( 'inspectorfirst' );
  $('#InspectorLastName').val( 'inspectorlast' );
  $('#InspectorEmail').val( 'inspec@tor.com' );
  $('#ClientFirstName').val( 'Rob' );
  $('#ClientLastName').val( 'Wilkerson' );
  $('#ClientEmail').val( 'rob@rob.com' );
  
  $('#AddressAddress1').val( '3322 O\'Donnell Street' );
  
  $('#OccupantAge1464').val( '2' );
  $('#OccupantDaytimeOccupancy').attr( 'checked', 'checked' );
  $('#BuildingSetpointHeating').val( '67' );
  $('#BuildingSetpointCooling').val( '70' );
  $('#OccupantCoolingOverride').attr( 'checked', 'checked' );
  
  $('#BuildingExposureTypeId').val( '4d6ff15d-e100-489f-8016-793d3b196446' );
  $('#BuildingYearBuilt').val( '1920' );
  $('#BuildingFinishedSf').val( '2300' );
  $('#BuildingBuildingTypeId').val( '4d6ff15d-16c4-415f-92f8-793d3b196446' );
  $('#BuildingMaintenanceLevelId').val( '4d6ff15d-fe04-47db-8811-793d3b196446' );
  $('#BuildingStoriesAboveGround').val( '2' );
  $('#BuildingBuildingShapeId').val( '4d6ff444-f864-4668-b9b0-7a073b196446' );
  $('#BuildingBasementTypeId').val( '4d6ffa65-8f10-489d-8659-7bcd3b196446' );
  $('#BuildingInsulatedFoundation').attr( 'checked', 'checked' );
  $('#BuildingWallSystemWallSystemId').val( '4d6ffa65-73f8-412e-ab8c-7bcd3b196446' );
  $('#BuildingWallSystemInsulationLevelId').val( '4d700e7a-d250-4c50-9a4f-82376e891b5e' );
  
  $('#BuildingWindowSystem0WindowPaneTypeId4d6ffa6573f8412eAb8c7bcd3b196446').attr( 'checked', 'checked' );
  $('#BuildingWindowSystem0LowE').attr( 'checked', 'checked' );
  $('#BuildingWindowSystem0FrameMaterialId').val( '4d6ff15d-b0ac-4bb2-b550-793d3b196446' );
  $('#BuildingWindowPercentAverage').val( '5' );
  $('#BuildingWindowPercentLarge').val( '20' );
  $('#BuildingWindowWallSide2').attr( 'checked', 'checked' );
  $('#BuildingSkylightCount').val( '4' );
  $('#BuildingShadingTypeId').val( '4d700e7a-b2ec-4ead-a2e9-82376e891b5e' );
  
  $('#BuildingVisibleWeatherStripping').attr( 'checked', 'checked' );
  $('#BuildingVisibleCaulking').attr( 'checked', 'checked' );
  $('#BuildingRoofSystem0RoofSystemId').attr( 'checked', 'checked' );
  $('#BuildingRoofSystem0LivingSpaceRatio').val( '10' );
  $('#BuildingRoofSystem2RoofSystemId').attr( 'checked', 'checked' );
  $('#BuildingRoofSystem2LivingSpaceRatio').val( '90' );
  
  $('#BuildingRoofSystemInsulationLevelId').val( '4d700e7a-d250-4c50-9a4f-82376e891b5e' );
  /** END AUTO FILL */
  
  $('#AddressZipCode').change( function() {
    var $this = $(this);
    var zip   = $this.val();
    
    /** Pull the zip code's locale (city, state) info */
    $.getJSON( '/addresses/locale/' + zip + '.json', null, function( data ) {
      /** Display the city, state identified by the zip code */
      $this
        .next( 'p' ).slideUp().remove().end()
        .after( '<p>' + data.ZipCode.city + ', ' + data.ZipCode.state + '</p>' ).slideDown();
    });
    
    /** Retrieve known utility providers for the given zip code */
    var utility_types = [ 'Electricity', 'Gas', 'Water' ];
    
    for( var i = 0; i < utility_types.length; i++ ) {
      var type = utility_types[i];
      
      $.getJSON( '/addresses/utilities/' + zip + '/' + type + '.json', null, function( data, status ) {
        var utility_type = data.Type.name;
        
        var $provider_name = $('#Building' + utility_type + 'ProviderName');
        var $provider_id   = $('#Building' + utility_type + 'ProviderId');
        
        // alert( utility_type );
        // alert( data.Utilities[0].Utility.name );
        
        if( data.Utilities.length == 1 ) {
          /** If there's only one, just set that value as a default */
          $provider_name.val( data.Utilities[0].Utility.name );
          $provider_id.val( data.Utilities[0].Utility.utility_id );
        }
        else {
          /** If more than one, populate the provider autocomplete options */
          $provider_name.autocomplete({
            source: data.Utilities,
            minLength: 0,
            focus: function( event, ui ) {
              $provider_name.val( ui.item.Utility.name );
              return false;
            },
            select: function( event, ui ) {
              $provider_name.val( ui.item.Utility.name );
              $provider_id.val( ui.item.Utility.id );
              return false;
            }
          }).data( 'autocomplete' )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
              .data( "item.autocomplete", item )
              .append( '<a>' + item.Utility.name + '</a>' )
              .appendTo( ul );
          };
        }
      });
    }
      
    $('#utility-providers').slideDown();
  });
  
  $('.equipment-type select').change( function() {
    var $select        = $(this);
    var $energy_select = $select.parent().nextAll( '.energy-source' ).first().find( 'select' );
    var technology_id  = $select.val();
    
    $energy_select.attr( 'disabled', 'disabled' );
    $energy_select.children( 'option' ).remove();
    $energy_select.append( '<option value="">Loading...</option>' );
    
    /** get energy sources */
    $.getJSON( '/products/energy_sources/' + technology_id + '.json', null, function( data, status ) {
      $energy_select.children( 'option' ).remove();
      
      for( var i = 0; i < data.length; i++ ) {
        $energy_select.append( '<option value="' + data[i].EnergySource.incentive_tech_energy_type_id + '">' + data[i].EnergySource.name + '</option>' );
      }
      $energy_select.removeAttr( 'disabled' );
    });
  });
  
  if( $('#AddressZipCode').val().length > 0 ) {
    $('#AddressZipCode' ).change();
  }
  
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
      var $label = $(this).parent().find( 'label' ).first();
      var name  = $this.attr( 'name' );
      var id    = $this.attr( 'id' );
      
      /** Empty any values cloned from the original */
      $this.val('');
      
      /** Update the cloned field index with the next value */
      var new_name = name.replace( new RegExp( '\[' + (i - 1) + '\]' ), i );
      var new_id   = id.replace( new RegExp( i - 1 ), i );
      $this.attr( 'name', new_name );
      $this.attr( 'id', new_id );
      
      /** And update the label */
      $label.attr( 'for', new_id );
    });
    
    $cloneable.after( $cloned );
    e.preventDefault();
    return false;
  });
});
