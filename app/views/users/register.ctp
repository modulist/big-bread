<h1>Register</h1>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'radio', 'legend' => 'Primary Role' ) ) ?>
  <?php echo $this->Form->input( 'User.first_name' ) ?>
  <?php echo $this->Form->input( 'User.last_name' ) ?>
  <?php echo $this->Form->input( 'User.email' ) ?>
  <?php echo $this->Form->input( 'User.phone_number' ) ?>
  <?php echo $this->Form->input( 'User.password' ) ?>
  <?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
<?php echo $this->Form->end( 'Register' ) ?> or <?php echo $this->Html->link( 'Cancel', '/' ) ?>
