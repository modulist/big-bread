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
    
    $this->Auth->allow( '*' );
    $this->Auth->deny(
      'dashboard',
      'dismiss_notice', # TODO: Kill this action?
      'edit'
    );
    
    # TODO: Move this to a component callback?
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
    # Handle a submitted registration
    if( !empty( $this->data ) ) {
      $this->User->id = $user_id;

      # The password value is hashed automagically. We need to hash the
      # confirmation value manually for validation.
      # @see User::identical()
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      # Get the selected watchlist items in a format we can work with
      $this->data['WatchedTechnology']['selected'] = array_filter( explode( ',', $this->data['WatchedTechnology']['selected'] ) );
      
      # Save the user and their watchlist in a transaction. Model::saveAll()
      # does not work in this scenario.
      $ds= $this->User->getDataSource();
      $ds->begin( $this->User );
      
      if( $this->User->save( $this->data['User'] ) ) {
        # Build an array of TechnologyWatchList items
        # Set property defaults for a watchlist item.
        $tech_watchlist_defaults = array(
          'user_id'     => $this->User->id,
          'model'       => 'Technology',
          'foreign_key' => null,
        );
        # Compile an array of TechnologyWatchList object data
        $this->data['TechnologyWatchList'] = array();
        foreach( $this->data['WatchedTechnology']['selected'] as $technology_id ) {
          $tech_watch_list_item = array( 'foreign_key' => $technology_id );
          
          array_push( $this->data['TechnologyWatchList'], array_merge( $tech_watchlist_defaults, $tech_watch_list_item ) );
        }
      
        if( !in_array( false, $this->User->TechnologyWatchList->saveAll( $this->data['TechnologyWatchList'], array( 'atomic' => false ) ) ) ) {
          $this->Session->setFlash( 'Welcome to SaveBigBread. Thanks for registering.', null, null, 'success' );
          $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
          $this->Auth->login( $this->data ); # Authenticate the new user
          
          $ds->commit( $this->User );
          $this->redirect( $this->Auth->redirect(), null, true );
        }
      }
      
      $ds->rollback( $this->User );
      $this->Session->setFlash( 'There\'s a problem with your registration. Please correct the errors below.', null, null, 'validation' );
      
      # If the save fails, set the user id so that the form is rendered
      # for editing, if applicable
      $this->data['User']['id'] = $user_id;
      
      # If the save fails, blank the password values
      $this->data['User']['password'] = '';
      $this->data['User']['confirm_password'] = '';
    }
    else if( !empty( $user_id ) ) {
      # Populate existing data, if any
      $this->data = $this->User->find(
        'first',
        array(
          'contain'    => array( 'TechnologyWatchList' ),
          'conditions' => array( 'User.id' => $user_id ),
        )
      );
      # I have no idea why this has to be done, but without explicitly
      # setting the data, the pre-populated form is displayed with
      # validation errors.
      $this->User->set( $this->data );
      $this->data['WatchedTechnology']['selected'] = Set::extract( '/TechnologyWatchList/id', $this->data );
    }
    else if( isset( $this->params['url']['zip_code'] ) ) {
      # If the zip code is valid, overwrite the "detected" zip
      if( Validation::postal( $this->params['url']['zip_code'], null, 'us' ) ) {
        $this->Session->write( 'default_zip_code', $this->params['url']['zip_code'] );
      }
    }
    
    if( !isset( $this->data['WatchedTechnology']['selected'] ) ) {
      $this->data['WatchedTechnology']['selected'] = array();
    }
    
    $watchable_technologies = array_chunk( $this->User->TechnologyWatchList->Technology->grouped(), 2 );
    
    # new PHPDump( $watchable_technologies ); exit;
  
    $this->set( compact( 'watchable_technologies' ) );
  }

  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function login() {
    # Logging in and authenticated
    if( !empty( $this->data ) && $this->Auth->user() ) {
      $this->User->id = $this->Auth->user( 'id' );
			$this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
      
      # Update the session value
      $this->refresh_auth( 'last_login', date( 'Y-m-d H:i:s' ) );
      
      if( !$this->RequestHandler->isAjax() ) {
        $this->redirect( $this->Auth->redirect(), null, true );
      }
      else {
        $this->autoRender = false;
      }
		}
    # Probably an error logging in
    else if( !empty( $this->data ) ) {
      # Clear the password fields we we don't display encrypted values
      $this->data['User']['password'] = null;
      
      if( $this->RequestHandler->isAjax() ) {
        $this->autoRender = false;
        $this->Session->delete( 'Message.auth' ); # We'll display this manually in an Ajax request.
        header( 'Not Authorized', true, 401 );
      }
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
   
          # @see AppController::__construct() for common settings
          $this->SwiftMailer->sendAs   = 'both'; 
          $this->SwiftMailer->from     = Configure::read( 'email.do_not_reply_address' ); 
          $this->SwiftMailer->fromName = 'SaveBigBread.com';
          $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
            ? Configure::read( 'email.redirect_all_email_to' )
            : $this->data['User']['email'];
          
          
          # set variables to template as usual 
          $this->set( 'invite_code', $invite_code ); 
           
          try {
            if( !$this->SwiftMailer->send( 'forgot_password', 'Your SaveBigBread.com password has been reset', 'native' ) ) {
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
    $this->Session->destroy();
    $this->redirect( $this->Auth->logout(), null, true );
	}
  
  /**
   * Displays the user dashboard.
   *
   * @access	public
   */
  public function dashboard( $user_id = null ) {
    $user_id = empty( $user_id ) ? $this->Auth->user( 'id' ) : $user_id;
    
    $locations    = $this->User->locations( $user_id );
    $location_ids = Set::extract( '/Building/id', $locations );
    
    # All of the equipment installed in this user's buildings
    $fixtures = $this->User->Building->Fixture->find(
      'all',
      array(
        'contain'    => array( 'Technology' ),
        'conditions' => array(
          'Fixture.building_id' => $location_ids,
          'Fixture.service_out' => null,
        ),
        'fields' => array(
          'Fixture.id',
          'Fixture.building_id',
          'Fixture.name',
          'Fixture.make',
          'Fixture.model',
          'Technology.name',
        ),
        'order' => array(
          'Fixture.building_id',
          'Fixture.modified DESC',
        ),
      )
    );
    # Group equipment by building so we can identify it during display
    $fixtures = Set::combine( $fixtures, '{n}.Fixture.id', '{n}', '{n}.Fixture.building_id' );
    
    $this->set( compact( 'fixtures', 'locations' ) );
  }
  
  /**
   * Displays the user profile page.
   *
   * @access	public
   */
  public function edit() {
  
  }
  
  /**
   * Dismisses an optional notice.
   *
   * @return	void
   * @access	public
   * @todo    We can probably kill this
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
   * PRIVATE METHODS
   */
  
}
