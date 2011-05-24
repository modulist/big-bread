<h1>Request a Proposal</h1>
  
<p><?php __( 'Please contact me to prepare an estimate for the following services:' ) ?></p>

<?php echo $this->Form->create( 'Proposal' ) ?>
  <?php echo $this->Form->hidden( 'Building.id' ) ?>
  <?php echo $this->Form->hidden( 'TechnologyIncentive.id' ) ?>
  
  <?php echo $this->Form->radio( 'Proposal.scope_of_work', array( 'install' => sprintf( __( 'Install or replace my %s', true ), strtolower( $technology ) ), 'repair' => sprintf( __( 'Repair or service my %s', true ), strtolower( $technology ) ) ), array( 'default' => 'install', 'separator' => '<br />' ) ) ?>
  <?php echo $this->Form->radio( 'Proposal.timing', array( 'ready' => 'Ready to hire', 'planning' => 'Estimating and budgeting' ), array( 'default' => 'ready', 'legend' => 'I am:', 'separator' => '<br />' ) ) ?>
  <?php echo $this->Form->label( 'Proposal.urgency', 'I intend to have this work completed:' ) ?>
  <?php echo $this->Form->select( 'Proposal.urgency', array( 'within a week' => 'Within 1 week', '1-2 weeks' => 'Within 1 to 2 weeks', 'over 3 weeks' => 'In more than 3 weeks', 'flexible' => 'Timing is flexible' ), array( 'default' => 'flexible' ) ) ?>
  
  <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'Requestor', 'field' => 'phone_number', 'required' => true ) ) ?>
  <?php echo $this->Form->input( 'Proposal.comments', array( 'placeholder' => 'Please include your contact preferences' ) ) ?>
<?php echo $this->Form->end( 'Send Request' ) ?>

