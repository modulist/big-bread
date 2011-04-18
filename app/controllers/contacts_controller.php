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
    
    $this->Auth->allow( '*' );
  }
  
  /**
   * Displays a contact form and sends the resulting email.
   */
  public function index() {
    if( $this->RequestHandler->isPost() ) {
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
        $this->SwiftMailer->fromName = $this->data['Contact']['name'];
        # TODO: Change this? Maybe once we get bigbread.net email up.
        $this->SwiftMailer->to       = 'wamaull@federatedpower.com';
        
        $this->set( 'name', $this->data['Contact']['name'] );
        $this->set( 'company', $this->data['Contact']['company'] );
        $this->set( 'phone_number', $this->data['Contact']['phone_number'] );
        $this->set( 'zip_code', $this->data['Contact']['zip_code'] );
        $this->set( 'user_type', $this->data['Contact']['user_type'] );
        $this->set( 'message', $this->data['Contact']['message'] );
        
        try { 
          if( !$this->SwiftMailer->send( 'contact', 'New Contact Request from BigBread.net', 'native' ) ) {
            $this->Session->setFlash( 'An error occurred when attempting to send your feeback. Please try again later.', null, null, 'warning' );
            $this->log( 'Error sending email' );
          }
          else {
            $this->Session->setFlash( 'Your feedback has been sent. Thank you for taking the time to let us know how we\'re doing.', null, null, 'success' );
            unset( $this->data['Contact'] );
          }
        } 
        catch( Exception $e ) {
          $this->Session->setFlash( 'An error occurred when attempting to send your feeback. Please try again later.', null, null, 'error' );
          $this->log( 'Failed to send email: ' . $e->getMessage() ); 
        }
      }
    }
    $userTypes = $this->UserType->find(
      'list',
      array(
        'fields' => array( 'UserType.name', 'UserType.name' ),
        'order'  => 'UserType.name',
      )
    );
    
    $this->set( compact( 'userTypes' ) );
  }
}
