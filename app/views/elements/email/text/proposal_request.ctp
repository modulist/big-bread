<?php __( 'Please contact me to prepare an estimate for the following services:' ) ?>
    
<?php __( 'Scope of Work' ) ?>
-------------------------------------------------------------------------------
<?php echo h( $proposal['scope_of_work'] ) ?>

<?php __( 'Contact Information' ) ?>
-------------------------------------------------------------------------------
<?php echo h( $location['address_1'] ) ?>
<?php echo !empty( $location['address_2'] ) ? h( $location['address_2'] ) : false ?>
<?php printf( '%s, %s, %s', h( $location['city'] ), h( $location['state'] ), h( $location['zip_code'] ) ) ?>

<?php echo h( $sender['phone_number'] ) ?>
<?php echo h( $sender['email'] ) ?>

<?php __( 'Contractor is responsible for reserving rebate funds with the program sponsor.' ) ?>

<?php printf( __( 'This work %s covered by a warranty.', true ), $proposal['under_warranty'] ? __( 'is', true ) : __( 'is not', true ) ) ?>
<?php printf( __( 'You %s permission to examine the equipment.', true ), $proposal['permission_to_examine'] ? 'have' : 'do not have' ) ?>

<?php __( 'Existing Equipment' ) ?>
-------------------------------------------------------------------------------
%Fixture.existing%

<?php __( 'Customer Notes' ) ?>
-------------------------------------------------------------------------------
<?php echo !empty( $proposal['notes'] ) ? h( $proposal['notes'] ) : __( 'None provided.', true ) ?>

<?php __( 'Quoted Incentive' ) ?>
-------------------------------------------------------------------------------
<?php printf( '%s%s%s', $rebate['amount_type']['code'] == 'USD' ? $rebate['amount_type']['symbol'] : false, $rebate['amount'], $rebate['amount_type']['code'] != 'USD' ? $rebate['amount_type']['symbol'] : false ) ?>
<?php echo h( $rebate['name'] ) ?>

<?php __( 'Stacked Incentives' ) ?>
-------------------------------------------------------------------------------
%TechnologyIncentive.stack%