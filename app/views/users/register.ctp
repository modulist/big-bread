<div id="messages">
	<h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
	<p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'default' => $user_type_id ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>
  <?php echo $this->Form->input( 'WatchedTechnology.selected', array( 'type' => 'hidden', 'value' => join( ',', $this->data['WatchedTechnology']['selected'] ) ) ) ?>
  
  <?php if( !in_array( $user_type_id, array( UserType::$reverse_lookup['REALTOR'], UserType::$reverse_lookup['INSPECTOR'] ) ) ): ?>
    <h2><?php __( 'What are you interested in?' ) ?></h2>
    <p class="instructions">
      <?php __( 'Select as many categories of rebates as you like by clicking on the stars below. You can always change this later.' ) ?>
    </p>
    <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => $this->data['WatchedTechnology']['selected'] ) ) ?>
  <?php endif; ?>
  
  <div id="user-registration">
  	<?php echo $this->element( '../users/_form' ) ?>
  </div>

<?php echo $this->Form->end( __( 'Let\'s go!', true ) ) ?>
