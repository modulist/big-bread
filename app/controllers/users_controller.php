<?php

class UsersController extends AppController {
  public $name    = 'Users';
  public $helpers = array( 'Form', 'FormatMask.Format' );
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );
  
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
    
    # Squash the phone number if it exists in a data array to prep for save
    if( !empty( $this->data[$this->User->alias]['phone_number'] ) && is_array( $this->data[$this->User->alias]['phone_number'] ) ) {
      $this->data[$this->User->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->User->alias]['phone_number'] );
    }
  }
  
  public function beforeRender() {
    parent::beforeRender();
    
    # Explode the phone number if it exists in a data array to prep for form display
    if( isset( $this->data[$this->User->alias]['phone_number'] ) && is_string( $this->data[$this->User->alias]['phone_number'] ) ) {
      $this->data[$this->User->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->User->alias]['phone_number'] );
    }
  }
  
  /**
   * Accepts an invited user and forwards information to the register()
   * method for shared functionality. Handling the invite is slightly
   * specialized and we want to use register() for add/edit functionality.
   *
   * @access	public
   */
  public function invite() {
    $invite_code = $this->params['invite_code'];
    
    $user = $this->User->find(
      'first',
      array(
        'contain'    => false,
        'fields'     => array( 'User.id', 'User.password' ),
        'conditions' => array( 'User.invite_code' => $invite_code ),
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
      else {
        $this->redirect( array( 'action' => 'register', $user['User']['id'] ), null, true );
      }
    }
    
    $this->redirect( array( 'action' => 'register' ), null, true );
  }

  /**
   * Allows a user to register.
   *
   * @param   $user_id
   * @param   $invite
   * @access  public
   */
  public function register( $user_id = null ) {
    $this->User->id = $user_id;
    
    # Handle a submitted registration
    if( !empty( $this->data ) ) {
      /**
       * The password value is hashed automagically. We need to hash the
       * confirmation value manually for validation.
       * @see User::identical()
       */
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      if( $this->User->save( $this->data ) ) {
        $this->Session->setFlash( 'Welcome to BigBread. Thanks for registering.', null, null, 'success' );
        $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
        $this->Auth->login( $this->data ); # Authenticate the new user
        
        # Update the session info
        $this->refresh_auth();
        
        $this->redirect( $this->Auth->redirect(), null, true );
      }
      else {
        $this->Session->setFlash( 'There\'s a problem with your registration. Please correct the errors below.', null, null, 'validation' );
        
        # If the save fails, set the user id so that the form is rendered
        # for editing, if applicable
        $this->data['User']['id'] = $user_id;
        
        # If the save fails, blank the password values
        $this->data['User']['password'] = '';
        $this->data['User']['confirm_password'] = '';
      }
    }
    else {
      # I have no idea why this has to be done, but the user data is
      # getting validated when first entering the app.
      $this->User->validate = array();
      
      # Populate existing data, if any
      $this->data = $this->User->find(
        'first',
        array(
          'contain'    => false,
          'conditions' => array( 'User.id' => $user_id ),
        )
      );
    }
    
    // Populate the available user types
    $userTypes = $this->User->UserType->find(
      'list',
      array(
        'contain'    => false,
        'conditions' => array( 'selectable' => 1, 'deleted' => 0 ),
        'order' => 'name'
      )
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
			$this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
      
      # Update the session value
      $this->refresh_auth( 'last_login', date( 'Y-m-d H:i:s' ) );
      
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
          $this->SwiftMailer->from     = Configure::read( 'email.do_not_reply_address' ); 
          $this->SwiftMailer->fromName = 'BigBread.net';
          $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
            ? Configure::read( 'email.redirect_all_email_to' )
            : $this->data['User']['email'];
          
          
          //set variables to template as usual 
          $this->set( 'invite_code', $invite_code ); 
           
          try {
            if( !$this->SwiftMailer->send( 'forgot_password', 'Your BigBread.net password has been reset', 'native' ) ) {
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
      $this->refresh_auth();
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
  
}
