<h1><?php __( 'Contact Information' ) ?></h1>

<?php echo $this->Form->create( 'Contractor', array( 'url' => array( 'action' => 'add', $user_id ) ) ) ?>
  <?php echo $this->Form->input( 'Contractor.company_name', array( 'placeholder' => 'The name of your company' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.address_1', array( 'label' => 'Street Address 1', 'placeholder' => '1234 Any Street' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.address_2', array( 'label' => 'Street Address 2', 'placeholder' => 'Suite 201' ) ) ?>
  <?php echo $this->Form->input( 'BillingAddress.zip_code', array( 'placeholder' => '20739', 'after' => sprintf( '<small>%s</small>', __( 'We\'ll identify your city and state from the zip code.', true ) ) ) ) ?>

  <fieldset>
    <legend><?php __( 'Certifications' ) ?></legend>
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
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
