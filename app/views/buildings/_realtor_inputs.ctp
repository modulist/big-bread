
<?php echo $this->Form->input( 'Realtor.first_name', array( 'label' => __( 'Realtor First Name', true ) ) ) ?>
<?php echo $this->Form->input( 'Realtor.last_name', array( 'label' => __( 'Realtor Last Name', true ) ) ) ?>
<?php echo $this->Form->input( 'Realtor.email', array( 'label' => __( 'Realtor Email', true ) ) ) ?>
<?php echo $this->Form->input( 'Realtor.user_type_id', array( 'type' => 'hidden', 'value' => User::TYPE_REALTOR ) ) ?>
          
