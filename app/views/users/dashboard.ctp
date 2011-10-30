<div id="messages">
  <?php if( empty( $location ) ): ?>
    <h1><?php __( 'Congratulations!' ) ?></h1>
    <p><?php printf( __( 'You now have a SaveBigBread profile. Scroll down to see what sorts of rebates you can find%s.', true ), User::agent() ? __( ' for your client', true ) : false ) ?></p>
  <?php else: ?>
    <h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
    <p>
      <?php if( !User::agent() ): ?>
        <?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?>
      <?php else: ?>
        <?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates may interest your clients.' ) ?>
      <?php endif; ?>
    </p>
  <?php endif; ?>
</div><!-- /#messages -->

<div id="my-locations" class="clearfix">
  <?php if( empty( $location ) ): ?>
    <h2><?php __( 'Add my first location' ) ?>:</h2>
    <div class="location-icon-large"></div>
    
    <?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ), 'class' => 'clearfix' ) ) ?>
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

<div id="my-interests" class="grid_9">
	<h2><?php printf( __( 'My interests for %s', true ), $location_title ) ?></h2>
  <p class="instructions">
    <?php if( !User::agent() ): ?>
      <?php __( 'Select as many categories of rebates as you like by clicking on the stars below.' ) ?>
    <?php else: ?>
      <?php __( 'Select the categories that you believe your client should consider.' ) ?>
    <?php endif; ?>
  </p>
	
  <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => $technology_watch_list, 'location_id' => !empty( $location ) ? $location['Building']['id'] : false ) ) ?>
</div>

