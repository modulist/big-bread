<?php echo $this->Form->input( 'Client.user_type_id', array( 'type' => 'hidden', 'default' => UserType::$reverse_lookup['HOMEOWNER'] ) ) ?>
<?php echo $this->Form->input( 'Client.first_name', array( 'label' => __( 'Your client\'s first name', true ) ) ) ?>
<?php echo $this->Form->input( 'Client.last_name', array( 'label' => __( 'Your client\'s last name', true ) ) ) ?>
<?php echo $this->Form->input( 'Client.email', array( 'label' => __( 'Your client\'s email address', true ) ) ) ?>