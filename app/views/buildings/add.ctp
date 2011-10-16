<div id="messages" class="grid_9">
	<h1><?php __( 'Add a new location' ) ?></h1>
	<p><?php __( 'to save on major home improvement projects, or simply when replacing an appliance.' ) ?></p>
</div><!-- /#messages -->

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
  <div class="clearfix">
    <h2><?php __( 'About your location:' ) ?></h2>
  </div>
  <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
  
  <div class="clearfix">
    <h2><?php __( 'Utilities for your location:' ) ?></h2>
  </div>
  <?php echo $this->element( '../buildings/_utility_inputs' ) ?>
<?php echo $this->Form->end( __( 'Add location', true ) ) ?>