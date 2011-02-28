<?php

class UsersController extends AppController {
	public $name    = 'Users';
	public $helpers = array( 'Form' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( 'register', 'login', 'logout' );
  }

  /**
   * Allows a user to register.
   *
   * @return  void
   * @access  public
   */
  public function register() {
    
  }

  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function login() {
    if ( !empty( $this->data ) && $this->Auth->user() ) {
			$this->User->id = $this->Auth->user( 'id' );
			$this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
			$this->redirect( $this->Auth->redirect() );
		}
    
		$this->set( 'title_for_layout', 'Login' );
	}
	
  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function logout() {
    $this->redirect( $this->Auth->logout() );
	}
	
  /**
   * Presents the admin options menu.
   *
   * @return  void
   * @access  public
   */
	public function admin_index() {
		$title_for_layout = 'Site Administrator';
		$this->set( compact( 'title_for_layout' ) );
  }
}
