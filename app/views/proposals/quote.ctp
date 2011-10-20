<div class="breadcrumb"><?php echo join( ' &gt; ', array( $this->data['Technology']['TechnologyGroup']['title'], $this->data['Technology']['title'] ) ) ?></div>

<h2><?php __( 'Get a Quote' ) ?></h2>

<?php echo $this->Form->create( 'Proposal', array( 'url' => array( 'action' => 'quote', $rebate['TechnologyIncentive']['id'], $location['Building']['id'] ) ) ) ?>
  <?php echo $this->Form->input( 'Building.id' ) ?>
  <div class="form-field-group clearfix">
    <h4><?php __( 'What do you need done?' ) ?></h4>
    <p><?php __( 'Please contact me to prepare an estimate for the following services:' ) ?></p>
    
    <?php $options = array( 'install' => sprintf( __( 'Install or replace my %s', true ), Inflector::singularize( $this->data['Technology']['title'] ) ), 'repair' => sprintf( __( 'Repair or service my %s', true ), Inflector::singularize( $this->data['Technology']['title'] ) ) ) ?>
    <?php echo $this->Form->input( 'Proposal.scope_of_work', array( 'type' => 'radio', 'options' => $options, 'default' => 'install', 'legend' => false ) ) ?>
    
    <h4><?php __( 'Will this work be covered by a warranty?' ) ?></h4>
    <?php echo $this->Form->input( 'Proposal.under_warranty', array( 'type' => 'radio', 'options' => array( 'No', 'Yes' ), 'default' => 1, 'legend' => false ) ) ?>
  </div>
  
  <div class="form-field-group clearfix">
    <h4><?php __( 'How can we contact you?' ) ?></h4>
    <p><?php __( 'We&#146;ll need a phone number in case we have any questions about your job.' ) ?></p>
    <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'Requestor', 'field' => 'phone_number', 'required' => true ) ) ?>
    
    <h4><?php __( 'Where will the work be performed?' ) ?></h4>
      
    <?php if( empty( $this->data['Building'] ) ): ?>
      <p><?php __( 'You haven\'t created a location yet, so let\'s do that now.' ) ?></p>
      <?php echo $this->element( '../buildings/_basic_inputs', array( 'plugin' => false ) ) # We have to reset the plugin context ?>
    <?php else: ?>
      <?php echo $this->element( 'address', array( 'plugin' => false, 'address' => $this->data['Address'] ) ) ?>
      <!-- <p><a href="/locations/edit">Change this address &rsaquo;</a></p> -->
    <?php endif; ?>
    
    <h4><?php __( 'Which utilities are involved?' ) ?></h4>
    <p><?php __( 'We\'ll need your account numbers to reserve and process your utility rebates.  Please add them to your request or add them to your profile as soon as possible.' ) ?></p>
    <?php echo $this->element( '../buildings/_utility_inputs', array( 'plugin' => false, 'show_account_numbers' => true ) ) # We have to reset the plugin context ?>
  </div>

  <div class="form-field-group clearfix">
    <h4><?php __( 'Anything else?' ) ?></h4>
    <p><?php __( 'Please add any additional instructions, contact preferences or any comments about the job.' ) ?></p>
    <?php echo $this->Form->input( 'Proposal.notes', array( 'type' => 'textarea' ) ) ?>
  </div>
  
<?php echo $this->Form->end( __( 'Get a Quote', true ) ) ?>

