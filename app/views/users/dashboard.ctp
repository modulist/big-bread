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
      <p><?php __( 'Over 60% of US adults are not even aware of the variety of improvement incentives out there. Share the savings with your first client and see how they appreciate someone who helps them save thousands of $s.' ) ?></p>
    <?php endif; ?>
  <?php else: ?>
    <?php if( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['REALTOR'] ): ?>
      <h1><?php __( '' ) ?></h1>
      <p><?php __( 'Welcome back and keep the savings pumping for your clients. The more they come back to SaveBigBread, the more they\'ll remember it was you that brought it to their attention and another reason they owe you a referral.' ) ?></p>
    <?php elseif( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::$reverse_lookup['INSPECTOR'] ): ?>
      <h1><?php __( 'Be a solution hero with huge rebates from SaveBigBread' ) ?></h1>
      <p><?php __( 'Welcome back and keep the savings pumping for your clients. The more they come back to SaveBigBread, the more they\'ll remember it was you that brought it to their attention and another reason they owe you a referral.' ) ?></p>
    <?php else: ?>
      <h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
      <p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates may interest your clients.' ) ?></p>
    <?php endif; ?>
  <?php endif; # empty( $location ) ?>
</div><!-- /#messages -->

<div id="my-locations" class="clearfix">
  <?php if( empty( $location ) ): ?>
    <h2><?php echo !User::agent() ? __( 'Add my first location', true ) : __( 'Add a location', true ) ?>:</h2>
    <div class="location-icon-large"></div>
    
    <?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ), 'class' => 'clearfix' ) ) ?>
      <?php if( User::agent() ): ?>
        <?php echo $this->element( '../buildings/_client_inputs' ) ?>
      <?php endif; ?>
      <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
    <?php echo $this->Form->end( __( 'Add location', true ) ) ?>
  <?php else: ?>
      <h2><?php __( 'My location' ) ?>:</h2>
    <div class="location-switch-wrapper clearfix">
      <?php echo $this->element( '../buildings/_location_switcher', array( 'locations' => $other_locations ) ) ?>
    </div>
    
    <div class="location-wrapper clearfix">
        <div class="location-icon"><?php # echo $i ?>1</div>
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

<?php if( !User::agent() ): # Pending quotes aren't useful for agents ?>
  <h2 class="my-rebates"><?php printf( __( 'Rebates for %s', true ), $location_title ) ?></h2>
  <?php if( empty( $technology_watch_list ) ): ?>
    <p class="message-empty-watchlist" style="margin-left: 10px"><?php __( 'Wondering why you don\'t see any rebates? It\'s because you haven\'t had a chance to identify any interests for this location. Scroll down to do just that.' ) ?></p>
  <?php endif; ?>
  
  <?php echo $this->element( '../technology_incentives/_list', array( 'rebates' => $rebates, 'watch_list' => $technology_watch_list, 'location_id' => $location['Building']['id'] ) ) ?>

  <?php //if( !empty( $pending_quotes ) ): ?>
    <form id="QuotesDashboardForm">
      <div id="pending-quotes" class="grid_9">
        <h2><?php printf( __( 'Pending quotes for %s', true ), $location_title ) ?></h2>
        <table class="pending quotes-list">
          <tr class="pending-quotes-category-row first">
            <td class="pending-quotes-category">
              <table class="pending-quotes-header">
                <tr class="">
                  <td class="quote-category"><a href="#" class="toggle collapsed"><span class="quote-category-title">Windows</span></a>&nbsp;(3)</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr> 
              </table>     
              <table class="pending-quotes-content">
                <tr>
                  <td class="contractor">Acme Air</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
                <tr>
                  <td class="contractor">Metropolitan Climate Control</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
                <tr>
                  <td class="contractor">Reliable Comfort Corps</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
              </table>    		
            </td>
          </tr>
          <tr class="pending-quotes-category-row">
            <td class="pending-quotes-category">
              <table class="pending-quotes-header">
                <tr class="even">
                  <td class="quote-category"><a href="#" class="toggle expanded"><span class="quote-category-title">Air Conditioners</span></a>&nbsp;(3)</td>
                  <td class="quote-date">3 weeks 2 days ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>      
              </table>     
              <table class="pending-quotes-content">
                <tr>
                  <td class="contractor">Acme Air</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
                <tr>
                  <td class="contractor">Metropolitan Climate Control</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
                <tr>
                  <td class="contractor">Reliable Comfort Corps</td>
                  <td class="quote-date">1 week ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active" selected="">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr class="pending-quotes-category-row last">
            <td class="pending-quotes-category">
              <table class="pending-quotes-header">
                <tr class="last odd">
                  <td class="quote-category"><a href="#" class="toggle collapsed"><span class="quote-category-title">Air Conditioners</span></a>&nbsp;(1)</td>
                  <td class="quote-date">3 months 11 days ago</td>
                  <td class="quote-status">
                    <select>
                      <option value="Active">Active</option>
                      <option value="On hold">On hold</option>
                      <option value="Closed" selected="">Closed</option>
                    </select>
                  </td>
                  <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
                </tr>
              </table>    		
            </td>
          </tr>
        </table>
      </div>
    </form>  
  <?php //endif; ?>
<?php endif; ?>
  
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
