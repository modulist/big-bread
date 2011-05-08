<?php if( empty( $this->data ) ): ?>
  <h1>Forgot Password</h1>
  
  <p>Enter the email address that you registered with. We\'ll send you an
    email with a link to reset your password.</p>
  
  <?php echo $this->Form->create( 'User', array ( 'inputDefaults' => array( 'error' => false ) ) ) ?>
    <?php echo $this->Form->input( 'User.email' ) ?>
  <?php echo $this->Form->end( 'Reset Password' ) ?>
<?php endif; ?>
