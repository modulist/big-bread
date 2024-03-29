<div id="messages">
  <?php if( !$has_locations ): ?>
    <h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
    <p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?></p>
  <?php else: ?>
    <h1><?php __( 'Create your password' ) ?></h1>
    <p><?php __( 'We\'ll keep you posted on how to SaveBigBread.' ) ?></p>
  <?php endif; ?>
</div>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'default' => $user_type_id ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>

  <?php if( empty( $this->data['User']['invite_code'] ) && !$has_locations ): ?>  
    <?php echo $this->Form->input( 'WatchedTechnology.selected', array( 'type' => 'hidden', 'value' => join( ',', $this->data['WatchedTechnology']['selected'] ) ) ) ?>
    
    <h2><?php __( 'What are you interested in?' ) ?></h2>
    <p class="instructions">
      <?php __( 'Select as many categories of rebates as you like by clicking on the stars below. You can always change this later.' ) ?>
    </p>
    <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => $this->data['WatchedTechnology']['selected'] ) ) ?>
  <?php endif; ?>
  
  <div id="user-registration">
  	<?php echo $this->element( '../users/_form', array( 'show_zip_code' => !$has_locations ) ) ?>
  </div>

<?php echo $this->Form->end( __( 'Let\'s go!', true ) ) ?>
