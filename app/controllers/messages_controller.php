<?php

class MessagesController extends AppController {
	public $name = 'Messages';
	public $helpers    = array( 'FormatMask.Format' );
  public $components = array( 'FormatMask.Format' );
  
  /**
   * Displays and handles the feedback form.
   *
   * @param   $
   * @return  		
   * @access  public
   */
  public function feedback() {
    if( !empty( $this->data ) ) {
      # Squash the phone number if it exists in a data array to prep for save
      if( !empty( $this->data['Sender']['phone_number'] ) && is_array( $this->data['Sender']['phone_number'] ) ) {
        $this->data['Sender']['phone_number'] = $this->Format->phone_number( $this->data['Sender']['phone_number'] );
      }
      
      # Tweak the User model validation for some differences in this form
      $this->Message->Sender->validate = Set::merge(
        $this->Message->Sender->validate,
        array(
          'first_name' => array( 'notempty' => array( 'required' => false ) ),
          'last_name'  => array( 'notempty' => array( 'required' => false ) ),
          'full_name'  => array(
            'notempty' => array(
              'rule'       => 'notEmpty',
              'message'    => 'Last name cannot be empty.',
              'allowEmpty' => false,
              'required'   => true,
            )
          ),
        )
      );
      unset( $this->Message->Sender->validate['email']['unique'] );
      
      $this->Message->Sender->set( $this->data );
      if( $this->Message->Sender->validates( $this->data ) ) {
        # Pull the friendly user type value
        $this->data['Sender']['user_type'] = $this->Message->Sender->UserType->field( 'name', array( 'UserType.id' => $this->data['Sender']['user_type_id'] ) );
        
        $this->data['Sender'] = Set::merge( $this->Auth->user(), $this->data['Sender'] );
        
        $replacements = array(
          'message' => $this->data['Message']['message'],
          'sender'  => $this->data['Sender']
        );
        
        # Queue up the message
        if( $this->Message->queue( MessageTemplate::TYPE_FEEDBACK, 'User', $this->Auth->user( 'id' ), $this->Auth->user( 'id' ), null, $replacements ) ) {
          $this->Session->setFlash( 'Your feedback has been collected. Thank you for taking the time to let us know what you think.', null, null, 'success' );
        }
        else {
          $this->Session->setFlash( 'An error occurred while saving your feeback. Please try again later.', null, null, 'error' );
        }
        
        $this->redirect( array( 'action' => 'feedback' ) );        
      }
    }
    else {
      $user = $this->Auth->user();
      $this->data['Sender'] = $user['User'];
      
      if( !isset( $this->data['Sender']['full_name'] ) ) {
        $this->data['Sender']['full_name'] = sprintf( '%s %s', $this->data['Sender']['first_name'], $this->data['Sender']['last_name'] );
      }
    }
    
    # Explode the phone number if it exists in a data array to prep for form display
    if( isset( $this->data['Sender']['phone_number'] ) && is_string( $this->data['Sender']['phone_number'] ) ) {
      $this->data['Sender']['phone_number'] = $this->Format->phone_number( $this->data['Sender']['phone_number'] );
    }
    
    $userTypes = $this->Message->Sender->UserType->find(
      'list',
      array(
        'conditions' => array( 'selectable' => 1, 'deleted' => 0 ),
        'order'  => 'UserType.name',
      )
    );
    
    $this->set( compact( 'userTypes' ) );
  }
}
