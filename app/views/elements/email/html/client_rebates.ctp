<p><?php printf( __( 'Hi, %s:', true ), $recipient_first_name ) ?></p>

<p><?php printf( __( 'This is a list of My Interests rebates for review by %s as of %s. Note that rebates are changed at the discretion of the program sponsor without any prior notice. As such, it\'s best to rely on the information on the site.', true ), h( $client_name ), date( DATE_FORMAT_LONG_WITH_DAY ) ) ?></p>

<?php foreach( $rebates as $tech_name => $tech_rebates ): ?>

<h1><?php echo strtoupper( Inflector::pluralize( h( $tech_name ) ) ) ?></h1>
<hr />
<?php foreach( $tech_rebates as $rebate ): ?>
  <p>
    <?php printf( '%s (%s%s%s)', h( $rebate['Incentive']['name'] ), $rebate['IncentiveAmountType']['incentive_amount_type_id'] == 'USD' ? $rebate['IncentiveAmountType']['name'] : false, $rebate['TechnologyIncentive']['amount'], $rebate['IncentiveAmountType']['incentive_amount_type_id'] != 'USD' ? $rebate['IncentiveAmountType']['name'] : false ) ?><br />
    <?php if( !empty( $rebate['TechnologyOption'] ) ): ?>
      <?php printf( __( 'Equipment: %s', true ), join( ', ', Set::extract( '/TechnologyOption/name', $rebate ) ) ) ?><br />
    <?php endif; ?>
    <?php printf( __( 'Expires %s', true ), empty( $rebate['Incentive']['expiration_date'] ) ? __( 'while funds last', true ) : date( 'm/d/Y', strtotime( $rebate['Incentive']['expiration_date'] ) ) ) ?>
  </p>
<?php endforeach; ?>
<?php endforeach; ?>

<p><?php __( 'In order to access their account, your client has received an invitation email to register on SaveBigBread. They simply need to click on the link in the email. Once they arrive on the site, all they need to do is register a password and they\'ll see your entries and all the current rebates for where they live.' ) ?></p>

<p>
  <?php __( 'Regards,' ) ?><br />
  <?php __( 'Tony Maull' ) ?><br />
  <?php __( 'CEO and President' ) ?>
</p>