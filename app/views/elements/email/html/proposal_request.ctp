<p><?php __( 'Please contact me to prepare an estimate for the following services:' ) ?></p>
    
<p><strong><?php __( 'Scope of Work' ) ?></strong></p>
<hr />
<p><?php echo h( $proposal['scope_of_work'] ) ?></p>

<p><strong><?php __( 'Contact Information' ) ?></strong></p>
<hr />
<div>
  <?php echo h( $location['address_1'] ) ?><br />
  <?php if( !empty( $location['address_2'] ) ): ?>
    <?php echo h( $location['address_2'] ) ?><br />
  <?php endif; ?>
  <?php printf( '%s, %s, %s', h( $location['city'] ), h( $location['state'] ), h( $location['zip_code'] ) ) ?>
</div>

<p>
  <?php echo h( $sender['phone_number'] ) ?><br />
  <?php echo h( $sender['email'] ) ?>
</p>

<p><?php __( 'Contractor is responsible for reserving rebate funds with the program sponsor.' ) ?></p>

<p><?php printf( __( 'This work %s covered by a warranty.', true ), $proposal['under_warranty'] ? __( 'is', true ) : __( 'is not', true ) ) ?></p>
<p><?php printf( __( 'You %s permission to examine the equipment.', true ), $proposal['permission_to_examine'] ? 'have' : 'do not have' ) ?></p>

<p><strong><?php printf( __( 'Existing %s', true ), __n( Inflector::singularize( $technology['title'] ), Inflector::pluralize( $technology['title'] ), count( $fixtures ), true ) ) ?></strong></p>
<hr />
<?php if( !empty( $fixtures ) ): ?>
  <?php foreach( $fixtures as $fixture ): ?>
    <?php printf( '%s %s', $fixture['Fixture']['make'], $fixture['Fixture']['model'] ) ?>
  <?php endforeach; ?>
<?php else: ?>
  <?php __( 'No information available.' ) ?>
<?php endif; ?>

<p><strong><?php __( 'Customer Notes' ) ?></strong></p>
<hr />
<p><?php echo !empty( $proposal['notes'] ) ? h( $proposal['notes'] ) : __( 'None provided.', true ) ?></p>

<p><strong><?php __( 'Quoted Incentive' ) ?></strong></p>
<hr />
<p><?php printf( '%s (%s%s%s)', h( $rebate['name'] ), $rebate['amount_type']['code'] == 'USD' ? $rebate['amount_type']['symbol'] : false, $rebate['amount'], $rebate['amount_type']['code'] != 'USD' ? $rebate['amount_type']['symbol'] : false ) ?></p>
<p><?php printf( __( 'Expires: %s', true ), !empty( $rebate['expiration_date'] ) ? date( DATE_FORMAT_LONG, strtotime( $rebate['expiration_date'] ) ) : 'While funds last' ) ?></p>
<p><?php printf( __( 'Energy Source(s): %s', true ), join( ', ', $rebate['energy_source'] ) ) ?></p>
<p><?php printf( __( 'Options: %s', true ), join( ', ', $rebate['options'] ) ) ?></p>
<?php if( !empty( $rebate['terms'] ) ): ?>
  <p><strong><?php __( 'Terms and Conditions' ) ?></strong></p>
  <?php foreach( $rebate['terms'] as $term ): ?>
    <div><?php echo h( $term['name'] ) ?></div>
    
    <?php foreach( array( 'field1', 'field2', 'field3' ) as $i => $field ): ?>
      <?php if( !empty( $term[$field . '_name'] ) && !empty( $term['IncentiveTechTerm'][$field . '_value'] ) ): ?>
        <?php $display = $field != 'field3' # For field3, don't display the name value.
          ? h( $term[$field . '_name'] ) . ' = ' . h( $term['IncentiveTechTerm'][$field . '_value'] )
          : h( $term['IncentiveTechTerm'][$field . '_value'] );
        ?>
        <div>- <?php echo $display ?></div>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endforeach; ?> 
<?php endif; ?>

<p><strong><?php __( 'Stacked Incentives' ) ?></strong></p>
<hr />
<?php if( !empty( $stackable_rebates ) ): ?>
  <?php foreach( $stackable_rebates as $rebate ): ?>
    <p><?php printf( '%s (%s%s%s)', h( $rebate['Incentive']['name'] ), $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? $rebate['IncentiveAmountType']['name'] : false, $rebate['TechnologyIncentive']['amount'], $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? $rebate['IncentiveAmountType']['name'] : false ) ?></p>
    <p><?php printf( 'Expires: %s', !empty( $rebate['Incentive']['expiration_date'] ) ? date( DATE_FORMAT_LONG, strtotime( $rebate['Incentive']['expiration_date'] ) ) : 'While funds last' )?></p>
    <p><?php printf( __( 'Energy Source(s): %s', true ), join( ', ', Set::extract( '/EnergySource/name', $rebate ) ) ) ?></p>
    <p><?php printf( __( 'Options: %s', true ), join( ', ', Set::extract( '/TechnologyOption/name', $rebate ) ) ) ?></p>
    
    <?php if( !empty( $rebate['TechnologyTerm'] ) ): ?>
      <p><?php __( 'Terms and Conditions' ) ?></p>
      <?php foreach( $rebate['TechnologyTerm'] as $term ): ?>
        <p><?php echo h( $term['name'] ) ?></p>
        
        <?php foreach( array( 'field1', 'field2', 'field3' ) as $i => $field ): ?>
          <?php if( !empty( $term[$field . '_name'] ) && !empty( $term['IncentiveTechTerm'][$field . '_value'] ) ): ?>
            <?php $display = $field != 'field3' # For field3, don't display the name value.
              ? h( $term[$field . '_name'] ) . ' = ' . h( $term['IncentiveTechTerm'][$field . '_value'] )
              : h( $term['IncentiveTechTerm'][$field . '_value'] );
            ?>
            <p>- <?php echo $display ?></p>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?> 
    <?php endif; ?>
  <?php endforeach; ?>
<?php else: ?>
  <p><?php __( 'None available.' ) ?></p>
<?php endif; ?>