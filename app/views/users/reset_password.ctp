<div id="messages">
	<h1><?php __( 'Reset your password' ) ?></h1>
	<p><?php __ ( 'We\'ve reset your password at your request. Please enter a new password to access the savings.' ) ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'url' => array( 'action' => 'reset_password', $invite_code ) ) ) ?>
  <?php echo $this->Form->input( 'User.id', array( 'type' => 'hidden' ) ) ?>
  <div id="user-registration">
  	<?php echo $this->Form->input( 'User.password' ) ?>
  	<?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
  </div>
<?php echo $this->Form->end( __( 'Reset my password', true ) ) ?>
