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
  <div class="clear"></div>
  <?php if( $this->Form->error( 'User.user_type_id' ) ): ?>
      <?php echo $this->Form->error( 'User.user_type_id' ) ?>
  <?php endif; ?>
</div>

<div id="signupbody">
  <p>Required fields are noted by <span>*</span></p>
  
  <?php echo $this->Form->input( 'User.first_name', array( 'div' => 'input text required', 'placeholder' => 'Your first name' ) ) ?>
  <?php echo $this->Form->input( 'User.last_name', array( 'div' => 'input text required', 'placeholder' => 'Your last name' ) ) ?>
  <?php echo $this->Form->input( 'User.email', array( 'div' => 'input text required', 'placeholder' => 'e.g. user@example.com' ) ) ?>
  <?php echo $this->element( 'phone_number', array( 'plugin' => 'FormatMask', 'model' => 'User', 'field' => 'phone_number', 'required' => true ) ) ?>
  <?php # echo $this->Form->input( 'User.phone_number', array( 'placeholder' => 'e.g. 410-555-2930' ) ) ?>
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
