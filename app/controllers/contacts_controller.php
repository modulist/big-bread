<?php

class ContactsController extends AppController {
  public $name       = 'Contacts';
	public $helpers    = array( 'Form' );
  public $components = array( 'SwiftMailer' );
  public $uses       = array( 'UserType', 'Contact' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
  }
  
  /**
   * Displays a contact form and sends the resulting email.
   */
  public function index() {
    if( !empty( $this->data ) ) {
      $this->Contact->set( $this->data );
      
      if( $this->Contact->validates() ) {
        /** 
        $this->SwiftMailer->smtpType = 'tls'; 
        $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
        $this->SwiftMailer->smtpPort = 465; 
        $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
        $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
        */
        $this->SwiftMailer->sendAs   = 'text'; 
        $this->SwiftMailer->from     = $this->data['Contact']['email']; 
        $this->SwiftMailer->fromName = $this->data['Contact']['full_name'];
        $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
          ? Configure::read( 'email.redirect_all_email_to' )
          : Configure::read( 'email.feedback_recipient' );
        
        $this->set( 'name', $this->data['Contact']['full_name'] );
        $this->set( 'company', $this->data['Contact']['company'] );
        $this->set( 'phone_number', $this->data['Contact']['phone_number'] );
        $this->set( 'zip_code', $this->data['Contact']['zip_code'] );
        $this->set( 'user_type', $this->data['Contact']['user_type'] );
        $this->set( 'message', $this->data['Contact']['message'] );
        
        try { 
          if( !$this->SwiftMailer->send( 'contact', 'Feedback from from BIGBREAD.net', 'native' ) ) {
            $this->Session->setFlash( 'Something prevented us from delivering your feeback. Please try again later.', null, null, 'warning' );
            $this->log( 'Error sending email', LOG_ERR );
          }
          else {
            $this->Session->setFlash( 'Your feedback has been sent. Thank you for taking the time to let us know what you think.', null, null, 'success' );
          }
        } 
        catch( Exception $e ) {
          $this->Session->setFlash( 'An error occurred when attempting to send your feeback. Please try again later.', null, null, 'error' );
          $this->log( 'Failed to send email: ' . $e->getMessage() ); 
        }

        $this->redirect( '/feedback' );
      }
    }
    else {
      $user = $this->Auth->user();
      $this->data['Contact'] = $user['User'];
    }
    
    $userTypes = $this->UserType->find(
      'list',
      array(
        'fields' => array( 'UserType.name', 'UserType.name' ),
        'conditions' => array( 'selectable' => 1, 'deleted' => 0 ),
        'order'  => 'UserType.name',
      )
    );
    
    $this->set( compact( 'userTypes' ) );
  }
}
