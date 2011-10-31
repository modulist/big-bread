<div id="messages">
	<h1><?php echo $headline ?></h1>
	<p><?php echo $intro ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'url' => sprintf( '/%s/signup', strtolower( Inflector::pluralize( UserType::$lookup[$user_type_id] ) ) ) ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'default' => $user_type_id ) ) ?><!-- <?php echo UserType::$lookup[$user_type_id] ?> -->
  
  <div id="user-registration">
  	<?php echo $this->element( '../users/_form', array( 'show_zip_code' => false ) ) ?>
  </div>
<?php echo $this->Form->end( __( 'Let\'s go!', true ) ) ?>
