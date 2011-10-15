<div class="breadcrumb"><?php echo join( ' &gt; ', array( $rebate['Technology']['TechnologyGroup']['title'], $rebate['Technology']['name'] ) ) ?></div>

<h2><?php __( 'Get a Quote' ) ?></h2>

<?php echo $this->Form->create( 'Proposal' ) ?>
  <div class="form-field-group clearfix">
    <h4><?php __( 'What do you need done?' ) ?></h4>
    <p><?php __( 'Please contact me to prepare an estimate for the following services:' ) ?></p>
    
    <?php $options = array( 'install' => sprintf( __( 'Install or replace my %s', true ), Inflector::singularize( $rebate['Technology']['name'] ) ), 'repair' => sprintf( __( 'Repair or service my %s', true ), Inflector::singularize( $rebate['Technology']['name'] ) ) ) ?>
    <?php echo $this->Form->input( 'Proposal.scope_of_work', array( 'type' => 'radio', 'options' => $options, 'default' => 'install', 'legend' => false ) ) ?>
  </div>
  
  <div class="form-field-group clearfix">
    <h4><?php __( 'How can we reach you?' ) ?></h4>
    
    <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'Requestor', 'field' => 'phone_number', 'required' => true ) ) ?>
  </div>

  <div class="form-field-group clearfix">
    <h4><?php __( 'Are you ready to hire?' ) ?></h4>
    
    <?php $options = array( 'ready' => __( 'Yes, I&#146;m ready to hire someone.', true ), 'planning' => __( 'Not Quite. I\'m estimating and budgeting.', true ) ) ?>
    <?php echo $this->Form->input( 'Proposal.timing', array( 'type' => 'radio', 'options' => $options, 'default' => 'ready', 'legend' => false ) ) ?>
  </div>
  
  <div class="form-field-group clearfix">
    <h4><?php __( 'How soon do you need the work done?' ) ?></h4>
    <input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="within a week" checked="checked">
    <label for="ProposalTimingReady">Within 1 week</label><br />
    <input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="1-2 weeks" checked="checked">
    <label for="ProposalTimingReady">In 1 to 2 weeks</label><br />
    <input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="over 3 weeks" checked="checked">
    <label for="ProposalTimingReady">In 3 weeks or more</label><br />
    <input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="flexible" checked="checked">
    <label for="ProposalTimingReady">I&#146;m pretty flexible</label><br />
    </div>

  <div class="form-field-group clearfix">
    <h4>How can we contact you?</h4>
    <p>We&#146;ll need a phone number in case we have any questions about your job.</p>
    <div class="input text phonenumber required">
      <label for="RequestorPhoneNumber">Primary Phone Number</label>
      <input name="data[Requestor][phone_number][]" type="text" value="" class="area-code" maxlength="3" id="RequestorPhoneNumber"> -   
      <input name="data[Requestor][phone_number][]" type="text" value="" class="exchange" maxlength="3" id="RequestorPhoneNumber"> -   
      <input name="data[Requestor][phone_number][]" type="text" value="" class="number" maxlength="4" id="RequestorPhoneNumber">
    </div>
  </div>
  
  <div class="form-field-group clearfix">
    <h4>Anything else?</h4>
    <div class="input textarea"><textarea name="data[Proposal][comments]" placeholder="Please add instructions ror when you'd like to be reached, or any comments about the job." cols="30" rows="6" id="ProposalComments"></textarea></div>
    <div class="submit"><input type="submit" value="Get a Quote"></div> 
  </div>
  
<?php echo $this->Form->end( __( 'Get a Quote', true ) ) ?>

