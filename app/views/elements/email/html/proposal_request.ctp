
<p><?php __( 'Please contact me to prepare an estimate for the following services:' ) ?></p>

<?php
switch( $proposal['scope_of_work'] ) {
  case 'install':
    $scope_label = sprintf( __( 'Install or replace my %s', true ), strtolower( $technology ) );
    break;
  case 'repair':
    $scope_label = sprintf( __( 'Repair or service my %s', true ), strtolower( $technology ) );
    break;
}
?>

<hr />
<strong><?php __( 'Scope of Work' ) ?></strong>
<hr />
<p><?php echo $scope_label ?></p>

<hr />
<strong><?php __( 'Contact Information' ) ?></strong>
<hr />
<p>
  <div><?php echo $requestor['User']['full_name'] ?></div>
  <div><?php echo $address['Address']['address_1'] ?></div>
  <?php if( !empty( $address['Address']['address_2'] ) ): ?>
    <div><?php echo $address['Address']['address_2'] ?></div>
  <?php endif; ?>
  <div><?php echo $address['ZipCode']['city'] . ', ' . $address['ZipCode']['state'] . ' ' . $address['Address']['zip_code'] ?></div>
  <div><?php echo $this->Format->phone_number( $requestor['User']['phone_number'] ) ?></div>
  <div><?php echo $requestor['User']['email'] ?></div>
</p>

<hr />
<strong><?php __n( 'My Existing ' . Inflector::singularize( $technology ), 'My Existing ' . Inflector::pluralize( $technology ), count( $existing_equipment ) ) ?></strong>
<hr />
<?php if( !empty( $existing_equipment ) ): ?>
  <?php foreach( $existing_equipment as $installed ): ?>
    <p>
      <div>Make: <?php echo h( $installed['Product']['make'] ) ?></div>
      <div>Model: <?php echo h( $installed['Product']['model'] ) ?></div>
    </p>
    <hr style="visibility: hidden;" />
  <?php endforeach; ?>
<?php else: ?>
  <?php printf( __( 'No %s information is available for this building.', true ), strtolower( Inflector::singularize( $technology ) ) ) ?>
<?php endif; ?>

<hr />
<strong><?php __( 'Timeline' ) ?></strong>
<hr />

<strong><?php __( 'Timing' ) ?></strong>
<?php $timing_label = $proposal['timing'] == 'ready' ? __( 'ready to hire', true ) : __( 'estimating and budgeting', true ) ?>
<p><?php printf( __( 'I am %s.', true ), $timing_label ) ?></p>

<strong><?php __( 'Urgency' ) ?></strong>
<?php
switch( $proposal['urgency'] ) {
  case 'flexible':
    $urgency_label = __( 'in the future. Timing is flexible', true );
    break;
  case 'over 3 weeks':
    $urgency_label = __( 'no sooner than 3 weeks from now.', true );
    break;
  case '1-2 weeks':
    $urgency_label = __( 'within 1 to 2 weeks.', true );
    break;
  default:
    $urgency_label = $proposal['urgency'];
    break;
}
?>
<p><?php printf( __( 'I intend to have this work completed %s.', true ), $urgency_label ) ?></p>

<?php if( !empty( $proposal['comments'] ) ): ?>
  <hr />
  <strong><?php __( 'User Comments' ) ?></strong>
  <hr />
  <p><?php echo h( $proposal['comments'] ) ?></p>
<?php endif; ?>

<p><?php __( 'I have identified the following rebates that are available to me in my area.  Please incorporate the applicable rebates into your pricing.' ) ?></p>

