<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
  public $helpers    = array ( 'Html', 'Number', 'Session', 'Text', 'Time' );
  public $components = array ( 'Auth', 'RequestHandler', 'Session', 'DebugKit.Toolbar' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    # Engage SSL in production only (damn Bluehost)
    if( in_array( Configure::read( 'Env.code' ), array( 'LCL', 'PRD' ) ) ) {
      $ssl_actions = array(
        'login',
        'register',
      );
      
      # Force expected actions to https, others away from it.
      if( in_array( $this->action, $ssl_actions ) && !$this->RequestHandler->isSSL() ) {
        $this->forceSSL();
      }
      else if( !in_array( $this->action, $ssl_actions ) && $this->RequestHandler->isSSL() ) {
        $this->unforceSSL();
      }
    }

    # By default, deny access to everything
    $this->Auth->deny( '*' );
    
    $this->Auth->userModel = 'User';
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'
		);
    $this->Auth->userScope = array( 'User.deleted' => 0 );
    $this->Auth->loginAction = array(
      'controller' => 'users',
      'action'     => 'login',
      'admin'      => false
    );
    $this->Auth->autoRedirect = false;
    $this->Auth->loginRedirect = array(
      'controller' => 'buildings',
      'action'     => 'questionnaire',
    );
    $this->Auth->logoutRedirect = Router::url( '/' );
    
    $this->Auth->authError  = __( 'Authentication required. Please login.', true );
    $this->Auth->loginError = __( 'Invalid authentication credentials. Please try again.', true );

    /**
     * API Authentication is a little different
     */
    if( $this->params['controller'] == 'api' ) {
      # Authenticate a user using api key (Authorization header)
      if( !$this->auth_api() ) {
        header( 'Not Authorized', true, 401 );
        exit( 'Unable to authenticate.' );
      }
    }

    /**
     * If data is being submitted, then attach the user data to it
     * so it can potentially be used by the Auditable behavior.
     */
    if( !empty( $this->data ) && empty( $this->data['User'] ) ) {
      $this->data['User'] = $this->current_user();
    }
    
    /**
     * Turn off debug output for ajax requests and don't attempt
     * to automatically render a view.
     */
    if( $this->RequestHandler->isAjax() ) {
      Configure::write( 'debug', 0 );
    }
  }

  public function beforeRender() {
    /**
     * TODO: Move this to a component for clarity?
     * 
     * Updates the associated model's data array with unified datetime
     * values.
     * 
     * This unborks the datetime component array created when submitting a form
     * that contains date, time or datetime fields. Calling this after an
     * invalid save attempt allows the form to receive datetime in a
     * predictable format.
     */
    if( !empty( $this->data[$this->modelClass] ) && $this->{$this->modelClass}->invalidFields() ) {
      $schema = $this->{$this->modelClass}->schema();
      
      foreach( $schema as $field => $meta ) {
        if( isset( $this->data[$this->modelClass][$field] ) && $meta['type'] == 'datetime' ) {
          $this->data[$this->modelClass][$field] = $this->{$this->modelClass}->deconstruct( $field, $this->data[$this->modelClass][$field] );
        }
      }
    }
    
    # If password values are set in the data structure of a GET request,
    # clear them. The encrypted values just create confusion.
    if( $this->RequestHandler->isGet() ) {
      if( isset( $this->data['User']['password'] ) ) {
        $this->data['User']['password'] = '';
      }
      if( isset( $this->data['User']['confirm_password'] ) ) {
        $this->data['User']['confirm_password'] = '';
      }
    }
    
    # Let the view be aware of whether this is an SSL request
    $this->set( 'is_ssl', $this->RequestHandler->isSSL() );
  }
  
  /**
   * PUBLIC FUNCTIONS
   */
  
  /**
   * PROTECTED METHODS
   */
  
  /**
   * Returns the current user object. Used to support the Auditable
   * behavior for delete actions which send no data, but perform a
   * soft delete by updating the active value.
   *
   * @return  array
   * @access  protected
   */
  protected function current_user( $property = null) {
    $user = $this->Auth->user();
    
    if( !empty( $user ) ) {
      if( empty( $property ) ) {
        $user = $user[$this->Auth->userModel]; # Return the complete user array
      }
      else {
        $user = $this->Auth->user( $property ); # Return a specific property
      }
    }
    
    return $user;
  }
  
  /**
   * Refreshes the authenticated user session partially or en masse.
   *
   * @param   $field
   * @param   $value
   * @return  boolean
   * @see     http://milesj.me/blog/read/31/Refreshing-The-Auths-Session
   */
  protected function refresh_auth( $field = null, $value = null ) {
    if( $this->Auth->user() ) {
      if( !empty( $field ) && !empty( $value ) ) { # Refresh a single key
        $this->Session->write( $this->Auth->sessionKey . '.' . $field, $value );
      }
      else { # Refresh the entire session
        $user = ClassRegistry::init('User')->find(
          'first',
          array(
            'contain'    => false,
            'conditions' => array( 'User.id' => $this->Auth->User( 'id' ) ),
          )
        );
        
        $this->Auth->login( $user );
      }
    }
  }
  
  /**
   * PRIVATE METHODS
   */
  
  /**
   * Authenticates API access via an API key.
   *
   * @param   $key
   * @return  booleawn
   */
  private function auth_api() {
    $headers = getallheaders();

    if( !array_key_exists( 'Authorization', $headers ) || empty( $headers['Authorization'] ) ) {
      return false;
    }
   
    $this->User = ClassRegistry::init( 'User' );
    $user = $this->User->find( 'first', array(
      'contain'    => array( 'ApiUser' ),
      'conditions' => array( 'ApiUser.api_key' => $headers['Authorization'] ),
    ));
    
    # Allow for a test authorization key and login as my user (Rob Wilkerson)
    if( empty( $user ) && $headers['Authorization'] == '1001001SOS' ) {
      $user = $this->User->find(
        'first',
        array(
          'conditions' => array( 'User.id' => '4db6ac92-1ee0-402e-b7dc-2fb84293f4e1' ),
        )
      );
    }
    
    return $this->Auth->login( $user['User']['id'] );
  }
  
  /**
   * Force traffic to a given action through SSL.
   */
  private function forceSSL() {
    $this->redirect( 'https://' . $_SERVER['HTTP_HOST'] . $this->here, null, true );
  }
  
  /**
   * Force traffic to a given action away from SSL.
   */
  private function unforceSSL() {
    $this->redirect( 'http://' . $_SERVER['HTTP_HOST'] . $this->here, null, true );
  }
}
