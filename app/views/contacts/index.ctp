<?php $this->set( 'title_for_layout', __( 'Feedback', true ) ) ?>
<?php echo $this->Form->create( 'Contact' ) ?>
  <?php echo $this->Form->input( 'Contact.name' ) ?>
  <?php echo $this->Form->input( 'Contact.email' ) ?>
  <?php echo $this->Form->input( 'Contact.company' ) ?>
  <?php echo $this->Form->input( 'Contact.phone_number' ) ?>
  <?php echo $this->Form->input( 'Contact.zip_code' ) ?>
  <?php echo $this->Form->input( 'Contact.user_type', array( 'empty' => 'Select one...' ) ) ?>
  <?php echo $this->Form->input( 'Contact.message' ) ?>
<?php echo $this->Form->end( 'Send' ) ?>