<hr />
<strong><?php __( 'Quoted Incentive' ) ?></strong>
<hr />
<p>
  <div>
    <?php if( $quoted_incentive['IncentiveAmountType']['incentive_amount_type_id'] == 'PERC' ): ?>
      <?php echo h( $quoted_incentive['TechnologyIncentive']['amount'] ) . h( $quoted_incentive['IncentiveAmountType']['name'] ) ?>
    <?php else: ?>
      <?php echo '$' . h( $quoted_incentive['TechnologyIncentive']['amount'] ) ?>
    <?php endif; ?>
    
    <?php if( !in_array( $quoted_incentive['IncentiveAmountType']['incentive_amount_type_id'], array( 'USD', 'PERC' ) ) ): ?>
      (<?php echo h( $quoted_incentive['IncentiveAmountType']['name'] ) ?>)
    <?php endif; ?>
  </div>
  <div><?php echo $quoted_incentive['Incentive']['name'] . ' (' . $quoted_incentive['Incentive']['incentive_id'] . ')' ?></div>
  <div><strong>Expires:</strong> <?php echo empty( $quoted_incentive['Incentive']['expiration_date'] ) ? __( 'When Funds Exhausted', true ) : date( 'm/d/Y', strtotime( $quoted_incentive['Incentive']['expiration_date'] ) ) ?></div>
  <div>
    <div><strong><?php __( 'Energy Source' ) ?></strong></div>
    <?php if( !empty( $quoted_incentive['EnergySource'] ) ): ?>
      <?php foreach( $quoted_incentive['EnergySource'] as $esource ): ?>
        <div>- <?php echo h( $esource['name'] ) ?><div>
      <?php endforeach; ?>
    <?php else: ?>
      Not specified
    <?php endif; ?>
  </div>
  <div>
    <div><strong><?php __( 'Options' ) ?></strong></div>
    <?php if( !empty( $quoted_incentive['TechnologyOption'] ) ): ?>
      <?php foreach( $quoted_incentive['TechnologyOption'] as $option ): ?>
        <div>- <?php echo h( $option['name'] ) ?></div>
      <?php endforeach; ?>
    <?php else: ?>
      None
    <?php endif; ?>
  </div>
  
  <?php if( !empty( $quoted_incentive['TechnologyTerm'] ) ): ?>
    <div>
      <div><strong><?php __( 'Terms and Conditions' ) ?></strong></div>
      <?php foreach( $quoted_incentive['TechnologyTerm'] as $term ): ?>
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
    </div>
  <?php endif; ?>
</p>

<hr />
<strong><?php __( 'Related Incentives' ) ?></strong>
<hr />
<?php foreach( $related_incentives as $i => $incentive ): ?>
  <p>
    <div>
      <?php if( $incentive['IncentiveAmountType']['incentive_amount_type_id'] == 'PERC' ): ?>
        <?php echo h( $incentive['TechnologyIncentive']['amount'] ) . h( $incentive['IncentiveAmountType']['name'] ) ?>
      <?php else: ?>
        <?php echo '$' . h( $incentive['TechnologyIncentive']['amount'] ) ?>
      <?php endif; ?>
      
      <?php if( !in_array( $incentive['IncentiveAmountType']['incentive_amount_type_id'], array( 'USD', 'PERC' ) ) ): ?>
        (<?php echo h( $incentive['IncentiveAmountType']['name'] ) ?>)
      <?php endif; ?>
    </div>
    <div><?php echo $incentive['Incentive']['name'] . ' (' . $incentive['Incentive']['incentive_id'] . ')' ?></div>
    <div><strong>Expires:</strong> <?php echo empty( $incentive['Incentive']['expiration_date'] ) ? __( 'When Funds Exhausted', true ) : date( 'm/d/Y', strtotime( $incentive['Incentive']['expiration_date'] ) ) ?></div>
    <div>
      <div><strong><?php __( 'Energy Source' ) ?></strong></div>
      <?php if( !empty( $incentive['EnergySource'] ) ): ?>
        <?php foreach( $incentive['EnergySource'] as $esource ): ?>
          <div>- <?php echo h( $esource['name'] ) ?><div>
        <?php endforeach; ?>
      <?php else: ?>
        Not specified
      <?php endif; ?>
    </div>
    <div>
      <div><strong><?php __( 'Options' ) ?></strong></div>
      <?php if( !empty( $incentive['TechnologyOption'] ) ): ?>
        <?php foreach( $incentive['TechnologyOption'] as $option ): ?>
          <div>- <?php echo h( $option['name'] ) ?></div>
        <?php endforeach; ?>
      <?php else: ?>
        None
      <?php endif; ?>
    </div>
    
    <?php if( !empty( $incentive['TechnologyTerm'] ) ): ?>
      <div>
        <div><strong><?php __( 'Terms and Conditions' ) ?></strong></div>
        <?php foreach( $incentive['TechnologyTerm'] as $term ): ?>
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
      </div>
    <?php endif; ?>
  </p>
  <hr style="visibility: hidden" />
<?php endforeach; ?>
