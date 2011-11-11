<div id="messages">
  <?php if( empty( $location ) ): # User has not entered a location ?>
    <?php if( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['REALTOR'] ): ?>
      <h1><?php __( 'Rebates help close sales' ) ?></h1>
      <p><?php __( 'You\'re about to provide another reason why your client will refer you. Inform your client of thousands of $ in savings that will make their home ownership experience more affordable and increase the value of their home. ' ) ?></p>
    <?php elseif( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['INSPECTOR'] ): ?>
      <h1><?php __( 'Be a solution hero with huge rebates from SaveBigBread' ) ?></h1>
      <p><?php __( 'Let your competition be the problem guy while you\'re the solution guy. You\'ll more than offset your fee and create customer awe when you bring big rebates to the table. Be the hero and help your client SaveBigBread.' ) ?></p>
    <?php else: # Home owner/buyer greeting ?>
      <h1><?php __( 'Congratulations!' ) ?></h1>
      <p><?php __( 'We\'ve collected a few of the rebates you selected under My Rebates.  If you want to view everything, look at the Ways to Save section.  You can personalize your list even further if you add a property.  We\'ll assign your list of interests to that location.' ) ?></p>
    <?php endif; ?>
  <?php else: # User has a location ?>
    <?php if( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['REALTOR'] ): ?>
      <h1><?php __( '' ) ?></h1>
      <p><?php __( 'Welcome back and keep the savings pumping for your clients. The more they come back to SaveBigBread, the more they\'ll remember it was you that brought it to their attention and another reason they owe you a referral.' ) ?></p>
    <?php elseif( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['INSPECTOR'] ): ?>
      <h1><?php __( 'Be a solution hero with huge rebates from SaveBigBread' ) ?></h1>
      <p><?php __( 'Welcome back and keep the savings pumping for your clients. The more they come back to SaveBigBread, the more they\'ll remember it was you that brought it to their attention and another reason they owe you a referral.' ) ?></p>
    <?php else: ?>
      <h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
      <p><?php __( 'There\'s so much to do and so much to save!' ) ?></p>
    <?php endif; ?>
  <?php endif; # empty( $location ) ?>
</div><!-- /#messages -->

<div id="my-locations" class="clearfix">
  <?php if( empty( $location ) ): ?>
    <h2 class="first-location"><?php echo !User::agent() ? __( 'Add my first location', true ) : __( 'Add a location', true ) ?>:</h2>
    <div class="location-icon-large"></div>
    
	    <?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ), 'class' => 'clearfix' ) ) ?>
	      <?php if( User::agent() ): ?>
	        <?php echo $this->element( '../buildings/_client_inputs' ) ?>
	      <?php endif; ?>
	      <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
      <div class="instructions">
      	<div class="message-text">
      		<?php __( 'We\'ll find your city and state for you.' ) ?>
				</div>
		    <?php echo $this->Form->end( __( 'Add location', true ) ) ?>
	    </div>
  <?php else: ?>
    <h2><?php __( 'My location' ) ?>:</h2>
    <div class="location-switch-wrapper clearfix">
      <?php echo $this->element( '../buildings/_location_switcher', array( 'locations' => $other_locations ) ) ?>
    </div>
    
    <div class="location-wrapper clearfix">
      <div class="location-icon"></div>
      <h4><?php echo !empty( $location['Building']['name'] ) ? h( $location['Building']['name'] ) : h( $location['Address']['address_1'] ) ?></h4>
      <div class="location-address">
        <?php echo $this->element( 'address', array( 'address' => $location['Address'] ) ) ?>
        <div class="add-edit clearfix"><?php echo $this->Html->link( __( 'edit', true ), array( 'controller' => 'buildings', 'action' => 'edit', h( $location['Building']['id'] ) ), array( 'class' => 'edit-button' ) ) ?>
        <?php /* ?>| <?php echo $this->Html->link( __( 'remove', true ), '#', array( 'class' => 'remove-button' ) ) ?><?php */ ?>
        </div>
      </div>
      <div class="location-equipment-grid grid_5">
        <?php echo $this->element( '../fixtures/_list', array( 'plugin' => false, 'fixtures' => $fixtures ) ) ?>
        <?php echo $this->Html->link( __( 'Add equipment', true ), array( 'controller' => 'fixtures', 'action' => 'add', $location['Building']['id'] ), array( 'class' => 'add-equipment-button' ) ) ?>
        <!-- add a location button -->
        <?php echo $this->Html->link( sprintf( __( 'Add a location %s', true ), '&rsaquo;' ), array( 'controller' => 'buildings', 'action' => 'add' ), array( 'class' => 'add-location-button', 'escape' => false ) ) ?>
      </div><!-- /location-equipment-grid -->
    </div><!-- /location-wrapper -->
  <?php endif; ?>
