<h1>Log in to SaveBigBread</h1>

<?php echo $this->Form->create( 'User', array ( 'action' => 'login', 'inputDefaults' => array( 'error' => false ) ) ) ?>
  <?php echo $this->Form->input( 'User.email', array( 'autofocus' => 'true' ) ) ?>
  <?php echo $this->Form->input( 'User.password', array( 'after' => __( ' Password is case sensitive', true ) ) ) ?>
<?php echo $this->Form->end( 'Login' ) ?>

<?php echo $this->Html->link( __( 'Forgot password? Click here.', true ), array( 'action' => 'forgot_password' ), array( 'id' => 'forgot-password', 'class' => 'iframe' ) ) ?>
