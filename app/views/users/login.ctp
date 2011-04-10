<h1>LOGIN</h1>

<?php echo $this->Form->create( 'User', array ( 'action' => 'login', 'inputDefaults' => array( 'error' => false ) ) ) ?>
  <?php echo $this->Form->input( 'User.email' ) ?>
  <?php echo $this->Form->input( 'User.password' ) ?>
<?php echo $this->Form->end( 'Login' ) ?>
