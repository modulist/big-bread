
  <div id="my-equipment" class="grid_9">
    <div class="clearfix">
      <h2><?php printf( __( '%s equipment at %s', true ), ucwords( $this->action ), h( $location_name ) ) ?>:</h2>
    </div>
    
    <div class="equipment-wrapper clearfix">
      <div class="location-icon">&nbsp</div>
      <div class="location-equipment">
        <h4><?php __( 'Equipment type' ) ?></h4>
        
        <?php echo $this->Form->create( 'Fixture', array( 'url' => array( 'action' => $this->action, $action_param ) ) ) ?>
          <?php echo $this->Form->input( 'Fixture.id' ) ?>
          <?php echo $this->Form->input( 'Fixture.building_id', array( 'type' => 'hidden', 'value' => $location['Building']['id'] ) ) ?>
        
          <?php echo $this->Form->input( 'Fixture.technology_id', array( 'label' => false, 'empty' => __( 'Select One', true ) ) ) ?>
          
          <h4><?php __( 'Specifics' ) ?></h4>
          <div class="grid_4">
            <?php echo $this->Form->input( 'Fixture.name' ) ?>
            <?php echo $this->Form->input( 'Fixture.make' ) ?>
            <?php echo $this->Form->input( 'Fixture.model', array( 'label' => __( 'Model (from equipment tag)', true ) ) ) ?>
            <?php echo $this->Form->input( 'Fixture.serial_number', array( 'label' => __( 'Serial Number (from equipment tag)', true ) ) ) ?>
            <?php echo $this->Form->input( 'Fixture.purchase_price', array( 'placeholder' => '1200.00', 'after' => '<small>' . __( 'Provide the purchase price net of manufacturer and contractor discounts. Do not deduct utility rebates and tax credits from the total.', true ) . '</small>' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.service_in', array( 'type' => 'text', 'label' => __( 'Year Installed', true ), 'between' => '<div id="slider"></div>' ) ) ?>
            <?php echo $this->Form->input( 'Fixture.notes' ) ?>          
          </div><!-- /grid-4 -->
          
          <h4><?php __( 'Attach a file' ) ?></h4>
          <p class="small"><?php __( 'You can attach invoices, a product manual, or anything else.' ) ?></p>
          <div class="choose-button"><p><?php __( 'Choose a file' ) ?></p></div>
        <?php echo $this->Form->end( sprintf( __( 'Add to %s', true ), $location_name ) ) ?>
      </div><!-- /location-equipment-->	
        
      <div class="add-equipment-grid grid_3">
        <div class="clearfix">
          <div class="current-equipment-icon"></div>
          <div class="current-equipment-title"><?php printf( __( 'Equipment for %s', true ), h( $location_name ) ) ?></div>
        </div>
        <table class="current-equipment">
          <?php if( !empty( $fixtures ) ): ?>
            <?php foreach( $fixtures as $i => $fixture) : ?>
              <tr class="<?php echo $i % 2 == 0 ? 'even' : 'odd' ?>">
                <td class="model-name">
                  <?php echo !empty( $fixture['Fixture']['name'] ) ? h( $fixture['Fixture']['name'] ) : sprintf( '%s %s', h( $fixture['Fixture']['make'] ), h( Inflector::singularize( $fixture['Technology']['name'] ) ) ) ?>
                </td>
                <td class="controls">
                  <?php echo $this->Html->link( __( 'edit', true ), array( 'action' => 'edit', $fixture['Fixture']['id'] ), array( 'class' => 'edit-button' ) ) ?>
                  |
                  <?php echo $this->Html->link( __( 'remove', true ), array( 'controller' => 'fixtures', 'action' => 'retire', $fixture['Fixture']['id'] ), array( 'class' => 'remove-button' ) ) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td><?php __( 'No equipment has been added.' ) ?></td>
            </tr>
          <?php endif; ?>
        </table>
      </div><!-- /location-equipment-grid -->
    </div><!-- /location-wrapper -->
      
  </div><!-- /my-equipment -->