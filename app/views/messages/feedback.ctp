<?php $this->set( 'title_for_layout', __( 'Help Us Improve', true ) ) ?>

<?php echo $this->Form->create( 'Message', array( 'url' => '/feedback' ) ) ?>
  <?php echo $this->Form->input( 'Sender.full_name' ) ?>
  <?php echo $this->Form->input( 'Sender.email' ) ?>
  <?php echo $this->Form->input( 'Sender.company' ) ?>
  <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'Sender', 'field' => 'phone_number', 'required' => false ) ) ?>
  <?php echo $this->Form->input( 'Sender.zip_code' ) ?>
  <?php echo $this->Form->input( 'Sender.user_type_id', array( 'empty' => 'Select one...' ) ) ?>
  <?php echo $this->Form->input( 'Message.message', array( 'type' => 'textarea' ) ) ?>
<?php echo $this->Form->end( 'Send' ) ?>
