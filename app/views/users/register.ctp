<?php echo $this->Form->create( 'User', array( 'action' => 'register', $this->data['User']['invite_code'] ) ) ?>
<?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>

<div id="signupheader">
  <h1>Join BigBread.net</h1>
  <label>Choose your primary role*</label>
  
  <ul id="user_type">
    <?php echo $this->Form->hidden( 'User.user_type_id', array( 'id' => 'UserUserTypeId_', 'value' => '' ) ) ?>
    <?php foreach( $userTypes as $id => $name ): ?>
      <li>
        <?php echo $this->Html->image( strtolower( Inflector::slug( $name ) ) . '.png', array( 'class' => 'icon', 'title' => $name, 'data-for' => 'UserUserTypeId' . Inflector::slug( $id, '' ) ) ) ?><br />
        <?php echo $this->Form->radio( 'User.user_type_id', array( $id => $name ), array( 'legend' => false, 'hiddenField' => false ) ) ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <p><?php printf( __( 'Are you a contractor? Please use our %s.', true ), $this->Html->link( __( 'contractor registration', true ), array( 'controller' => 'contractors', 'action' => 'index' ) ) ) ?></p>
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
