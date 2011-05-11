<?php

class UsersController extends AppController {
  public $name    = 'Users';
  public $helpers = array( 'Form' );
  public $components = array( 'SwiftMailer' );
  
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
    $this->Auth->allow( '*' );
    $this->Auth->deny( 'dismiss_notice' );
  }

  /**
   * Allows a user to register.
   *
   * @return  void
   * @access  public
   */
  public function register( $invite = null ) {
    # Handle a submitted registration
    if( $this->RequestHandler->isPost() && !empty( $this->data ) ) {
      /**
       * The password value is hashed automagically. We need to hash the
       * confirmation value manually for validation.
       * @see User::identical()
       */
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      if( $this->User->save( $this->data ) ) {
        $this->Session->setFlash( 'Welcome to BigBread. Thanks for registering.', null, null, 'success' );
        $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
        $this->Auth->login( $this->data );
        $this->set_user_type();
        
        $this->redirect( $this->Auth->redirect(), null, true );
      }
      else {
        $this->Session->setFlash( 'There\'s a problem with your registration. Please correct the errors below.', null, null, 'validation' );
        $this->data['User']['password'] = '';
        $this->data['User']['confirm_password'] = '';
      }
    }
    else if( !empty( $invite ) ) {
      $user = $this->User->find(
        'first',
        array(
          'contain'    => false,
          'conditions' => array( 'User.invite_code' => $invite ),
        )
      );
      
      if( empty( $user ) ) { # Unrecognized invite code
        $this->Session->setFlash( 'That invite code was not recognized. You can still register as a new user.', null, null, 'warn' );
      }
      else { # Invited user found
        if( !empty( $user['User']['password'] ) ) { # Invited user has already registered
          $this->Session->setFlash( 'That invite code has already been used. Please login.', null, null, 'error' );
          $this->redirect( array( 'action' => 'login' ), null, true );
        }
        else { # This is the invited user. We have what we need
          $this->data = $user;
          $this->set( 'ignore_validation', true );
        }
      }
    }

    // Populate the available user types
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
      $this->set_user_type();
			$this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
      
      if( $this->User->has_building( $this->Auth->User('id') ) ) {
        $this->redirect( array( 'controller' => 'buildings', 'action' => 'incentives' ), null, true );
      }
      else {
        $this->redirect( $this->Auth->redirect(), null, true );
      }
		}
    /** Probably an error logging in */
    else if( !empty( $this->data ) ) {
      /** Clear the password fields we we don't display encrypted values */
      $this->data['User']['password'] = null;
    }
    
		$this->set( 'title_for_layout', 'Login' );
	}
  
  /**
   * Forgot password page
   *
   * @access	public
   */
  public function forgot_password() {
    $this->layout = 'blank';
    
    if( !empty( $this->data )  ) {
      if( empty( $this->data['User']['email'] ) ) {
        $this->User->invalidate( 'email', 'notempty' );
      }
      else if( !Validation::email( $this->data['User']['email'] ) ) {
        $this->User->invalidate( 'email', 'email' );
      }
      else {
        $user_id = $this->User->known( $this->data['User']['email'] );
        
        if( $user_id ) {
          $this->User->id = $user_id;
          
          # Get or generate and invite code
          $invite_code = $this->User->field( 'invite_code', array( 'User.id' => $user_id ) );
          if( empty( $invite_code ) ) {
            $invite_code = User::generate_invite_code();
            $this->User->saveField( 'invite_code', $invite_code );
          }
          
          $this->User->saveField( 'password', null );
          
          /** 
          $this->SwiftMailer->smtpType = 'tls'; 
          $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
          $this->SwiftMailer->smtpPort = 465; 
          $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
          $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
          */
          $this->SwiftMailer->sendAs   = 'both'; 
          $this->SwiftMailer->from     = 'DO-NOT-REPLY@bigbread.net'; 
          $this->SwiftMailer->fromName = 'BigBread.net';
          $this->SwiftMailer->to       = $this->data['User']['email'];
          
          //set variables to template as usual 
          $this->set( 'invite_code', $invite_code ); 
           
          try { 
            if( !$this->SwiftMailer->send( 'forgot_password', 'Your BigBread.net Password Has Been Reset', 'native' ) ) {
              foreach($this->SwiftMailer->postErrors as $failed_send_to) { 
                $this->log( 'Failed to send forgot password email to ' . $failed_send_to ); 
              }
            }
            
            $this->Session->setFlash( 'Your password has been reset. Please check your email for instructions.', null, null, 'success' );
          } 
          catch( Exception $e ) { 
            $this->log( 'Failed to send email: ' . $e->getMessage() ); 
          }
        }
        else {
          $this->User->invalidate( 'email', 'No user is registered with this email address.' );
        }
      }
    }
  }
	
  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function logout() {
    $this->redirect( $this->Auth->logout(), null, true );
	}
  
  /**
   * Dismisses an optional notice.
   *
   * @return	void
   * @access	public
   */
  public function dismiss_notice( $notice ) {
    $this->autoRender = false;
    
    $this->User->id = $this->Auth->user( 'id' );
    if( $this->User->saveField( 'show_' . $notice, 0 ) ) {
      # Update the session value
      $this->Session->write( 'Auth.User.show_questionnaire_instructions', 0 );
    }
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
  
  /**
   * PRIVATE METHODS
   */
  
  /**
   * Writes the authenticated user's primary role (UserType) to the
   * authenticated session.
   *
   * @return boolean
   */
  private function set_user_type() {
    if( $this->Auth->user() ) {
      $user_type = $this->User->UserType->find(
        'first',
        array(
          'contain'    => false,
          'fields'     => array( 'id', 'name' ),
          'conditions' => array( 'UserType.id' => $this->Auth->user( 'user_type_id' ) ),
        )
      );
      $this->Session->write( 'Auth.UserType', $user_type['UserType'] );
    }
  }
}
