<?php $short = isset( $short) ? $short : false ?>

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
  <?php echo $this->Form->input( 'Building.client_id', array( 'type' => 'hidden', 'value' => $this->Session->read( 'Auth.User.id' ) ) ) ?>
  <?php echo $this->Form->input( 'Building.name', array( 'placeholder' => 'Primary Residence' ) ) ?>
  <?php echo $this->Form->input( 'Address.address_1', array( 'placeholder' => 'Street Address' ) ) ?>
  <?php echo $this->Form->input( 'Address.address_2', array( 'placeholder' => 'Apartment, Suite, etc.' ) ) ?>
  <?php echo $this->Form->input( 'Address.zip_code', array( 'placeholder' => 'Zip Code', 'after' => sprintf( __( '%sWe\'ll find your city and state%s', true ), '<small>', '</small>' ) ) ) ?>
  
  <?php if( !$short ): ?>
    <?php echo $this->Form->input( 'Building.electricity_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.electricity_provider_id', array( 'type' => 'hidden' ) ) ?>
    
    <?php echo $this->Form->input( 'Building.gas_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.gas_provider_id', array( 'type' => 'hidden' ) ) ?>
    
    <?php echo $this->Form->input( 'Building.water_provider_name', array( 'type' => 'text' ) ) ?>
    <?php echo $this->Form->input( 'Building.water_provider_id', array( 'type' => 'hidden' ) ) ?>
  <?php endif; ?>
<?php echo $this->Form->end( 'Add location' ) ?>
