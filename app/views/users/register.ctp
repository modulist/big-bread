<?php echo $this->Form->create( 'User', array( 'action' => 'register', $this->data['User']['invite_code'] ) ) ?>
<?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>

<div id="signupheader">
  <h1>Join BigBread.net</h1>
  <h3>Choose your user type</h3>
  
  <ul id="user_type">
    <?php echo $this->Form->hidden( 'User.user_type_id', array( 'id' => 'UserUserTypeId_', 'value' => '' ) ) ?>
    <?php foreach( $userTypes as $id => $name ): ?>
      <li>
        <?php echo $this->Html->image( strtolower( Inflector::slug( $name ) ) . '.png', array( 'class' => 'icon', 'title' => $name, 'data-for' => 'UserUserTypeId' . Inflector::slug( $id, '' ) ) ) ?><br />
        <?php echo $this->Form->radio( 'User.user_type_id', array( $id => $name ), array( 'legend' => false, 'hiddenField' => false ) ) ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <div class="clear"></div>
</div>

<div id="signupbody">
  <p>Required fields are noted by <span>*</span></p>
  
  <?php echo $this->Form->input( 'User.first_name', array( 'div' => 'input text required' ) ) ?>
  <?php echo $this->Form->input( 'User.last_name', array( 'div' => 'input text required' ) ) ?>
  <?php echo $this->Form->input( 'User.email', array( 'div' => 'input text required' ) ) ?>
  <?php echo $this->Form->input( 'User.phone_number' ) ?>
  <?php echo $this->Form->input( 'User.password', array( 'div' => 'input password required' ) ) ?>
  <?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password', 'div' => 'input password required' ) ) ?>
  
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
