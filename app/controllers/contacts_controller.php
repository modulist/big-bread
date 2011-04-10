<?php

class ContactsController extends AppController {
  public $name       = 'Contacts';
	public $helpers    = array( 'Form' );
  public $components = array( 'SwiftMailer' );
  public $uses       = array( 'UserType' );
  
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
        # TODO: Change the To address. Everywhere.
        $this->SwiftMailer->to       = 'rob@robwilkerson.org';
        
        $this->set( 'name', $this->data['Contact']['name'] );
        $this->set( 'company', $this->data['Contact']['company'] );
        $this->set( 'phone_number', $this->data['Contact']['phone_number'] );
        $this->set( 'zip_code', $this->data['Contact']['zip_code'] );
        $this->set( 'organization_type', $this->data['Contact']['organization_type'] );
        $this->set( 'message', $this->data['Contact']['message'] );
        
        try { 
          if( !$this->SwiftMailer->send( 'contact', 'New Contact Request from BigBread.net', 'native' ) ) { 
              $this->log( 'Error sending email' ); 
          }
          else {
            # TODO: Set flash message
          }
        } 
        catch( Exception $e ) { 
          $this->log( 'Failed to send email: ' . $e->getMessage() ); 
        }
        
        # TODO: Redirect somewhere
      }
    }
    $organizationTypes = $this->UserType->find(
      'list',
      array(
        'order' => 'UserType.name',
      )
    );
    
    $this->set( compact( 'organizationTypes' ) );
  }
}
