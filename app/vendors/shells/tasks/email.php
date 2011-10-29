<?php

App::import(
  'Core',
  array(
    'Router',     # Required for $this->Html->link() in email views
    'Controller'  # Renders the email content
  )
); 
App::import( 'Component', 'Email' ); # Not used for sending, but for rendering.
App::import( 'Core', 'HttpSocket' ); # Used to engage the SendGrid web api

include( CONFIGS . 'routes.php' );
define( 'FULL_BASE_URL', 'http://www.savebigbread.com' );

class EmailTask extends Shell { 
  public $Controller; # Controller class
  public $Email;      # EmailComponent
  public $HttpSocket; # HttpSocket utility
  
  # Settings cover info sent to the SendGrid via the Web API as well as
  # general email component and/or SMTP options should the method of delivery
  # ever change.
  public $settings = array(
      'environment'      => null,
      'to'               => null,
      'toname'           => null,
      'subject'          => null, 
      'charset'          => 'UTF-8', 
      'from'             => null,
      'fromname'         => null,
      'sendAs'           => 'both', 
      'template'         => null, 
      'debug'            => false, 
      'additionalParams' => '', 
      'layout'           => 'default',
      'delivery'         => 'smtp',
      'smtpOptions'      => array(
        'port'     => 25,
        'host'     => null,
        'timeout'  => 30,
        'username' => null,
        'password' => null,
        'client'   => 'mydomain.com',
      ),
  );

  /**
   * Initializes the EmailTask.
   *
   * @access  public
   */
  public function initialize() { 
    $this->Controller = new Controller();
    $this->Email      = new EmailComponent( null );
    $this->HttpSocket = new HttpSocket();
    
    $this->Email->initialize( $this->Controller ); 
  } 

  /** 
   * Send an email. Currently uses the EmailComponent to render email content
   * and the SendGrid Web API to send, but could easily transition to send via
   * the component as well.
   * 
   * @param   array $settings 
   * @return  boolean 
   */ 
  public function send( $settings = array() ) { 
    $this->settings( $settings );
    
    # BEGIN: Send the email via the SendGrid Web API
    
    # Render text content
    $this->Email->_set( array( 'sendAs' => 'text' ) );
    $text = implode( "\r\n", $this->Email->_render( array() ) );
    
    # Render HTML content
    $this->Email->_set( array( 'sendAs' => 'html' ) );
    $html = implode( "\r\n", $this->Email->_render( array() ) );
    
    # Set SendGrid parameters
    $sendgrid = array(
      'api_user'  => $this->settings['smtpOptions']['username'],
      'api_key'   => $this->settings['smtpOptions']['password'],
      # Set the category to environment_name_of_template (e.g. dev_new_user)
      'x-smtpapi' => json_encode( array( 'category' => sprintf( '%s_%s', $this->settings['smtpOptions']['client'], $this->settings['template'] ) ) ),
      'to'        => $this->settings['to'],
      'toname'    => $this->settings['toname'],
      'from'      => $this->settings['from'],
      'fromname'  => $this->settings['fromname'],
      'subject'   => $this->settings['from'],
      'html'      => trim( $html ),
      'text'      => trim( $text ),
    );
    
    $results = json_decode( $this->HttpSocket->post( 'http://sendgrid.com/api/mail.send.json', $sendgrid ), true );
    
    if( $results['message'] != 'success' ) {
      $this->log( '{EmailTask::send} Failed to send email: ' . json_encode( $results ), LOG_ERR );
    }
    
    return $results['message'] == 'success';
    
    # BEGIN: Send the email via SMTP
    
    # Uncomment the return below to use the Email component for sending.
    # return $this->Email->send();
  } 

  /** 
   * Sets view variables to the Controller so that they will be available when
   * the view renders the template.
   * 
   * @param string $name 
   * @param mixed  $value
   */ 
  public function set( $name, $value ) { 
    $this->Controller->set( $name, $value ); 
  } 

  /** 
   * Change default variables 
   * Fancy if you want to send many emails and only want 
   * to change 'from' or few keys 
   * 
   * @param array $settings 
   */ 
    public function settings( $settings = array() ) {
      $this->Email->_set( $this->settings = array_filter( array_merge( $this->settings, $settings ) )   ); 
    } 
} 