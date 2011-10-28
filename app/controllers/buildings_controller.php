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
    
    # TODO: Move this to a component callback?
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
    foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility ) {
      $this->Building->{$utility . 'Provider'}->validate = array();
      
      # Don't save anything if the value is empty
      if( isset( $this->data[$utility . 'Provider'] ) && empty( $this->data[$utility . 'Provider']['name'] ) ) {
        unset( $this->data[$utility . 'Provider'] );
      }
    }
    
    if( !empty( $this->data ) ) {
      if( $this->Building->saveAll( $this->data ) ) {
        $this->Session->setFlash( sprintf( __( '"%s" has been saved.', true ), !empty( $this->data['Building']['name'] ) ? $this->data['Building']['name'] : __( 'Your location', true ) ), null, null, 'success' );
        
        # If this is our first building, then we want to update the user's
        # "default" interests to attach them to the new location.
        if( $this->Building->Client->has_locations() === 1 ) {
          $updated = $this->Building->Client->TechnologyWatchList->updateAll(
            array( 'TechnologyWatchList.location_id' => "'" . $this->Building->id . "'" ),
            array(
              'TechnologyWatchList.model'       => 'Technology',
              'TechnologyWatchList.user_id'     => $this->Auth->user( 'id' ),
              'TechnologyWatchList.location_id' => null,
            )
          );
        }
        
        $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard', $this->Building->id ), null, true );
      }
      else {
        $this->Session->setFlash( __( 'There was an error saving this location.', true ), null, null, 'validation' );
      }
    }
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
    if( empty( $location_id ) ) {
      $location = $this->Building->Client->locations( $user_id, 1 );
      
      if( !empty( $location ) ) {
        $location = $location[0];
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
            'OR' => array(
              'Building.client_id'    => $user_id,
              'Building.realtor_id'   => $user_id,
              'Building.inspector_id' => $user_id,
            )
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
    else if( empty( $location['Building']['name'] ) ) {
      $rebates_for = $location['Address']['address_1'];
    }
    else {
      $rebates_for = $location['Building']['name'];
    }
    
    # Pull the technology watch list and reduce it to just the technology ids
    # so we can just use in_array() while looping.
    $watched_technologies = $this->Building->Client->technology_watch_list( $location_id );
    $watched_technologies = Set::extract( '/TechnologyWatchList/technology_id', $watched_technologies );
    
    $this->set( compact( 'location_id', 'rebates', 'rebates_for', 'watched_technologies' ) );
  }
  
  /**
   * PRIVATE METHODS
   */

}