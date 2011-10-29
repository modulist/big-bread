<?php

App::import( 'Core', array( 'Router', 'Controller' ) ); # Required for $this->Html->link() in email views
App::import( 'Component', 'Email' );
App::import( 'Core', 'HttpSocket' );

include( CONFIGS . 'routes.php' );
define( 'FULL_BASE_URL', 'http://www.savebigbread.com' );

class EmailTask extends Shell { 
  public $Controller; # Controller class
  public $View;
  public $Email;      # EmailComponent
  public $HttpSocket;
  
  public $defaults = array(
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
    $this->View       = new View( $this->Controller );
    $this->Email      = new EmailComponent( null );
    $this->HttpSocket = new HttpSocket();
    
    $this->Email->initialize( $this->Controller ); 
  } 

  /** 
   * Send an email useing the EmailComponent 
   * 
   * @param   array $settings 
   * @return  boolean 
   */ 
  public function send( $settings = array() ) { 
    $this->settings( $settings );
    
    $this->Email->_set( array( 'sendAs' => 'text' ) );
    $text = implode( "\r\n", $this->Email->_render( array() ) );
    
    $this->Email->_set( array( 'sendAs' => 'html' ) );
    $html = implode( "\r\n", $this->Email->_render( array() ) );
    
    $params = array(
      'api_user'  => $this->defaults['smtpOptions']['username'],
      'api_key'   => $this->defaults['smtpOptions']['password'],
      # Set the category to environment_name_of_template (e.g. dev_new_user)
      'x-smtpapi' => json_encode( array( 'category' => sprintf( '%s_%s', $this->defaults['smtpOptions']['client'], $this->defaults['template'] ) ) ),
      'to'        => $this->defaults['to'],
      'toname'    => $this->defaults['toname'],
      'from'      => $this->defaults['from'],
      'fromname'  => $this->defaults['fromname'],
      'subject'   => $this->defaults['from'],
      'html'      => $html,
      'text'      => $text,
    );
    
    $results = json_decode( $this->HttpSocket->post( 'http://sendgrid.com/api/mail.send.json', $params ), true );
    
    if( $results['message'] != 'success' ) {
      $this->log( '{EmailTask::send} Failed to send email: ' . json_encode( $results ), LOG_ERR );
    }
    
    return $results['message'] == 'success';
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
      # $this->defaults = array_filter( array_merge( $this->defaults, $settings ) );
      $this->Email->_set( $this->defaults = array_filter( array_merge( $this->defaults, $settings ) )   ); 
    } 
} 