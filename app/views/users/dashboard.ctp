<div id="messages" class="grid_9">
  <?php if( empty( $location ) ): ?>
    <h1><?php __( 'Congratulations!' ) ?></h1>
    <p><?php __( 'You now have a SaveBigBread profile. Scroll down to see what sorts of rebates you can find.' ) ?></p>
  <?php else: ?>
    <h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
    <p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?></p>
  <?php endif; ?>
</div><!-- /#messages -->

<div id="my-locations" class="grid_9">
  <?php if( empty( $location ) ): ?>
    <h2><?php __( 'Add my first location' ) ?>:</h2>
    <div class="location-icon-large"></div>
    
    <?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
      <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
    <?php echo $this->Form->end( __( 'Add location', true ) ) ?>
  <?php else: ?>
    <div class="clearfix">
      <?php echo $this->Html->link( sprintf( __( 'Add a location %s', true ), '&rsaquo;' ), array( 'controller' => 'buildings', 'action' => 'add' ), array( 'class' => 'add-location-button', 'escape' => false ) ) ?>
      <h2><?php __( 'My location' ) ?>:</h2>
    </div>
    
    <div class="location-wrapper clearfix">
        <div class="location-icon"><?php # echo $i ?>1</div>
        <h4><?php echo !empty( $location['Building']['name'] ) ? h( $location['Building']['name'] ) : h( $location['Address']['address_1'] ) ?></h4>
        <div class="location-address">
          <p><?php echo $this->element( 'address', array( 'address' => $location['Address'] ) ) ?></p>
          <?php echo $this->Html->link( __( 'edit', true ), array( 'controller' => 'buildings', 'action' => 'edit', $location['Building']['id'] ), array( 'class' => 'edit-button' ) ) ?>
          |
          <?php echo $this->Html->link( __( 'remove', true ), '#', array( 'class' => 'remove-button' ) ) ?>
        </div>
        <div class="location-equipment-grid grid_5">
          <table class="location-equipment">
            <?php if( !empty( $fixtures ) ): ?>
                <?php foreach( $fixtures as $i => $fixture ): ?>
                  <?php $classes = $i == 0 ? array( 'first' ) : array() ?>
                  <?php if( $i == count( $fixtures ) - 1 ): ?>
                    <?php array_push( $classes, 'last' ) ?>
                  <?php endif; ?>
                  <?php array_push( $classes, $i % 2 == 0 ? 'odd' : 'even' ) # Adjusted for zero-based array ?>
                  
                  <tr class="<?php echo join( ' ', $classes ) ?>">
                    <td class="model-name"><?php echo !empty( $fixture['Fixture']['name'] ) ? $fixture['Fixture']['name'] : Inflector::singularize( $fixture['Technology']['title'] ) ?></td>
                    <td class="controls">
                      <?php echo $this->Html->link( __( 'edit', true ), array( 'controller' => 'fixtures', 'action' => 'edit', $fixture['Fixture']['id'] ), array( 'class' => 'edit-button' ) ) ?>
                      |
                      <?php echo $this->Html->link( __( 'remove', true ), array( 'controller' => 'fixtures', 'action' => 'retire', $fixture['Fixture']['id'] ), array( 'class' => 'remove-button' ) ) ?>
                    </td>
                  </tr>
                  
                  <?php $i++ ?>
                <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td><?php __( 'No equipment has been added.' ) ?></td>
              </tr>
            <?php endif; ?>
          </table>
          
          <?php echo $this->Html->link( __( 'Add equipment', true ), array( 'controller' => 'fixtures', 'action' => 'add', $location['Building']['id'] ), array( 'class' => 'add-equipment-button' ) ) ?>
      </div><!-- /location-equipment-grid -->
    </div><!-- /location-wrapper -->
  <?php endif; ?>
</div><!-- /my-locations -->

<h2><?php printf( __( 'Rebates for %s', true ), $location_title ) ?></h2>
<?php if( !empty( $rebates ) ): ?>
  <?php echo $this->element( '../technology_incentives/_list', array( 'rebates' => $rebates, 'watch_list' => $technology_watch_list, 'location_id' => $location['Building']['id'] ) ) ?>
<?php else: ?>
  <p><?php __( 'Wondering why you don\'t see any rebates? It\'s because you haven\'t had a chance to identify any interests for this location. Scroll down to do just that.' ) ?></p>
<?php endif; ?>


<?php if( !empty( $pending_quotes ) ): ?>
  <div id="pending-quotes" class="grid_9">
    <h2><?php printf( __( 'Pending quotes for %s', true ), $location_title ) ?></h2>
    <table class="pending-quotes">
        <tr class="first odd">
          <td class="quote-category">Building Shell > Windows</td>
          <td class="quote-date">1 week ago</td>
          <td class="quote-status">Active</td>
          <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
        </tr>      
        <tr class="even">
          <td class="quote-category">Heating and Cooling > Air Conditioners</td>
          <td class="quote-date">3 weeks 2 days ago</td>
          <td class="quote-status">Active</td>
          <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
        </tr>      
        <tr class="last odd">
          <td class="quote-category">Heating and Cooling > Air Conditioners</td>
          <td class="quote-date">3 months 11 days ago</td>
          <td class="quote-status">Closed</td>
          <td class="quote-action"><a href="#" class="remove-button">remove</a></td>
        </tr>
    </table>
  </div>  
<?php endif; ?>

<div id="my-interests" class="grid_9">
	<h2><?php printf( __( 'My interests for %s', true ), $location_title ) ?></h2>
  <p class="instructions">
  	<?php __( 'Select as many categories of rebates as you like by clicking on the stars below.' ) ?>
  </p>
	
  <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => $technology_watch_list, 'location_id' => !empty( $location ) ? $location['Building']['id'] : false ) ) ?>
</div>

