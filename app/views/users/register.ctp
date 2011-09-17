<?php echo $this->Html->link( 'Dashboard', array( 'action' => 'dashboard' ) ) ?>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'value' => UserType::OWNER ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>
  
  <?php echo $this->element( '../users/_form' ) ?>

<?php echo $this->Form->end( 'Find my rebates' ) ?>
