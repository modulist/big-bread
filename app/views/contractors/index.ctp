<h1><?php __( 'Contractor Registration' ) ?></h1>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <?php echo $this->element( '../users/_form' ) ?>

  <h2><?php __( 'Tell us about your company' ) ?></h2>

  <?php echo $this->Form->input( 'Contractor.company_name', array( 'placeholder' => 'The name of your company' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.address_1', array( 'label' => 'Street Address 1', 'placeholder' => '1234 Any Street' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.address_2', array( 'label' => 'Street Address 2', 'placeholder' => 'Suite 201' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.zip_code', array( 'placeholder' => '20739', 'after' => sprintf( '<small>%s</small>', __( 'We\'ll identify your city and state from the zip code.', true ) ) ) ) ?>
  <?php echo $this->Form->input( 'Contractor.better_business_bureau_listed', array( 'label' => __( 'Listed in the Better Business Bureau directory?', true ) ) ) ?>

  <fieldset>
    <h2><?php __( 'What certifications do you hold?' ) ?></h2>
    <?php echo $this->Form->input( 'Contractor.certified_nate', array( 'label' => 'NATE' ) ) ?>
    <?php echo $this->Form->input( 'Contractor.certified_bpi', array( 'label' => 'BPI' ) ) ?>
    <?php echo $this->Form->input( 'Contractor.certified_resnet', array( 'label' => 'RESNET' ) ) ?>
    <?php echo $this->Form->input(
      'Contractor.certified_other',
      array(
        'label' => 'Other Certifications',
        'placeholder' => 'List any other standard certifications you hold separated by commas',
        'after' => sprintf( '<small>%s</small>', __( 'e.g. Certification 1, Certification 2, Certification 3' , true ) ),
      )
    ) ?>
  </fieldset>
  
  <fieldset>
    <h2><?php __( 'And finally, the questions we have to ask...' ) ?></h2>
    <?php echo $this->Form->input( 'Contractor.licensed', array( 'label' => 'Do you possess all of the required state & local licenses?' ) ) ?>
    <?php echo $this->Form->input( 'Contractor.felony_charges', array( 'label' => 'Do you have any criminal charges or convictions?' ) ) ?>
    <?php echo $this->Form->input( 'Contractor.filings_current', array( 'label' => 'Are you current in all of your state filings?' ) ) ?>
    <?php echo $this->Form->input( 'Contractor.bankruptcy_filings', array( 'label' => 'Have you ever filed for bankruptcy or have any judgements or liens against you?' ) ) ?>
  </fieldset>
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
