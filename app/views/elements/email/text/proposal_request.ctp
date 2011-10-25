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

<?php printf( __( 'Existing %s', true ), __n( Inflector::singularize( $technology['title'] ), Inflector::pluralize( $technology['title'] ), count( $fixtures ), true ) ) ?>
-------------------------------------------------------------------------------
<?php if( !empty( $fixtures ) ): ?>
  <?php foreach( $fixtures as $fixture ): ?>
    <?php printf( '%s %s', $fixture['Fixture']['make'], $fixture['Fixture']['model'] ) ?>
  <?php endforeach; ?>
<?php else: ?>
  <?php __( 'No information available.' ) ?>
<?php endif; ?>

<?php __( 'Customer Notes' ) ?>
-------------------------------------------------------------------------------
<?php echo !empty( $proposal['notes'] ) ? h( $proposal['notes'] ) : __( 'None provided.', true ) ?>

<?php __( 'Quoted Incentive' ) ?>
-------------------------------------------------------------------------------
<?php printf( '%s (%s%s%s)', h( $rebate['name'] ), $rebate['amount_type']['code'] == 'USD' ? $rebate['amount_type']['symbol'] : false, $rebate['amount'], $rebate['amount_type']['code'] != 'USD' ? $rebate['amount_type']['symbol'] : false ) ?>
<?php printf( 'Expires: %s', !empty( $rebate['expiration_date'] ) ? date( DATE_FORMAT_LONG, strtotime( $rebate['expiration_date'] ) ) : 'While funds last' )?>
<?php printf( __( 'Energy Source(s): %s', true ), join( ', ', $rebate['energy_source'] ) ) ?>
<?php printf( __( 'Options: %s', true ), join( ', ', $rebate['options'] ) ) ?>
<?php if( !empty( $rebate['terms'] ) ): ?>
  <?php __( 'Terms and Conditions' ) ?>
  <?php foreach( $rebate['terms'] as $term ): ?>
    <?php echo h( $term['name'] ) ?>
    
    <?php foreach( array( 'field1', 'field2', 'field3' ) as $i => $field ): ?>
      <?php if( !empty( $term[$field . '_name'] ) && !empty( $term['IncentiveTechTerm'][$field . '_value'] ) ): ?>
        <?php $display = $field != 'field3' # For field3, don't display the name value.
          ? h( $term[$field . '_name'] ) . ' = ' . h( $term['IncentiveTechTerm'][$field . '_value'] )
          : h( $term['IncentiveTechTerm'][$field . '_value'] );
        ?>
        - <?php echo $display ?>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endforeach; ?> 
<?php endif; ?>

<?php __( 'Stacked Incentives' ) ?>
-------------------------------------------------------------------------------
<?php if( !empty( $stackable_rebates ) ): ?>
  <?php foreach( $stackable_rebates as $rebate ): ?>
    <?php printf( '%s (%s%s%s)', h( $rebate['Incentive']['name'] ), $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? $rebate['IncentiveAmountType']['name'] : false, $rebate['TechnologyIncentive']['amount'], $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? $rebate['IncentiveAmountType']['name'] : false ) ?>
    <?php printf( 'Expires: %s', !empty( $rebate['Incentive']['expiration_date'] ) ? date( DATE_FORMAT_LONG, strtotime( $rebate['Incentive']['expiration_date'] ) ) : 'While funds last' )?>
    <?php printf( __( 'Energy Source(s): %s', true ), join( ', ', Set::extract( '/EnergySource/name', $rebate ) ) ) ?>
    <?php printf( __( 'Options: %s', true ), join( ', ', Set::extract( '/TechnologyOption/name', $rebate ) ) ) ?>
    
    <?php if( !empty( $rebate['TechnologyTerm'] ) ): ?>
      <?php __( 'Terms and Conditions' ) ?>
      <?php foreach( $rebate['TechnologyTerm'] as $term ): ?>
        <?php echo h( $term['name'] ) ?>
        
        <?php foreach( array( 'field1', 'field2', 'field3' ) as $i => $field ): ?>
          <?php if( !empty( $term[$field . '_name'] ) && !empty( $term['IncentiveTechTerm'][$field . '_value'] ) ): ?>
            <?php $display = $field != 'field3' # For field3, don't display the name value.
              ? h( $term[$field . '_name'] ) . ' = ' . h( $term['IncentiveTechTerm'][$field . '_value'] )
              : h( $term['IncentiveTechTerm'][$field . '_value'] );
            ?>
            - <?php echo $display ?>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?> 
    <?php endif; ?>
  <?php endforeach; ?>
<?php else: ?>
  <?php __( 'None available.' ) ?>
<?php endif; ?>