$.getScript( '/js/jquery/jquery.currency.min.js' );

$(document).ready( function() {
  // Show/hide the login form
  $('#login-trigger a').click( function( e ) {
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
      error: function( e, jqXHR, settings, thrownError ) {
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
    //.autotab_filter( 'number' )
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
            url: '/api/v1/zip_codes/overview/' + $this.val() + '.json',
            dataType: 'json',
            beforeSend: function( jqXHR, settings ) {
              jqXHR.setRequestHeader( 'Authorization', '1001001SOS' );  
            },
            success: function( data ) {
              if( data ) {
                // Write out the total savings available for that zip code
                $('.sample-rebate-amount span').text( '$' + $.currency( data.total_savings, { c: 0 } ) );
                // Update the row data
                $('.rebate-city').text( data.locale.ZipCode.city + ', ' + data.locale.ZipCode.state );
                // Update the table of featured rebates
                $('.rebates-preview').slideUp( function() {
                  var $this = $(this);
                  
                  var i = 0;
                  for( var rebate in data.featured_rebates ) {
                    var $row = $('tr:nth-child(' + ++i + ')');
                    var sponsor_name = rebate.replace( /\s*-.+$/, '' );
                    
                    $('td:first', $row).text( sponsor_name.length > 25 ? sponsor_name.substring( 0, 20 ) + '...' : sponsor_name );
                    $('td:last', $row).text( '$' + $.currency( data.featured_rebates[rebate], { c: 0 } ) );
                  }
                })
                .delay( 1000 )
                .slideDown();
              }
              else {
                alert( 'We don\'t recognize that zip code' );
              }
            },
            complete: function( jqXHR, textStatus ) {
              $this.toggleClass( 'loading' );
            }
          });
        }
      }
    });
});