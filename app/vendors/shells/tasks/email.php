<?php

App::import( 'Core', array( 'Router', 'Controller' ) ); # Required for $this->Html->link() in email views
App::import( 'Component', 'Email' );

include( CONFIGS . 'routes.php' );
define( 'FULL_BASE_URL', 'http://www.savebigbread.com' );

class EmailTask extends Shell { 
  public $Controller; # Controller class
  public $Email;      # EmailComponent
  
  public $defaults = array( 
      'to'               => null, 
      'subject'          => null, 
      'charset'          => 'UTF-8', 
      'from'             => null, 
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
    
    return $this->Email->send();
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
      $this->Email->_set( $this->defaults = array_filter( array_merge( $this->defaults, $settings ) )   ); 
    } 
} 