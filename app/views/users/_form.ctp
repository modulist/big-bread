<?php
/**
 * Defines the inputs shared across multiple user-registration screens.
 * This partial does not include all properties of a User because the
 * user_type property is displayed specially on the registration screen
 * and is not required at all for contractors (we know their user type
 * is contractor).
 */
?>
<h2><?php __( 'Let&#146;s create your SaveBigBread account:' ) ?></h2>
<div class="clearfix">
	<div class="grid_3 first">
		<?php echo $this->Form->input( 'User.first_name', array( 'placeholder' => 'Your first name' ) ) ?>
	</div>
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.last_name', array( 'placeholder' => 'Your last name' ) ) ?>
	</div>
	<div class="grid_3 last">
		<?php echo $this->Form->input( 'User.email', array( 'placeholder' => 'e.g. user@example.com' ) ) ?>
	</div>
</div>
<div class="clearfix">
	<div class="grid_3 first">
		<?php echo $this->Form->input( 'User.password' ) ?>
	</div>
	<div class="grid_3 last">
		<?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
	</div>
</div>

<div class="clearfix">
	<div class="grid_3 first zip-code">
		<?php echo $this->Form->input( 'User.zip_code', array( 'default' => $this->Session->read( 'default_zip_code' ) ) ) ?>
	</div>
	<div class="grid_3 last zip-code-instructions">
		<p><?php __( 'So we can find you rebates and discounts specific to your area.' ) ?></p>
	</div>
</div>


  
