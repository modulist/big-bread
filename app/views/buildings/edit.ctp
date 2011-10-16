<div id="messages" class="grid_9">
	<h1><?php __( 'Edit a location' ) ?></h1>
	<p><?php __( 'to save on major home improvement projects, or simply when replacing an appliance.' ) ?></p>
</div><!-- /#messages -->

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'edit' ) ) ) ?>
  <div class="clearfix">
    <h2><?php __( 'About your location:' ) ?></h2>
  </div>
  
  <div id="my-locations" class="grid_9">
    <div class="location-wrapper clearfix">
      <div class="location-icon-large"></div>
      <div class="grid_4">
        <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
      </div><!-- /grid-4 -->	
    </div><!-- /location-wrapper -->
  </div><!-- /my-locations -->

  <div class="clearfix">
    <h2><?php __( 'Utilities for your location:' ) ?></h2>
  </div>
  
  <div class="utilities-wrapper clearfix">
    <div class="utilities-icon"></div>
      <div class="grid_4">
        <?php echo $this->element( '../buildings/_utility_inputs' ) ?>
      </div><!-- /grid-4 -->
    </div><!-- /utilities-wrapper -->
  </div><!-- /my-utilities -->
<?php echo $this->Form->end( __( 'Add location', true ) ) ?>