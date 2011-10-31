<div id="messages">
	<h1><?php __( 'Update your profile' ) ?></h1>
	<p><?php __ ( 'Go ahead, it don\'t cost nothin\'' ) ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'id' => 'UserRegisterForm' ) ) ?>
  <div id="user-registration">
  	<?php echo $this->element( '../users/_form', array( 'title' => false, 'show_zip_code' => !User::agent() ) ) ?>
  </div>
<?php echo $this->Form->end( __( 'Update my profile', true ) ) ?>