</div><!-- /my-locations -->

<h2 class="my-rebates"><?php printf( __( 'Rebates for %s', true ), $location_title ) ?></h2>
<?php if( empty( $technology_watch_list ) ): ?>
  <p class="message-empty-watchlist" style="margin-left: 10px"><?php __( 'Wondering why you don\'t see any rebates? It\'s because you haven\'t had a chance to identify any interests for this location. Scroll down to do just that.' ) ?></p>
<?php endif; ?>

<?php echo $this->element( '../technology_incentives/_list', array( 'rebates' => $rebates, 'watch_list' => $technology_watch_list, 'location_id' => $location['Building']['id'] ) ) ?>

<form id="QuotesDashboardForm">
  <div id="pending-quotes" class="grid_9">
    <h2><?php printf( __( 'Pending quotes for %s', true ), $location_title ) ?></h2>
    <?php if( empty( $pending_quotes ) ): ?>
      <p class="message-no-quotes" style="margin-left: 10px"><?php __( 'Looks like you don\'t have any open quotes. Take a look at what we have and let us know what you need.' ) ?></p>
    <?php endif; ?>
    
    <table class="pending quotes-list">
      <?php $c_groups = count( $pending_quotes ) ?>
      <?php $i = 0; ?>
      <?php foreach( $pending_quotes as $tech_name => $quotes ): ?>
        <?php $classes = array( $i++ % 2 == 0 ? 'odd' : 'even' ) # Adjusted for 0-based indexing ?>        
        <?php array_push( $classes, $i == 0 ? 'first' : false ) ?>
        <?php array_push( $classes, $i == $c_groups - 1 ? 'last' : false )?>
        
        <tr class="pending-quotes-category-row <?php echo join( ' ', array_filter( $classes ) ) ?>">
          <td class="pending-quotes-category">
            <table class="pending-quotes-header">
              <tr class="last odd">
                <td class="quote-category"><a href="#" class="toggle collapsed"><span class="quote-category-title"><?php echo h( $tech_name ) ?></span></a> (<?php echo count( $quotes ) ?>)</td>
                <td class="quote-date">&nbsp;</td>
                <td class="quote-status">&nbsp;</td>
                <td class="quote-action">&nbsp;</td>
              </tr>
            </table>
            <table class="pending-quotes-content">
              <?php foreach( $quotes as $quote ): ?>
                <tr>
                  <td class="contractor"><?php echo h( $quote['TechnologyIncentive']['Incentive']['name'] ) ?></td>
                  <td class="quote-date"><?php echo $this->Time->timeAgoInWords( $quote['Proposal']['created'], array( 'end' => '+6 months' ) ) ?></td>
                  <td class="quote-status">&nbsp;</td>
                  <td class="quote-action">&nbsp;</td>
                </tr>
              <?php endforeach; ?>
            </table>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</form>  
  
<div id="my-interests" class="grid_9">
  <h2><?php printf( User::agent() ? __( 'Potential interests for my client', true ) : __( 'My interests for %s', true ), $location_title ) ?></h2>
  <p class="instructions">
    <?php if( !User::agent() ): ?>
      <?php __( 'Select as many categories of rebates as you like by clicking on the stars below.' ) ?>
    <?php else: ?>
      <?php __( 'Select the categories that you believe your client should consider.' ) ?>
    <?php endif; ?>
  </p>
  
  <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => $technology_watch_list, 'location_id' => !empty( $location ) ? $location['Building']['id'] : false ) ) ?>
</div>
