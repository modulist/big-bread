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
      'edit',
      'unwatch',
      'watch'
    );
    
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
    if( $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }
    
    $invite_code = $this->params['invite_code'];
    $user        = $this->User->find(
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
   * Displays the interface that allows a user to reset their password.
   *
   * @access  public
   */
  public function reset_password() {
    if( $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }
    
    if( !empty( $this->data ) ) { # Do the reset
      $this->User->id = $this->data['User']['id'];
      
      # Massage the password data to get everything encrypted
      $empty_password = empty( $this->data['User']['password'] );
      $this->data['User']['password'] = $this->Auth->password( $this->data['User']['password'] );
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      $user = $this->User->find(
        'first',
        array(
          'contain'    => false,
          'conditions' => array(
            'User.id' => $this->data['User']['id'],
          )
        )
      );
      
      # Setting everything will leverage existing validation.
      $this->data['User'] = Set::merge( $user['User'], $this->data['User'] );
      $this->User->set( $this->data['User'] );
      
      # Empty passwords are not validated by default when editing.
      if( !$empty_password && $this->User->save( $this->data, array( 'fieldList' => array( 'password' ) ) ) ) {
        $this->Session->setFlash( 'Your password has been reset. Let us know if you have any problems logging in.', null, null, 'success' );
        $this->redirect( array( 'action' => 'login' ) );
      }
      else {
        if( $empty_password ) {
          $this->User->validationErrors['password'] = $this->User->validate['password']['notempty']['message'];
        }
        
        # Clear the password so the field displays empty
        $this->data['User']['password'] = $this->data['User']['confirm_password'] = '';
      }
    }
    else { # Load the reset password form
      $invite_code = $this->params['invite_code'];
      $user        = $this->User->find(
        'first',
        array(
          'contain'    => false,
          'fields'     => array( 'User.id', 'User.email', 'User.password' ),
          'conditions' => array( 'User.invite_code' => $invite_code ),
        )
      );
      
      if( empty( $user ) ) { # Unrecognized invite code
        $this->Session->setFlash( 'We don\'t recognize that token. Please click on the link in the email you were sent.', null, null, 'error' );
        $this->redirect( array( 'action' => 'register' ), null, true );
      }
      else { # Invited user found
        if( !empty( $user['User']['password'] ) ) { # Invited user has already registered
          $this->Session->setFlash( 'It looks like you\'ve already reset your password. Please login.', null, null, 'error' );
          $this->redirect( array( 'action' => 'login' ), null, true );
        }
      }
      $this->User->validate = array();
      $this->data = $user;
      $this->User->set( $user );
    }
    
    $invite_code = $this->params['invite_code'];
    
    $this->set( compact( 'invite_code' ) );
  }

  /**
   * Allows a user to register. If the user is invited, a user type and id will
   * be passed because basic info has already been entered.
   *
   * @param   uuid  $user_id
   * @param   $invite
   * @access  public
   */
  public function register( $user_id = null ) {
    if( $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }

    $has_locations = !empty( $user_id )
      ? $this->User->has_locations( $user_id )
      : false;
    
    # Handle a submitted registration
    if( !empty( $this->data ) ) {
      $this->User->id = $user_id;
      
      # Override any user type with whatever came in from the form
      $user_type_id = $this->data['User']['user_type_id'];
      
      # The password value is hashed automagically. We need to hash the
      # confirmation value manually for validation.
      # @see User::identical()
      $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );
      
      # Massage the selected watchlist items into a format we can work with.
      if( !empty( $this->data['WatchedTechnology']['selected'] ) ) {
        $this->data['WatchedTechnology']['selected'] = array_filter( explode( ',', $this->data['WatchedTechnology']['selected'] ) );
      }
      
      # Save the user and their watchlist in a transaction. Model::saveAll()
      # does not work in this scenario.
      $commit = false;
      $ds     = $this->User->getDataSource();
      $ds->begin( $this->User );
      
      if( $this->User->save( $this->data['User'] ) ) {
        if( !empty( $this->data['WatchedTechnology']['selected'] ) ) {
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
          
          if( !in_array( false, Set::flatten( $this->User->TechnologyWatchList->saveAll( $this->data['TechnologyWatchList'], array( 'atomic' => false ) ) ) ) ) {
            $commit = true;
          }
        }
        else {
          $commit = true;
        }
        
        # Save a message record for later delivery
        $replacements = array( 'recipient_first_name' => $this->data['User']['first_name'] );
        $commit = $this->User->Message->queue( MessageTemplate::TYPE_NEW_USER, 'User', $this->User->id, null, $this->User->id, $replacements );

        if( $commit ) {
          $ds->commit( $this->User ); # Commit the user changes in order to complete registration
          $this->complete_registration();
          $this->redirect( $this->Auth->redirect(), null, true );
        }
      }
      
      $ds->rollback( $this->User );
      $this->Session->setFlash( __( 'There\'s a problem with your registration. Please correct the errors below.', true ), null, null, 'validation' );
      
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
      $this->User->set( $this->data );
      
      $this->data['WatchedTechnology']['selected'] = Set::extract( '/TechnologyWatchList/id', $this->data );
    }
    else if( isset( $this->params['url']['zip_code'] ) ) {
      # If the zip code is valid, overwrite the "detected" zip
      if( Validation::postal( $this->params['url']['zip_code'], null, 'us' ) ) {
        $this->Session->write( 'default_zip_code', $this->params['url']['zip_code'] );
      }
    }

    # "Guess" the user type
    $user_type_id = !empty( $this->params['user_type'] )
      ? UserType::$reverse_lookup[$this->params['user_type']]
      : UserType::$reverse_lookup['HOMEOWNER'];
    
    if( !isset( $this->data['WatchedTechnology']['selected'] ) ) {
      $this->data['WatchedTechnology']['selected'] = array();
    }
    
    $watchable_technologies = array_chunk( $this->User->TechnologyWatchList->Technology->grouped(), 2 );
  
    $this->set( compact( 'has_locations', 'user_type_id', 'watchable_technologies' ) );
  }
  
  /**
   * Displays the form to register a new realtor. This is an alias to shared
   * functionality in agent_register().
   *
   * @access  public
   */
  public function realtor_register() {
    $user_type_id = UserType::$reverse_lookup['REALTOR'];
    
    $this->setAction( 'agent_register', $user_type_id );
  }

  /**
   * Displays the form to register a new inspector. This is an alias to shared
   * functionality in agent_register().
   *
   * @access  public
   */
  public function inspector_register() {
    $user_type_id = UserType::$reverse_lookup['INSPECTOR'];
    
    $this->setAction( 'agent_register', $user_type_id );
  }
  
  /**
   * Aggregates the functionality to register an agent.
   *
   * @param   $user_type_id
   * @access  public
   */
  public function agent_register( $user_type_id ) {
    if( $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }
    
    if( !empty( $this->data ) ) {
      $this->data['User']['user_type_id'] = $user_type_id;
      
      # The password value is hashed automagically. We need to hash the
      # confirmation value manually for validation.
      # @see User::identical()
      $this->data['User']['confirm_password'] = Security::hash( $this->data['User']['confirm_password'], null, true );
      
      if( $this->User->save( $this->data['User'] ) ) {
        if( $user_type_id == UserType::$reverse_lookup['REALTOR'] ) {
          $template = MessageTemplate::TYPE_NEW_REALTOR;
        }
        elseif( $user_type_id == UserType::$reverse_lookup['INSPECTOR'] ) {
          $template = MessageTemplate::TYPE_NEW_INSPECTOR;
        }
        else {
          $template = MessageTemplate::TYPE_NEW_USER;
        }
        
        $message_vars = array( 'recipient_first_name' => $this->data['User']['first_name'] );
        $this->User->Message->queue( $template, 'User', $this->User->id, null, $this->User->id, $message_vars );
        
        $this->complete_registration();
        
        # Agents should be sent to the add a location page.
        $this->redirect( array( 'controller' => 'buildings', 'action' => 'add' ), null, true );
      }
      else {
        $this->Session->setFlash( __( 'There\'s a problem with your registration. Please correct the errors below.', true ), null, null, 'validation' );
        
        # If the save fails, blank the password values
        $this->data['User']['password'] = '';
        $this->data['User']['confirm_password'] = '';
      }
    }
    
    $headline = UserType::$lookup[$user_type_id] == 'REALTOR'
      ? __( 'Rebates help close sales', true )
      : __( 'Be a solution hero with huge rebates from SaveBigBread', true );
    $intro = UserType::$lookup[$user_type_id] == 'REALTOR'
      ? __( 'Don\'t let a demand for home repair concessions derail a sale.  Help purchasers feel more confident that there are ways to manage their home repair costs and sellers know that there are replacement $s that don\'t have to come from them.  Everyone wins when they signup on SaveBigBread.', true )
      : __( 'Let your competition be the problem guy while you\'re the solution guy. You\'ll more than offset your fee and create customer awe when you bring big rebates to the table. Be the hero and help your client SaveBigBread.', true );
    
    $this->set( compact( 'headline', 'intro', 'user_type_id' ) );
  } 
  
  /**
   * Does just what it says it does.
   *
   * @return  void
   * @access  public
   */
	public function login() {
    if( empty( $this->data ) && $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }
    
    $this->layout = 'default_login';
    
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
    if( $this->Session->check( 'Auth.User' ) ) {
      $this->redirect( array( 'action' => 'dashboard' ) );
    }
    
    $this->layout = 'default_login';
    
    if( !empty( $this->data )  ) {
      # Override email validation so that only the rules we want get validated
      # But save off the relevant messages first.
      $empty_msg   = $this->User->validate['email']['notempty']['message'];
      $invalid_msg = $this->User->validate['email']['email']['message'];
      $this->User->validate['email'] = array(); 
      
      if( empty( $this->data['User']['email'] ) ) {
        $this->User->invalidate( 'email', $empty_msg );
      }
      else if( !Validation::email( $this->data['User']['email'] ) ) {
        $this->User->invalidate( 'email', $invalid_msg );
      }
      else {
        $user_id = $this->User->known( $this->data['User']['email'] );
        
        if( !empty( $user_id ) ) {
          $this->User->id = $user_id;
          
          # Get or generate and invite code
          $invite_code = $this->User->field( 'invite_code', array( 'User.id' => $user_id ) );
          if( empty( $invite_code ) ) {
            $invite_code = User::generate_invite_code();
            $this->User->saveField( 'invite_code', $invite_code );
          }
          $this->User->saveField( 'password', null );
          
          $user = $this->User->find(
            'first',
            array(
              'contain'    => false,
              'conditions' => array( 'User.id' => $user_id ),
              'fields'     => array(
                'User.first_name',
                'User.email',
              )
            )
          );
          
          # Queue up the message
          $replacements = array(
            'user'        => $user['User'],
            'invite_code' => $invite_code,
          );
          if( $this->User->Message->queue( MessageTemplate::TYPE_FORGOT_PASSWORD, 'User', $this->User->id, null, $this->User->id, $replacements ) ) {
            $this->Session->setFlash( 'An email with instructions on how to reset your password has been sent. If you do not receive it within a few minutes, check your spam folder.', null, null, 'success' );
          
            # Go back where we came from. Help is on the way.
            $this->redirect( array( 'controller' => 'users', 'action' => 'login' ), null, true );
          }
          else {
            $this->Session->setFlash( 'Our apologies, but we seem to be having some trouble handling your request. Please try again shortly.', null, null, 'error' );
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
   * @param   $location_id
   * @param   $user_id
   * @access	public
   */
  public function dashboard( $location_id = null, $user_id = null ) {
    # If we got here as an agent, this isn't their homepage. Redirect accordingly.
    if( User::agent() ) {
      $this->redirect( Configure::read( 'nav.home' ), null, true );
    }
    
    $user_id        = empty( $user_id ) ? $this->Auth->user( 'id' ) : $user_id;
    $location       = array();
    $location_title = $this->Auth->user( 'zip_code' );
    $zip_code       = $this->Auth->user( 'zip_code' );
    
    # Only admins can see someone else's dashboard
    if( $this->Auth->user( 'id' ) !== $user_id && !$this->Auth->user( 'admin' ) ) {
      $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard' ), null, true );
    }

    if( empty( $location_id ) ) { # No location was explicitly requested
      # Use the current location context, if any, or the most recently created location
      $location = $this->Session->read( 'last_accessed_location_id' )
        ? array_shift( $this->User->locations( $user_id, 1, array( 'Building.id' => $this->Session->read( 'last_accessed_location_id' ) ) ) )
        : array_shift( $this->User->locations( $user_id, 1 ) );
    }
    else {
      $location = $this->User->Building->find(
        'first',
        array(
          'contain' => array(
            'Address' => array(
              'ZipCode'
            ),
          ),
          'conditions' => array( 'Building.id' => $location_id ),
        )
      );
    }
    
    if( !empty( $location ) ) {
      # The user can't display a building that doesn't belong to them
      if( !$this->User->Building->belongs_to( $location['Building']['id'], $this->Auth->user( 'id' ) ) ) {
        $this->Session->delete( 'last_accessed_location_id' );
        $this->Session->setFlash( __( 'You\'re not authorized to view that building\'s data.', true ), null, null, 'warning' );
        $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
      }
      
      $location_title = !empty( $location['Building']['name'] ) ? $location['Building']['name'] : $location['Address']['address_1'];
      $zip_code       = $location['Address']['zip_code'];
      
      # Set this location as the default context for other actions
      $this->Session->write( 'last_accessed_location_id', $location['Building']['id'] );
    }
    
    # Other locations that the user will be able to switch to
    $other_locations = $this->User->locations( null, null, array( 'Building.id <> ' => $location['Building']['id'] ) );
    
    # All of the equipment installed in the current location
    $fixtures = $this->User->Building->Fixture->find(
      'all',
      array(
        'contain'    => array( 'Technology' ),
        'conditions' => array(
          'Fixture.building_id' => $location['Building']['id'],
          'Fixture.service_out' => null,
        ),
        'fields' => array(
          'Fixture.id',
          'Fixture.building_id',
          'Fixture.name',
          'Fixture.make',
          'Fixture.model',
          'Technology.title',
        ),
        'order' => array(
          'Fixture.modified DESC',
        ),
      )
    );
    
    # Quotes requested by this user that haven't been completed.
    $pending_quotes = $this->User->quotes( $this->Auth->user( 'id' ), $location_id );
    
    # The user's technology watchlist
    $watchable_technologies = array_chunk( $this->User->TechnologyWatchList->Technology->grouped(), 2 );
    $technology_watch_list = Set::extract( '/TechnologyWatchList/technology_id', $this->User->technology_watch_list( $location_id ) );
    
    # Rebates relevant to this location (or the default zip code), filtered by
    # technologies the user has identified as interests.
    $rebates = Set::combine( $this->User->Building->incentives( $zip_code ), '{n}.TechnologyIncentive.id', '{n}', '{n}.Technology.title' );
    
    $this->set( compact( 'fixtures', 'location', 'location_title', 'other_locations', 'pending_quotes', 'rebates', 'technology_watch_list', 'watchable_technologies' ) );
  }
  
  /**
   * Displays the user profile page.
   *
   * @access	public
   */
  public function edit() {
    if( !empty( $this->data ) ) {
      # TODO: Handle data entry
    }
    else {
      $this->data = $this->User->find(
        'first',
        array(
          'contain'    => false,
          'conditions' => array( 'User.id' => $this->Auth->user( 'id' ) ),
        )
      );
      
      $this->User->set( $this->data );
    }
    
    $user_has_locations = $this->User->has_locations();
    
    $this->set( compact( 'user_has_locations' ) );
  }
  
  /**
   * Adds an item to a user's watchlist.
   *
   * @param   $model        What are we watching? e.g. Technology
   * @param   $id           Which one are we watching? The watched item's id.
   * @param   $location_id
   * @param   $user_id
   * @access  public
   */
  public function watch( $model, $id, $location_id = null, $user_id = null ) {
    $user_id = empty( $user_id ) ? $this->Auth->user( 'id' ) : $user_id;
    
    # If a location is specified, ensure that the user has a stake in it.
    if( !empty( $location_id ) ) {
      if( !$this->User->Building->belongs_to( $location_id, $user_id ) ) {
        if( !$this->RequestHandler->isAjax() ) {
          $this->Session->setFlash( __( 'You\'re not authorized to access that building\'s data.', true ), null, null, 'warning' );
          $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
        }
      }
    }
    
    if( !$this->User->watch( $model, $id, $user_id, $location_id ) ) {
      $this->Session->setFlash( __( 'There was a problem updating your interests.', true ), null, null, 'error' );
    }
    
    if( !$this->RequestHandler->isAjax() ) {
      $this->redirect( $this->referer( array( 'action' => 'dashboard', $location_id ) ), null, true );
    }
    else {
      # We don't really need to do anything, but we do need to not throw a 404.
      $this->autoRender = false;
    }
  }
  
  /**
   * Removes an item from a user's watchlist.
   *
   * @param   $model        What are we unwatching? e.g. Technology
   * @param   $id           Which one are we unwatching? The watched item's id.
   * @param   $location_id
   * @param   $user_id
   * @access  public
   */
  public function unwatch( $model, $id, $location_id = null, $user_id = null ) {
    $user_id = empty( $user_id ) ? $this->Auth->user( 'id' ) : $user_id;
    
    # If a location is specified, ensure that the user has a stake in it.
    if( !empty( $location_id ) ) {
      if( !$this->User->Building->belongs_to( $location_id, $user_id ) ) {
        if( !$this->RequestHandler->isAjax() ) {
          $this->Session->setFlash( __( 'You\'re not authorized to access that location\'s data.', true ), null, null, 'warning' );
          $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
        }
      }
    }
    
    if( !$this->User->unwatch( $model, $id, $user_id, $location_id ) ) {
      $this->Session->setFlash( __( 'There was a problem updating your interests.', true ), null, null, 'error' );
    }
    
    if( !$this->RequestHandler->isAjax() ) {
      $this->redirect( $this->referer( array( 'action' => 'dashboard', $location_id ) ), null, true );
    }
    else {
      # We don't really need to do anything, but we do need to not throw a 404.
      $this->autoRender = false;
    }
  }
  
  /**
   * PRIVATE METHODS
   */
  
  /**
   * Aggregates the functionality required to complete the registration process.
   *
   * @access  private
   */
  private function complete_registration() {
    $this->Session->setFlash( sprintf( __( 'Welcome to SaveBigBread, %s. Thanks for registering.', true ), $this->data['User']['first_name'] ), null, null, 'success' );
    $this->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
    $this->Auth->login( $this->data['User'] ); # Authenticate the new user
  }
}
