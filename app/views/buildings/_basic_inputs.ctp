<?php echo $this->Form->input( 'Building.client_id', array( 'type' => 'hidden', 'value' => $this->Session->read( 'Auth.User.id' ) ) ) ?>
<?php echo $this->Form->input( 'Address.id', array( 'type' => 'hidden' ) ) ?>
<?php echo $this->Form->input( 'Building.name', array( 'div' => array( 'input text required location-name' ), 'placeholder' => __( 'Main House', true ), 'label' => __( 'Name this location', true ) ) ) ?>
<?php echo $this->Form->input( 'Address.address_1', array( 'placeholder' => __( 'Street Address', true ), 'div' => 'input text required address-1' ) ) ?>
<div class="clearfix">
  <?php echo $this->Form->input( 'Address.address_2', array( 'placeholder' => __( 'Apartment, Suite, etc.', true ), 'div' => 'input text address-2' ) ) ?>
  <?php echo $this->Form->input( 'Address.zip_code', array( 'placeholder' => __( 'Zip Code', true ), 'div' => 'input text required zip-code', 'after' => sprintf( __( '%sWe\'ll find your city and state for you%s', true ), '<small>', '</small>' ) ) ) ?>
</div>
