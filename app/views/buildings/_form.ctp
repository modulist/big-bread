<?php $short = isset( $short) ? $short : false ?>

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
	<div id="my-locations" class="grid_9">
		<div class="location-wrapper clearfix">
			<div class="location-icon-large"></div>
			<div class="grid_4">
			  <?php echo $this->Form->input( 'Building.client_id', array( 'type' => 'hidden', 'value' => $this->Session->read( 'Auth.User.id' ) ) ) ?>
			  <?php echo $this->Form->input( 'Building.name', array( 'placeholder' => __( 'Main House', true ), 'label' => __( 'Name this location', true ) ) ) ?>
			  <?php echo $this->Form->input( 'Address.address_1', array( 'placeholder' => __( 'Street Address', true ) ) ) ?>
			  <?php echo $this->Form->input( 'Address.address_2', array( 'placeholder' => __( 'Apartment, Suite, etc.', true ) ) ) ?>
			  <?php echo $this->Form->input( 'Address.zip_code', array( 'placeholder' => __( 'Zip Code', true ), 'after' => sprintf( __( '%sWe\'ll find your city and state%s', true ), '<small>', '</small>' ) ) ) ?>
			</div><!-- /grid-4 -->	
		</div><!-- /location-wrapper -->
	</div><!-- /my-locations -->
  
  <?php if( !$short ): ?>
		<div id="my-utilities" class="grid_9">
			<div class="clearfix">
				<h2><?php __( 'Utilities for your location:' ) ?></h2>		
			</div>
			<div class="utilities-wrapper clearfix">
				<div class="utilities-icon"></div>
					<div class="grid_4">
				    <?php echo $this->Form->input( 'ElectricityProvider.name', array( 'label' => __( 'Electricity Provider', true ) ) ) ?>
				    <?php echo $this->Form->input( 'ElectricityProvider.id' ) ?>
				    
				    <?php echo $this->Form->input( 'GasProvider.name', array( 'label' => __( 'Gas Provider', true ) ) ) ?>
				    <?php echo $this->Form->input( 'GasProvider.id' ) ?>
				    
				    <?php echo $this->Form->input( 'WaterProvider.name', array( 'label' => __( 'Water Provider', true ) ) ) ?>
				    <?php echo $this->Form->input( 'WaterProvider.id' ) ?>
					</div><!-- /grid-4 -->	
				</div><!-- /utilities-wrapper -->
		</div><!-- /my-utilities -->
  <?php endif; ?>
<?php echo $this->Form->end( __( 'Add location', true ) ) ?>
