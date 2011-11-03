<p><?php printf( __( 'Hi, %s:', true ), $recipient_first_name ) ?></p>

<p><?php printf( __( 'This is a list of My Interests rebates for review by %s as of %s. Note that rebates are changed at the discretion of the program sponsor without any prior notice. As such, it\'s best to rely on the information on the site.', true ), h( $client_name ), date( DATE_FORMAT_LONG_WITH_DAY ) ) ?></p>

<?php foreach( $rebates as $group_name => $rebate ): ?>
<p>
  <strong><?php echo strtoupper( h( $group_name ) ) ?></strong>
  <hr />
  <?php printf( '%s (%s)', h( $rebate['Incentive']['name'] ), $this->Number->format( $rebate['TechnologyIncentive']['amount'], array( 'places' => 0, 'before' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? h( $rebate['IncentiveAmountType']['name'] ) : false, 'after' => $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? h( $rebate['IncentiveAmountType']['name'] ) : false ) ) ) ?><br />
  <?php if( !empty( $rebate['TechnologyOption'] ) ): ?>
    <?php printf( __( 'Equipment: %s', true ), join( ', ', Set::extract( '/TechnologyOption/name', $rebate ) ) ) ?><br />
  <?php endif; ?>
  <?php printf( __( 'Expires %s', true ), empty( $rebate['Incentive']['expiration_date'] ) ? __( 'while funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ) ?>
</p>
<?php endforeach; ?>

<p><?php __( 'In order to access their account, your client has received an invitation email to register on SaveBigBread. They simply need to click on the link in the email. Once they arrive on the site, all they need to do is register a password and they\'ll see your entries and all the current rebates for where they live.' ) ?></p>

<p>
  <?php __( 'Regards,' ) ?><br />
  <?php __( 'Tony Maull' ) ?><br />
  <?php __( 'CEO and President' ) ?>
</p>