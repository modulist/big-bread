  <div id="my-equipment">
    <div class="clearfix">
      <h2><?php printf( __( '%s equipment at %s', true ), ucwords( $this->action ), h( $location_name ) ) ?>:</h2>
      <div class="location-switch-wrapper clearfix">
      	<?php echo $this->element( '../buildings/_location_switcher', array( 'locations' => $other_locations ) ) ?>
	    </div><!-- /location-switcher -->
    </div>
    
    <div class="equipment-wrapper clearfix">
      <div class="location-icon"></div>
      <div class="location-equipment">
        <h4><?php __( 'Equipment type' ) ?></h4>
        
        <?php echo $this->Form->create( 'Fixture', array( 'url' => array( 'action' => $this->action, $action_param ) ) ) ?>
          <?php echo $this->Form->input( 'Fixture.id' ) ?>
          <?php echo $this->Form->input( 'Fixture.building_id', array( 'type' => 'hidden', 'value' => $location['Building']['id'] ) ) ?>
        
          <?php echo $this->Form->input( 'Fixture.technology_id', array( 'label' => false, 'empty' => __( 'Select One', true ) ) ) ?>
          
          <h4><?php __( 'Specifics' ) ?></h4>
          <div class="grid_4">
            <?php echo $this->Form->input( 'Fixture.name', array( 'class' => 'tooltip', 'title' => 'Example: Downstairs Refrigerator' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.make', array( 'class' => 'tooltip', 'title' => 'Example: Whirlpool' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.model', array( 'label' => __( 'Model (from equipment tag)', true ) ) ) ?>
            <?php echo $this->Form->input( 'Fixture.serial_number', array( 'label' => __( 'Serial Number', true ) ) ) ?>
            <?php echo $this->Form->input( 'Fixture.outside_unit', array( 'type' => 'radio', 'options' => array( __( 'Inside unit', true ), __( 'Outside unit', true ) ), 'default' => 0, 'legend' => __( 'Unit location (for dual unit fixtures)', true ), 'div' => array( 'class' => 'input radio hidden' ) ) ) ?>
            <?php echo $this->Form->input( 'Fixture.purchase_price', array( 'class' => 'tooltip', 'title' => 'Example: 1200.00', 'after' => '<small>' . __( 'Provide the purchase price net of manufacturer and contractor discounts. Do not deduct utility rebates and tax credits from the total.', true ) . '</small>' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.service_in', array( 'type' => 'text', 'label' => __( 'Year Installed', true ), 'between' => '<div id="slider"></div>' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.notes' ) ?>          
          </div><!-- /grid-4 -->
          
          <?php /* ?>
          <h4><?php __( 'Attach a file' ) ?></h4>
          <p class="small"><?php __( 'You can attach invoices, a product manual, or anything else.' ) ?></p>
          <div class="choose-button"><p><?php __( 'Choose a file' ) ?></p></div>
          <?php */ ?>
        <?php echo $this->Form->end( sprintf( __( 'Add to %s', true ), $location_name ) ) ?>
        <?php echo $this->Html->link( __( 'Cancel', true ), array( 'action' => 'add', $location['Building']['id'] ) ) ?>
      </div><!-- /location-equipment-->	
        
      <div class="equipment-tag grid_3">
        <?php echo $this->Html->image( 'sticker-sm.jpg', array( 'alt' => 'Sample equipment tag' ) ) ?>
    		<small><?php __( 'Do not open the cabinet of any equipment while the unit is in operation or if it creates a safety issue or violates a warranty requirement.' ) ?></small>
    	</div>

      <div class="add-equipment-grid grid_3">
        <div class="clearfix">
          <div class="current-equipment-icon"></div>
          <div class="current-equipment-title"><?php printf( __( 'Equipment for %s', true ), h( $location_name ) ) ?></div>
        </div>

        <?php echo $this->element( '../fixtures/_list', array( 'plugin' => false, 'fixtures' => $fixtures ) ) ?>
      </div><!-- /location-equipment-grid -->
    </div><!-- /location-wrapper -->
  </div><!-- /my-equipment -->