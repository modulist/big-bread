<div id="messages" class="grid_9">
	<h1><?php __( 'Add Equipment' ) ?></h1>
	<p><?php __( 'Did you know that Big Bread can also help you save big on appliances, doors, windows, and even HVAC systems?' ) ?></p>
</div><!-- /#messages -->

<?php echo $this->Form->create( 'Fixture' ) ?>
  <div id="my-equipment" class="grid_9">
    <div class="clearfix">
      <h2><?php printf( __( 'Add equipment to %s', true ), h( $location_name ) ) ?>:</h2>
    </div>
    
    <div class="equipment-wrapper clearfix">
      <div class="location-icon">&nbsp</div>
      <div class="location-equipment">
        <h4><?php __( 'Equipment type' ) ?></h4>
        
        <?php echo $this->Form->input( 'Fixture.technology_id', array( 'label' => false, 'empty' => __( 'Select One', true ) ) ) ?>        
        
        <h4><?php __( 'Specifics' ) ?></h4>
        <div class="grid_4">
          <?php echo $this->Form->input( 'Fixture.make' ) ?>
          <?php echo $this->Form->input( 'Fixture.model', array( 'label' => __( 'Model (from equipment tag)', true ) ) ) ?>
          <?php echo $this->Form->input( 'Fixture.serial_number', array( 'label' => __( 'Serial Number (from equipment tag)', true ) ) ) ?>
          <?php echo $this->Form->input( 'Fixture.service_in', array( 'type' => 'text', 'label' => __( 'Year Installed', true ), 'between' => '<div id="slider"></div>' ) ) ?>
          <?php echo $this->Form->input( 'Fixture.notes' ) ?>          
        </div><!-- /grid-4 -->
        
        <h4><?php __( 'Attach a file' ) ?></h4>
        <p class="small"><?php __( 'You can attach invoices, a product manual, or anything else.' ) ?></p>
        <div class="choose-button"><p><?php __( 'Choose a file' ) ?></p></div>
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
                  <?php echo !empty( $fixture['Fixture']['name'] ) ? h( $fixture['Fixture']['name'] ) : sprintf( '%s %s', h( $fixture['Fixture']['model'] ), h( $fixture['Technology']['name'] ) ) ?>
                </td>
                <td class="controls">
                  <a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
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
<?php echo $this->Form->end( sprintf( __( 'Add to %s', true ), $location_name ) ) ?>





