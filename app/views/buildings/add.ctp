<div id="messages">
  <?php if( !User::agent() ): ?>
    <h1><?php __( 'Add a new location' ) ?></h1>
    <p><?php __( 'To save on major home improvement projects or simply when replacing an appliance.' ) ?></p>
  <?php else: ?>
    <?php if( UserType::$lookup[$this->Session->read( 'Auth.User.user_type_id' )] == 'INSPECTOR' ): ?>
      <h1><?php __( 'Be a solution hero with huge rebates from SaveBigBread' ) ?></h1>
    <?php else: ?>
      <h1><?php __( 'Rebates help close sales' ) ?></h1>
    <?php endif; ?>
    
    <p><?php __( 'You\'re about to provide another reason why your client will refer you. Once you hit <strong>Add location</strong>, we\'ll send your client an invitation to return to the site. Next, we\'ll direct you to <strong>add equipment</strong> so you can enter the make, model &amp; serial number for your client. We\'ll also send you an email with a list of the rebates that you\'ve elevated to "My Interests".' ) ?></p>
  <?php endif; ?>
</div><!-- /#messages -->

<?php echo $this->Form->create( 'Building', array( 'url' => array( 'controller' => 'buildings', 'action' => 'add' ) ) ) ?>
  <div class="clearfix">
    <h2><?php __( 'About your location:' ) ?></h2>
  </div>

  <div id="my-locations" class="grid_9">
    <div class="location-wrapper clearfix">
      <div class="location-icon-large"></div>
      <div class="grid_4">
        <?php if( User::agent() ): ?>
          <?php echo $this->element( '../buildings/_client_inputs' ) ?>
        <?php endif; ?>
        <?php echo $this->element( '../buildings/_basic_inputs' ) ?>
      </div><!-- /grid-4 -->	
    </div><!-- /location-wrapper -->
  </div><!-- /my-locations -->
  
  <div class="clearfix">
    <h2><?php __( 'Utilities for your location:' ) ?></h2>
  </div>
  
  <div id="my-utilities">
    <div class="utilities-wrapper clearfix">
      <div class="utilities-icon"></div>
      <div class="grid_4">
        <?php echo $this->element( '../buildings/_utility_inputs' ) ?>
      </div><!-- /grid-4 -->
    </div><!-- /utilities-wrapper -->
  </div><!-- /my-utilities -->
  
  <?php if( User::agent() ): ?>
    <div id="my-interests" class="grid_9">
      <h2><?php __( 'Potential interests for my client' ) ?></h2>
      <p class="instructions"><?php __( 'Select the categories that you believe your client should consider.' ) ?></p>
      
      <?php echo $this->element( '../users/_interests', array( 'watchable' => $watchable_technologies, 'watched' => array() ) ) ?>
    </div>
  <?php endif; ?>
<?php echo $this->Form->end( __( 'Add location', true ) ) ?>
<?php echo $this->Html->link( __( 'Cancel', true ), array( 'action' => 'add' ), array( 'class' => 'cancel-button') ) ?>