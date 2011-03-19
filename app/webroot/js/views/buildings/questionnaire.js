$(document).ready( function() {
  /** FOR TESTING, DO SOME WORK AUTOMATICALLY */
  /** TODO: REMOVE THIS BEFORE DEPLOYMENT */
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
    
    /** Populate the electricity provider autocomplete options */
    $('#BuildingElectricityProviderName').autocomplete({
      source: '/addresses/utilities/' + zip + '/ele.json',
      minLength: 0,
      focus: function( event, ui ) {
        $('#BuildingElectricityProviderName').val( ui.item.Utility.name );
        
        return false;
      },
      select: function( event, ui ) {
        $( '#BuildingElectricityProviderName' ).val( ui.item.Utility.name );
        $( '#BuildingElectricityProviderId' ).val( ui.item.Utility.id );

        return false;
      }
    }).data( 'autocomplete' )._renderItem = function( ul, item ) {
      return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( '<a>' + item.Utility.name + '</a>' )
        .appendTo( ul );
    };
    
    /** Populate the gas provider autocomplete options */
    $('#BuildingGasProviderName').autocomplete({
      source: '/addresses/utilities/' + zip + '/gas.json',
      minLength: 0,
      focus: function( event, ui ) {
        $('#BuildingGasProviderName').val( ui.item.Utility.name );
        
        return false;
      },
      select: function( event, ui ) {
        $( '#BuildingGasProviderName' ).val( ui.item.Utility.name );
        $( '#BuildingGasProviderId' ).val( ui.item.Utility.id );

        return false;
      }
    }).data( 'autocomplete' )._renderItem = function( ul, item ) {
      return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( '<a>' + item.Utility.name + '</a>' )
        .appendTo( ul );
    };
    
    /** Populate the water provider autocomplete options */
    $('#BuildingWaterProviderName').autocomplete({
      source: '/addresses/utilities/' + zip + '/wtr.json',
      minLength: 0,
      focus: function( event, ui ) {
        $('#BuildingWaterProviderName').val( ui.item.Utility.name );
        
        return false;
      },
      select: function( event, ui ) {
        $( '#BuildingWaterProviderName' ).val( ui.item.Utility.name );
        $( '#BuildingWaterProviderId' ).val( ui.item.Utility.id );

        return false;
      }
    }).data( 'autocomplete' )._renderItem = function( ul, item ) {
      return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( '<a>' + item.Utility.name + '</a>' )
        .appendTo( ul );
    };
      
    $('#utility-providers').slideDown();
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