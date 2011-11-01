<?php

class MessagesController extends AppController {
	public $name = 'Messages';
	public $helpers    = array( 'FormatMask.Format' );
  public $components = array( 'FormatMask.Format' );
  
  /**
   * CALLBACK METHODS
   */
  
  /**
   * CakePHP beforeFilter callback
   */
  public function beforeFilter() {
    parent::beforeFilter();
    
    $this->Auth->allow( 'feedback' );
  }
  
  /**
   * Displays and handles the feedback form.
   *
   * @access  public
   */
  public function feedback() {
    # Customize model validation for this form's inputs
    $this->Message->validate = array(
      'message' => array(
        'notempty' => array(
          'rule'       => 'notEmpty',
          'message'    => 'Message cannot be empty.',
          'allowEmpty' => false,
          'required'   => true,
        )
      ),
    );
    $this->Message->Sender->validate = Set::merge(
      $this->Message->Sender->validate,
      array(
        'first_name' => array( 'notempty' => array( 'required' => false ) ),
        'last_name'  => array( 'notempty' => array( 'required' => false ) ),
        'full_name'  => array(
          'notempty' => array(
            'rule'       => 'notEmpty',
            'message'    => 'Name cannot be empty.',
            'allowEmpty' => false,
            'required'   => true,
          )
        ),
        'zip_code'  => array(
          'notempty' => array(
            'rule'       => 'notEmpty',
            'message'    => 'Zip code cannot be empty.',
            'allowEmpty' => false,
            'required'   => true,
            'last'       => true,
          )
        ),
      )
    );
    unset( $this->Message->Sender->validate['email']['unique'] );
    
    if( !empty( $this->data ) ) {
      $this->data['Sender']['user_type_id'] = empty( $this->data['Sender']['user_type_id'] )
        ? 'ANONYMOUS'
        : $this->data['Sender']['user_type_id'];
      
      # Squash the phone number if it exists in a data array to prep for save
      if( !empty( $this->data['Sender']['phone_number'] ) && is_array( $this->data['Sender']['phone_number'] ) ) {
        $this->data['Sender']['phone_number'] = $this->Format->phone_number( $this->data['Sender']['phone_number'] );
      }
      
      $this->Message->set( $this->data );
      $this->Message->Sender->set( $this->data );
      
      # Since full name isn't part of the schema, we have to test it manually.
      if( empty( $this->data['Sender']['full_name'] ) ) {
        $this->Message->Sender->invalidate( 'full_name', 'Name cannot be empty.' );
      }
      
      if( $this->Message->Sender->validates( $this->data ) ) {
        # Pull the friendly user type value
        $this->data['Sender']['user_type'] = strlen( $this->data['Sender']['user_type_id'] ) == 36
          ? $this->Message->Sender->UserType->field( 'name', array( 'UserType.id' => $this->data['Sender']['user_type_id'] ) )
          : $this->data['Sender']['user_type_id'];
          
        $this->data['Sender'] = Set::merge( $this->Auth->user(), $this->data['Sender'] );
        
        $replacements = array(
          'message' => $this->data['Message']['message'],
          'sender'  => $this->data['Sender']
        );
        
        # Queue up the message
        if( $this->Message->queue( MessageTemplate::TYPE_FEEDBACK, 'User', $this->Auth->user( 'id' ), $this->Auth->user( 'id' ), null, $replacements ) ) {
          $this->Session->setFlash( 'Thank you for taking the time to send us your feedback. Our Customer Service will contact you as soon as possible.', null, null, 'success' );
        }
        else {
          $this->Session->setFlash( 'An error occurred while saving your feeback. Please try again later.', null, null, 'error' );
        }
        
        $this->redirect( array( 'action' => 'feedback' ) );        
      }
      else {
        # new PHPDump( $this->Message->Sender->invalidFields() ); exit;
      }
    }
    else {
      if( $this->Session->check( 'Auth.User' ) ) {
        $user = $this->Auth->user();
        $this->data['Sender'] = $user['User'];
        
        if( !isset( $this->data['Sender']['full_name'] ) ) {
          $this->data['Sender']['full_name'] = sprintf( '%s %s', $this->data['Sender']['first_name'], $this->data['Sender']['last_name'] );
        }
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
    $userTypes['Other'] = 'Other';
    
    $this->set( compact( 'userTypes' ) );
  }
}
