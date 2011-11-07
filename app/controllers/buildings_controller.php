<?php

class BuildingsController extends AppController {
  public $name       = 'Buildings';
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );
  public $helpers    = array( 'FormatMask.Format' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
    
    $this->Auth->allow( 'highlights' );
    
    # Squash the phone number if it exists in a data array to prep for save
    if( !empty( $this->data[$this->Building->Client->alias]['phone_number'] ) && is_array( $this->data[$this->Building->Client->alias]['phone_number'] ) ) {
      $this->data[$this->Building->Client->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Building->Client->alias]['phone_number'] );
    }
  }

  public function beforeRender() {
    # Explode the phone number if it exists in a data array to prep for form display
    if( isset( $this->data[$this->Building->Client->alias]['phone_number'] ) && is_string( $this->data[$this->Building->Client->alias]['phone_number'] ) ) {
      $this->data[$this->Building->Client->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Building->Client->alias]['phone_number'] );
    }
  }
  
  /**
   * The savings highlights for a given zip code.
   *
   * @param   $zip_code
   * @param   $group_savings  Whether to sum the savings total by tech group
   * @return  array
   * @access  public
   */
  public function highlights( $zip_code, $group_savings = false ) {
    $overview = array(
      'locale'           => $this->Building->Address->ZipCode->locale( $zip_code ),
      'total_savings'    => $this->Building->Address->ZipCode->savings( $zip_code, $group_savings, 'HVAC' ),
      'featured_rebates' => $this->Building->Address->ZipCode->featured_rebates( $zip_code ),
    );
    
    if( $this->RequestHandler->isAjax() ) {
      $this->autoRender = false;
      $this->RequestHandler->setContent( 'json', 'application/json' );
      echo json_encode( $overview );
      exit();
    }
  }
  
  /**
   * Displays the form to add a new location/building.
   *	
   * @access	public
   */
  public function add() {
    if( !empty( $this->data ) ) {
      # Process utility information
      foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility ) {
        $this->Building->{$utility . 'Provider'}->validate = array();
        
        # Don't save anything if the value is empty
        if( isset( $this->data[$utility . 'Provider'] ) && empty( $this->data[$utility . 'Provider']['name'] ) ) {
          unset( $this->data[$utility . 'Provider'] );
        }
      }
      
      # If the user is an agent, client data should be attached      
      if( User::agent() ) {
        $user_id = $this->Building->Client->known( $this->data['Client']['email'] );
        
        # If the client is in our system, just attach him/her as the client for
        # this particular location.
        if( !empty( $user_id ) ) {
          $new_client = false;
          $this->data['Building']['client_id'] = $user_id;
          unset( $this->data['Client'] );
        }
        else {
          $this->data['Client']['invite_code'] = User::generate_invite_code();
          $new_client = true;
        }
      }
      
      if( $this->Building->saveAll( $this->data ) ) {
        $this->Session->setFlash( sprintf( __( '"%s" has been saved.', true ), !empty( $this->data['Building']['name'] ) ? $this->data['Building']['name'] : __( 'Your location', true ) ), null, null, 'success' );
        
        # Agents creating buildings on behalf of a client will initially have
        # the watchlinst assigned to themselves. Once the building is created,
        # transfer them to the client.
        if( User::agent() && $this->Auth->user( 'id' ) != $this->Building->Client->id ) { 
          $this->Building->Client->TechnologyWatchList->updateAll(
            array(
              'TechnologyWatchList.user_id'     => "'" . $this->Building->Client->id . "'",
              'TechnologyWatchList.location_id' => "'" . $this->Building->id . "'"
            ),
            array(
              'TechnologyWatchList.model'       => 'Technology',
              'TechnologyWatchList.user_id'     => $this->Auth->user( 'id' ),
              'TechnologyWatchList.location_id' => null,
            )
          );
        }
        
        if( User::agent() ) {
          if( $new_client ) { # Invite the new user
            $client = array( 'Client' => $this->data['Client'] );

            $message_vars = array(
              'recipient_first_name' => $client['Client']['first_name'],
              'sender_name'          => sprintf( '%s %s', $this->Auth->user( 'first_name' ), $this->Auth->user( 'last_name' ) ),
              'invite_code'          => $client['Client']['invite_code'],
            );
            $this->Building->Client->Message->queue( MessageTemplate::TYPE_INVITE, 'User', $this->Auth->user( 'id' ), null, $this->Building->Client->id, $message_vars );
          }
          else {
            # Pull the client data so we can use it in the email below
            $client = $this->Building->Client->find(
              'first',
              array(
                'contain'    => false,
                'conditions' => array( 'Client.id' => $user_id ),
              )
            );
          }
          
          # Pull the client's watch list
          $technology_watch_list = Set::extract( '/TechnologyWatchList/technology_id', $this->Building->Client->technology_watch_list( $this->Building->id, $this->Building->Client->id ) );
  
          # Pull the rebates relevant for the zip code and defined interests          
          $rebates = Set::combine( $this->Building->incentives( $this->data['Address']['zip_code'], $technology_watch_list ), '{n}.TechnologyIncentive.id', '{n}', '{n}.Technology.title' );

          $message_vars = array(
            'client_name' => sprintf( '%s %s', $client['Client']['first_name'], $client['Client']['last_name'] ),
            'recipient_first_name' => $this->Auth->user( 'first_name' ),
            'rebates' => $rebates,
          );
          $this->Building->Realtor->Message->queue( MessageTemplate::TYPE_CLIENT_REBATES, 'Building', $this->Building->id, null, $this->Auth->user( 'id' ), $message_vars );
          
          $this->redirect( array( 'controller' => 'fixtures', 'action' => 'add', $this->Building->id ), null, true );
        }
        
        # Non-agent users go right back to the dashboard.
        $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard', $this->Building->id ), null, true );
      }
      else {
        $this->Session->setFlash( __( 'There was an error saving this location.', true ), null, null, 'validation' );
      }
    }
    
    # Whether the user already has locations
    $has_locations = $this->Building->Client->has_locations();
    
    # Agents will be asked to identify "default" interests when adding a new location
    if( User::agent() ) {
      $watchable_technologies = array_chunk( $this->Building->Client->TechnologyWatchList->Technology->grouped(), 2 );
    }
    
    $this->set( compact( 'has_locations', 'watchable_technologies' ) );
  }
  
  /**
   * Displays the form to edit a new location/building.
   *
   * @param   $location_id
   * @access	public
   */
  public function edit( $location_id ) {
    if( !$this->Building->belongs_to( $location_id, $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( __( 'You\'re not authorized to access that building\'s data.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }
    
    # In this context, utility data isn't required
    foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility ) {
      $this->Building->{$utility . 'Provider'}->validate = array();
      
      # That said, if they'e emptied a value that already exists, we just want
      # to remove that utility's association with this building; not update the
      # utility itself.
      if( isset( $this->data[$utility . 'Provider'] ) && empty( $this->data[$utility . 'Provider']['name'] ) ) {
        $this->data['Building'][strtolower( $utility ) . '_provider_id'] = null;
        unset( $this->data[$utility . 'Provider'] );
      }
    }
    
    if( !empty( $this->data ) ) {
      # new PHPDump( $this->data ); exit;
    }
    
    $this->Building->id = $location_id;
    
    if( !empty( $this->data ) ) {
      $this->data['Building']['id'] = $location_id;
      
      if( $this->Building->saveAll( $this->data ) ) {
        $this->Session->setFlash( sprintf( __( '"%s" has been updated.', true ), !empty( $this->data['Building']['name'] ) ? $this->data['Building']['name'] : __( 'Your location', true ) ), null, null, 'success' );
        $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard', $location_id ), null, true );
      }
    }
    else {
      $this->data = $this->Building->find(
        'first',
        array(
          'contain'    => array( 'Address', 'ElectricityProvider', 'GasProvider', 'WaterProvider' ),
          'conditions' => array( 'Building.id' => $location_id ),
        )
      );
    }
  }
  
  /**
   * Displays the ways to save content.
   *
   * @param 	$building_id	
   * @access	public
   */
  public function ways_to_save( $location_id = null ) {
    $user_id = $this->Auth->user( 'id' );
    
    # Determine which zip code to use
    if( empty( $location_id ) ) { # No location was explicitly defined
      # Use the current location context, if any, or the most recently created location
      $location = $this->Session->read( 'last_accessed_location_id' )
        ? array_shift( $this->Building->Client->locations( $user_id, 1, array( 'Building.id' => $this->Session->read( 'last_accessed_location_id' ) ) ) )
        : array_shift( $this->Building->Client->locations( $user_id, 1 ) );
      
      if( !empty( $location ) ) {
        $location_id = $location['Building']['id'];
      }
    }
    else {
      $location = $this->Building->find(
        'first',
        array(
          'contain' => array(
            'Address' => array(
              'ZipCode'
            ),
          ),
          'conditions' => array(
            'Building.id' => $location_id,
          ),
        )
      );
    }
    
    $zip_code  = empty( $location )
      ? $this->Auth->user( 'zip_code' )
      : $location['Address']['zip_code'];
    
    # If we still don't have a zip code, redirect to the dashboard
    if( empty( $zip_code ) ) {
      $this->Session->setFlash( 'Please add a location to see your potential savings.', null, null, 'info' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }
    
    $rebates = Set::combine( $this->Building->incentives( $zip_code ), '{n}.TechnologyIncentive.id', '{n}', '{n}.Technology.name' );
    
    if( empty( $location ) ) {
      $rebates_for = $zip_code;
    }
    else {
      # Ensure that the current user can see this building
      if( !$this->Building->belongs_to( $location_id, $this->Auth->user( 'id' ) ) ) {
        $this->Session->setFlash( __( 'You\'re not authorized to access that building\'s data.', true ), null, null, 'warning' );
        $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
      }
      
      if( empty( $location['Building']['name'] ) ) {
        $rebates_for = $location['Address']['address_1'];
      }
      else {
        $rebates_for = $location['Building']['name'];
      }
      
      $this->Session->write( 'last_accessed_location_id', $location_id );
    }

    
    # Other locations that the user will be able to switch to
    $other_locations = $this->Building->Client->locations( null, null, array( 'Building.id <> ' => $location['Building']['id'] ) );
    
    # Pull the technology watch list and reduce it to just the technology ids
    # so we can just use in_array() while looping.
    $watched_technologies = $this->Building->Client->technology_watch_list( $location_id );
    $watched_technologies = Set::extract( '/TechnologyWatchList/technology_id', $watched_technologies );
    
    $this->set( compact( 'location', 'location_id', 'other_locations', 'rebates', 'rebates_for', 'watched_technologies' ) );
  }
  
  /**
   * PRIVATE METHODS
   */

}