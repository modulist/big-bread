<div id="messages">
	<h1><?php __( 'Update your profile' ) ?></h1>
	<p><?php __( 'We\'ll keep you posted on how to SaveBigBread.' ) ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'id' => 'UserRegisterForm' ) ) ?>
  <div id="user-registration">
    <?php $password = $this->Session->read( 'Auth.user.password' ); ?>
  	<?php echo $this->element( '../users/_form', array( 'title' => false, 'show_zip_code' => !empty( $password ) ) ) ?>
  </div>
<?php echo $this->Form->end( __( 'Update my profile', true ) ) ?>
