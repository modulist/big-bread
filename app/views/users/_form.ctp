<?php
/**
 * Defines the inputs shared across multiple user-registration screens.
 * This partial does not include all properties of a User because the
 * user_type property is displayed specially on the registration screen
 * and is not required at all for contractors (we know their user type
 * is contractor).
 */
?>
<h2>Now, let&#146;s create your Big Bread account:</h2>
<p><span class="input text required">*</span> Indicates required fields</p>
<div class="clearfix">
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.first_name', array( 'placeholder' => 'Your first name' ) ) ?>
	</div>
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.last_name', array( 'placeholder' => 'Your last name' ) ) ?>
	</div>
</div>
<div class="clearfix">
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.email', array( 'placeholder' => 'e.g. user@example.com' ) ) ?>
	</div>
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.password' ) ?>
		<?php //echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
	</div>
</div>

<div class="clearfix">
	<div class="grid_3 zip-code">
		<?php echo $this->Form->input( 'User.zip_code' ) ?>
	</div>
</div>


  
