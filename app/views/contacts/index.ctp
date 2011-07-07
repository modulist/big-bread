<?php $this->set( 'title_for_layout', __( 'Feedback', true ) ) ?>
<?php echo $this->Form->create( 'Contact', array( 'url' => '/feedback' ) ) ?>
  <?php echo $this->Form->input( 'Contact.full_name' ) ?>
  <?php echo $this->Form->input( 'Contact.email' ) ?>
  <?php echo $this->Form->input( 'Contact.company' ) ?>
  <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'Contact', 'field' => 'phone_number', 'required' => false ) ) ?>
  <?php # echo $this->Form->input( 'Contact.phone_number' ) ?>
  <?php echo $this->Form->input( 'Contact.zip_code' ) ?>
  <?php echo $this->Form->input( 'Contact.user_type', array( 'empty' => 'Select one...' ) ) ?>
  <?php echo $this->Form->input( 'Contact.message' ) ?>
<?php echo $this->Form->end( 'Send' ) ?>
