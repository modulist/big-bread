<h1><?php __( 'Forgot Password' ) ?></h1>

<p><?php __( 'Enter the email address that you registered with. We\'ll send you an email with a link to reset your password.' ) ?></p>

<?php echo $this->Form->create( 'User' ) ?>
  <?php echo $this->Form->input( 'User.email', array( 'autofocus' => 'true' ) ) ?>
<?php echo $this->Form->end( __( 'Reset Password', true ) ) ?>
