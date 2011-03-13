$(document).ready( function() {
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
      var name  = $this.attr( 'name' );
      var id    = $this.attr( 'id' );
      
      /** Empty any values cloned from the original */
      $this.val('');
      
      /** Update the cloned field index with the next value */
      $this.attr( 'name', name.replace( new RegExp( '\[' + (i - 1) + '\]' ), i ) );
      $this.attr( 'id', id.replace( new RegExp( i - 1 ), i ) );
    });
    
    $cloneable.after( $cloned );
    e.preventDefault();
    return false;
  });
});
