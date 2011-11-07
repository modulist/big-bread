$.getScript( '/js/jquery/jquery.currency.min.js' );

$(document).ready( function() {
  // Show/hide the login form
  $('#login-trigger a, #login-popup .cancel-link, #login-popup .close-button' ).click( function( e ) {
    e.preventDefault();
    
    $('#login-popup').toggleClass( 'active' );
  });
  
  // Submit the login form via ajax to avoid redirection to SSL
  $('#UserLoginForm').submit( function( e ) {
    e.preventDefault();
    
    var $this = $(this);
    
    $.ajax({
      url: $this.attr( 'action' ),
      type: 'POST',
      data: $this.serialize(),
      beforeSend: function() {
        $('.flash.error', $this).fadeTo( 200, 0 );
      },
      success: function( data, status, jqXHR ) {
        location.reload();
      },
      error: function( jqXHR, textStatus, thrownError ) {
        console.log( jqXHR );
        console.log( textStatus );
        if( $('.flash.error', $this).length > 0 ) {
          $('.flash.error').fadeTo( 200, 100 );
        }
        else {
          $this.prepend( '<div class="flash error">Invalid authentication credentials. Please try again.</div>' );
        }
      },
      complete: function() {
        $(':button', $this).removeAttr( 'disabled' );
      }
    });
  });
  
  // Various treatments of the zipcode input
  $('#zipcode')
    .autotab({ format: 'numeric' })
    .focus( function( e ) {
      $(this).addClass( 'active' );
    })
    .blur( function( e ) {
      $(this).removeClass( 'active' );
    })
    .keyup( function( e ) {
      if( $.inArray( e.which, control_keys ) === -1 ) {
        var $this = $(this);
        
        if( $this.val().search( /^[0-9]{5}$/ ) >= 0 ) {
          $this.toggleClass( 'loading' );
          $.ajax({
            url: '/api/v1/zip_codes/highlights/' + $this.val() + '/true.json',
            dataType: 'json',
            beforeSend: function( jqXHR, settings ) {
              jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
            },
            success: function( data ) {
              if( data ) {
                // Write out the total savings available for that zip code
                $('.sample-rebate-amount span').text( '$' + $.currency( data.total_savings, { c: 0 } ) );
                // Update the zip code display beneath the textbox
                $('.zip-code-display').text( $this.val() );
                // Update the row data
                $('.rebate-city').text( data.locale.ZipCode.city + ', ' + data.locale.ZipCode.state );
                // Update the table of featured rebates
                $('.rebates-preview').slideUp( function() {
                  var $this   = $(this);
                  var $tbody  = $(this).find( 'tbody' );
                  
                  // Remove existing content
                  $tbody.find( 'tr' ).remove();
                  
                  var i = 0;
                  for( var rebate in data.featured_rebates ) {
	                var sponsor_name = rebate.replace( /\s*-.+$/, '' );
	                
	                $tbody.append( 
		           	  '<tr class="' + ( ++i % 2 === 0 ? 'even' : 'odd' ) + '">' +
		           	  '<td class="rebate-source"></td>' +
		           	  '<td class="rebate-amount"></td>' +
		           	  '</tr>' 
		           	);
		           	
		           	$('tr:last td:first', $tbody)
		           		.attr( 'title', sponsor_name )
		           		.text( sponsor_name.length > 25 ? sponsor_name.substring( 0, 20 ) + '...' : sponsor_name );
                    $('tr:last td:last', $tbody).text( '$' + $.currency( data.featured_rebates[rebate], { c: 0 } ) );
                  }
                })
                .delay( 1000 )
                .slideDown();
              }
              else {
                alert( 'We don\'t recognize that zip code' );
              }
            },
            error: function( jqXHR, textStatus ) {
              alert( 'Sorry, we don\'t have any data for the ' + $this.val() + ' zip code.' );
            },
            complete: function( jqXHR, textStatus ) {
              $this.toggleClass( 'loading' );
            }
          });
        }
      }
    });
});