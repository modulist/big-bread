<?php echo $this->Form->create( 'User', array( 'action' => 'register', $this->data['User']['invite_code'] ) ) ?>
<?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>

<?php echo $this->Html->link( 'Dashboard', array( 'action' => 'dashboard' ) ) ?>

<div id="signupheader">
  <h1>Join SaveBigBread.com</h1>
  
  <?php if( Configure::read( 'Feature.contractor_registration.enabled' ) ): ?>
    <p><?php printf( __( 'Are you a contractor? Please use our %s.', true ), $this->Html->link( __( 'contractor registration', true ), array( 'controller' => 'contractors', 'action' => 'index' ) ) ) ?></p>
  <?php endif; ?>
  
  <div class="clear"></div>
  <?php if( $this->Form->error( 'User.user_type_id' ) ): ?>
      <?php echo $this->Form->error( 'User.user_type_id' ) ?>
  <?php endif; ?>
</div>

<div id="signupbody">
  <p>Required fields are noted by <span>*</span></p>
  
  <?php echo $this->element( '../users/_form' ) ?>
  
  <div class="buttons">
    <div class="button">
      <input type="submit" value="Submit" />
    </div>
    <div class="button">
      <input type="reset" value="Cancel" />
    </div>
  </div>
</div>

<?php echo $this->Form->end() ?>
