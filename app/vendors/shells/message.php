<?php

class MessageShell extends Shell {
  public $uses  = array( 'Message' );
  public $tasks = array( 'Email' ); 
  
  public $Email; # EmailTask

  /** 
   * Startup method for the shell.
   */ 
  function startup() {
    # Set some email 
    $this->Email->settings( array( 
      'smtpOptions' => array(
        'port'     => 587,
        'host'     => 'smtp.sendgrid.net',
        'timeout'  => 30,
        'username' => Configure::read( 'email.sendgrid_username' ),
        'password' => Configure::read( 'email.sendgrid_password' ),
        'client'   => 'savebigbread.com',
      ),
    )); 
  } 

  /** 
   * Retrieves and sends queued messages.
   *
   * @return  boolean
   * @access  public
   */ 
  public function send() {
    $queue = $this->Message->find(
      'all',
      array(
        'contain' => array(
          'MessageTemplate',
          'Recipient',
          'Sender',
        ),
        'conditions' => array(
          'Message.sent' => null,
        ),
        'order' => array( 'Message.created ASC' ),
      )
    );
    
    foreach( $queue as $i => $message ) {
      if( method_exists( $this, 'send_' . strtolower( $message['MessageTemplate']['type'] ) ) ) {
        if( $this->{ 'send_' . strtolower( $message['MessageTemplate']['type'] ) }( $message ) ) {
          $this->Message->id = $message['Message']['id'];
          $this->Message->saveField( 'sent', date( DATETIME_FORMAT_MYSQL ) );
        }
      }
      else {
        $this->out( 'Unable to send a(n) ' . strtolower( $message['MessageTemplate']['type'] ) . ' message.' );
      }
    }
  }
  
  /**
   * Sends an email message.
   *
   * @param   array $message
   * @return  boolean
   * @access  public
   */
  public function send_email( $message ) {
    $settings = array(
      'to'       => sprintf( '%s <%s>', h( $message['Recipient']['full_name'] ), Configure::read( 'email.redirect_to' ) ? Configure::read( 'email.redirect_to' ) : h( $message['Recipient']['email'] ) ),
      'from'     => sprintf( '%s <%s>', !empty( $message['Sender']['id'] ) ? h( $message['Sender']['full_name'] ) : 'SaveBigBread.com', !empty( $message['Sender']['id'] ) ? $message['Sender']['email'] : Configure::read( 'email.do_not_reply_address' ) ),
      'subject'  => h( $message['MessageTemplate']['subject'] ),
      'template' => $message['MessageTemplate']['code'],
    );
    
    $this->Email->set( 'body_text', $message['MessageTemplate']['body_text'] );
    $this->Email->set( 'body_html', $message['MessageTemplate']['body_html'] );
    
    return $this->Email->send( $settings ); 
  }
} 