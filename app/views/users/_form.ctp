<?php
/**
 * Defines the inputs shared across multiple user-registration screens.
 * This partial does not include all properties of a User because the
 * user_type property is displayed specially on the registration screen
 * and is not required at all for contractors (we know their user type
 * is contractor).
 */
?>

<?php echo $this->Form->input( 'User.first_name', array( 'placeholder' => 'Your first name' ) ) ?>
<?php echo $this->Form->input( 'User.last_name', array( 'placeholder' => 'Your last name' ) ) ?>
<?php echo $this->Form->input( 'User.email', array( 'placeholder' => 'e.g. user@example.com' ) ) ?>
<?php echo $this->Form->input( 'User.password' ) ?>
<?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
<?php echo $this->Form->input( 'User.zip_code' ) ?>

  
