<?php

class UsersController extends AppController {
	public $name    = 'Users';
	public $helpers = array( 'Form' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
    
    /**
     * The password is auto hashed only if the username reset is located
     * in this controller Not in AppController. I don't know why.
     */
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'
		);
    $this->Auth->allow( 'register', 'login', 'logout' );
  }

  /**
   * Allows a user to register.
   *
   * @return  void
   * @access  public
   */
  public function register() {
    if( !empty( $this->data ) ) {
      /**
       * The password value is hashed automagically. We need to hash the
       * confirmation value manually for validation.
       * @see User::identical()
       */
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      if( $this->User->save( $this->data ) ) {
        $this->Session->setFlash( 'Welcome to BigBread', null, null, 'success' );
        $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
        $this->Auth->login( $this->data );
        $this->redirect( $this->Auth->redirect() );
      }
      else {
        $this->Session->setFlash( 'Oh noz. There\'s a problem with your registration.', null, null, 'validation' );
      }
    }
    
    $userTypes = $this->User->UserType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    
    $this->set( compact( 'userTypes' ) );
  }

  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function login() {
    /** Logging in and authenticated */
    if ( !empty( $this->data ) && $this->Auth->user() ) {
      $this->User->id = $this->Auth->user( 'id' );
      $user_type = $this->User->UserType->find(
        'first',
        array(
          'contain'    => false,
          'fields'     => array( 'id', 'name' ),
          'conditions' => array( 'UserType.id' => $this->Auth->User( 'user_type_id' ) ),
        )
      );
      $this->Session->write( 'Auth.UserType', $user_type['UserType'] );
      
			$this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
			$this->redirect( $this->Auth->redirect() );
		}
    /** Probably an error logging in */
    else if( !empty( $this->data ) ) {
      /** Clear the password fields we we don't display encrypted values */
      $this->data['User']['password'] = null;
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
