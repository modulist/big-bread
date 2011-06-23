<?php
/**
 * Defines the inputs shared across multiple user-registration screens.
 * This partial does not include all properties of a User because the
 * user_type property is displayed specially on the registration screen
 * and is not required at all for contractors (we know their user type
 * is contractor).
 */
?>

<?php echo $this->Form->input( 'User.first_name', array( 'div' => 'input text required', 'placeholder' => 'Your first name' ) ) ?>
<?php echo $this->Form->input( 'User.last_name', array( 'div' => 'input text required', 'placeholder' => 'Your last name' ) ) ?>
<?php echo $this->Form->input( 'User.email', array( 'div' => 'input text required', 'placeholder' => 'e.g. user@example.com' ) ) ?>
<?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'User', 'field' => 'phone_number', 'required' => false ) ) ?>
<?php echo $this->Form->input( 'User.password', array( 'div' => 'input password required' ) ) ?>
<?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password', 'div' => 'input password required' ) ) ?>
  
