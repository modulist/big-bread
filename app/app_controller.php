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
	public $components = array ( 'Auth', 'RequestHandler'/** , 'Security' */, 'Session' );
  
	/**
	 * CALLBACKS
	 */
	
	public function beforeFilter() {
		$this->Auth->deny( '*' );
		
		$this->Auth->userModel = 'User';
		$this->Auth->userScope = array( 'User.deleted' => 0 );
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action'     => 'login',
			'admin'      => false
		);
		$this->Auth->autoRedirect = false;
		$this->Auth->loginRedirect = array(
			'controller' => 'buildings',
			'action'     => 'show_all',
		);
		$this->Auth->logoutRedirect = array(
      'controller' => 'pages',
      'action' => 'home'
    );
    $this->Auth->authError      = 'Authentication required. Please Login.';
		$this->Auth->loginError     = 'Invalid authentication credentials. Please try again.';

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
	}
  
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
  protected function current_user() {
    $user = $this->Auth->user();
    
    return $user ? $user[$this->Auth->userModel] : null;
  }
  
  /**
   * Provides a very loose authentication mechanism for selected
   * controllers. And by loose, we really just mean a request that:
   *  - The referrer is a recognized partner TLD
   *  - A (syntactically) valid contractor email address was passed
   *
   * @return  boolean
   * @public  protected
   */
  protected function accessible() {
    $accessible    = false;
    $this->Partner = ClassRegistry::init( 'Partner' );
    
    /** Ensure that the referrer is a partner domain */
    $referrer         = parse_url( $this->referer() );
    $referring_domain = $referrer['host'];
    $tld              = preg_replace( '/^.*\.([^.]+\.[^.]+)$/', "$1", $referring_domain );
    
    $partner = $this->Partner->find(
      'first',
      array(
        'contain' => array( "PartnerDomain.top_level_domain LIKE '%" . $tld . "'" )
      )
    );
    
    if( !empty( $partner ) && !empty( $partner['PartnerDomain'] ) && !empty( $this->params['url']['contractor'] ) ) {
      /** The site is a match, ensure that a value contractor email was passed */
      return Validation::email( base64_decode( $this->params['url']['contractor'] ) );
    }
    
    return false;
  }
}
