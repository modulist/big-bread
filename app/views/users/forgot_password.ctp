<h1><?php __( 'Forgot Password' ) ?></h1>

<p><?php __( 'Enter your email address and click the "Reset Password" button to reset your password. SaveBigBread will send the new password instructions to your email address.' ) ?></p>

<?php echo $this->Form->create( 'User' ) ?>
  <?php echo $this->Form->input( 'User.email', array( 'autofocus' => 'true' ) ) ?>
<?php echo $this->Form->end( __( 'Reset Password', true ) ) ?>
