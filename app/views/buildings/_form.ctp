<?php $short = isset( $short) ? $short : false ?>
<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
	<div id="my-locations" class="grid_9">
		<div class="clearfix">
			<h2>About your location:</h2>
		</div>
		<div class="location-wrapper clearfix">
			<div class="location-icon-large"></div>
			<div class="grid_4">
			  <?php echo $this->Form->input( 'Building.client_id', array( 'type' => 'hidden', 'value' => $this->Session->read( 'Auth.User.id' ) ) ) ?>
			  <?php echo $this->Form->input( 'Building.name', array( 'placeholder' => 'Main House', 'label' => 'Name this location' ) ) ?>
			  <?php echo $this->Form->input( 'Address.address_1', array( 'placeholder' => 'Street Address' ) ) ?>
			  <?php echo $this->Form->input( 'Address.address_2', array( 'placeholder' => 'Apartment, Suite, etc.' ) ) ?>
			  <?php echo $this->Form->input( 'Address.zip_code', array( 'placeholder' => 'Zip Code', 'after' => sprintf( __( '%sWe\'ll find your city and state%s', true ), '<small>', '</small>' ) ) ) ?>
			</div><!-- /grid-4 -->	
		</div><!-- /location-wrapper -->
	</div><!-- /my-locations -->
  
  <?php if( !$short ): ?>
		<div id="my-utilities" class="grid_9">
			<div class="clearfix">
				<h2>Utilities for your location:</h2>		
			</div>
			<div class="utilities-wrapper clearfix">
				<div class="utilities-icon"></div>
					<div class="grid_4">

				    <?php echo $this->Form->input( 'Building.electricity_provider_name', array( 'type' => 'text' ) ) ?>
				    <?php echo $this->Form->input( 'Building.electricity_provider_id', array( 'type' => 'hidden' ) ) ?>
				    
				    <?php echo $this->Form->input( 'Building.gas_provider_name', array( 'type' => 'text' ) ) ?>
				    <?php echo $this->Form->input( 'Building.gas_provider_id', array( 'type' => 'hidden' ) ) ?>
				    
				    <?php echo $this->Form->input( 'Building.water_provider_name', array( 'type' => 'text' ) ) ?>
				    <?php echo $this->Form->input( 'Building.water_provider_id', array( 'type' => 'hidden' ) ) ?>

					</div><!-- /grid-4 -->	
				</div><!-- /utilities-wrapper -->
		</div><!-- /my-utilities -->
  <?php endif; ?>
<?php echo $this->Form->end( 'Add location' ) ?>
