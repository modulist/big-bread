<?php echo $this->Form->input( 'Building.client_id', array( 'type' => 'hidden', 'value' => $this->Session->read( 'Auth.User.id' ) ) ) ?>
<?php echo $this->Form->input( 'Building.name', array( 'placeholder' => __( 'Main House', true ), 'label' => __( 'Name this location', true ) ) ) ?>
<?php echo $this->Form->input( 'Address.address_1', array( 'placeholder' => __( 'Street Address', true ) ) ) ?>
<?php echo $this->Form->input( 'Address.address_2', array( 'placeholder' => __( 'Apartment, Suite, etc.', true ) ) ) ?>
<?php echo $this->Form->input( 'Address.zip_code', array( 'placeholder' => __( 'Zip Code', true ), 'after' => sprintf( __( '%sWe\'ll find your city and state%s', true ), '<small>', '</small>' ) ) ) ?>

