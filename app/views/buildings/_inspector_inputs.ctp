<?php echo $this->Form->input( 'Inspector.first_name', array( 'label' => __( 'Inspector First Name', true ) ) ) ?>
<?php echo $this->Form->input( 'Inspector.last_name', array( 'label' => __( 'Inspector Last Name', true ) ) ) ?>
<?php echo $this->Form->input( 'Inspector.email', array( 'label' => __( 'Inspector Email', true ) ) ) ?>
<?php echo $this->Form->input( 'Inspector.user_type_id', array( 'type' => 'hidden', 'value' => User::TYPE_INSPECTOR ) ) ?>
