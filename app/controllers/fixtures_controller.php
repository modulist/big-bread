<?php

class FixturesController extends AppController {
	public $name = 'Fixtures';
	
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Displays the form to add building equipment.
   *
   * @access	public
   */
  function add( $location_id ) {
    if( !$this->Fixture->Building->belongs_to( $location_id, $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( __( 'You\'re not authorized to view that building\'s data.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }
    
    if( !empty( $this->data ) ) {
      if( $this->save( $this->data ) ) {
        $this->Session->setFlash( __( 'Your equipment has been saved.', true ), null, null, 'success' );
        unset( $this->data['Fixture'] ); # Clear existing data so we can add another
      }
      else {
        $this->Session->setFlash( __( 'Sorry, we couldn\'t save this piece of equipment. Please fix the errors below.', true ), null, null, 'error' );
      }
    }
    
    $fixtures = $this->Fixture->Building->Fixture->find(
      'all',
      array(
        'contain'    => array( 'Technology' ),
        'conditions' => array(
          'Fixture.building_id' => $location_id,
          'Fixture.service_out' => null,
        ),
        'fields' => array(
          'Fixture.id',
          'Fixture.name',
          'Fixture.make',
          'Fixture.model',
          'Technology.title',
        ),
        'order' => array( 'Fixture.modified DESC' ),
      )
    );
    
    $location = $this->Fixture->Building->find(
      'first',
      array(
        'contain'    => array( 'Address' ),
        'conditions' => array( 'Building.id' => $location_id ),
        'fields'     => array(
          'Building.id',
          'Building.name',
          'Address.address_1',
          'Address.zip_code',
        ),
      )
    );
    # Other locations that the user will be able to switch to
    $other_locations = $this->Fixture->Building->Client->locations( null, null, array( 'Building.id <> ' => $location['Building']['id'] ) );
    
    # Passed along in the form's action
    $action_param = $location['Building']['id'];
    
    # For display purposes
    $location_name = !empty( $location['Building']['name'] )
      ? $location['Building']['name']
      : $location['Address']['address_1'];
      
    # Retrieve and repackage the technology dropdown options
    $raw_tech = $this->Fixture->Technology->grouped();
    $technologies = array();
    foreach( $raw_tech as $group_title => $group ) {
      $technologies[$group_title] = array();
      
      foreach( $group as $technology ) {
        $technologies[$group_title][$technology['Technology']['id']] = Inflector::singularize( $technology['Technology']['title'] );
      }
    }
      
    $this->set( compact( 'action_param', 'fixtures', 'location', 'location_name', 'other_locations', 'technologies' ) );
	}

	public function edit( $fixture_id ) {
    $fixture = $this->Fixture->find(
      'first',
      array(
        'contain'    => false,
        'conditions' => array( 'Fixture.id' => $fixture_id ),
      )
    );
    
    $location = $this->Fixture->Building->find(
      'first',
      array(
        'contain'    => array( 'Address' ),
        'conditions' => array( 'Building.id' => $fixture['Fixture']['building_id'] ),
        'fields'     => array(
          'Building.id',
          'Building.name',
          'Address.address_1',
          'Address.zip_code',
        ),
      )
    );
    
    if( empty( $location ) ) {
      $this->Session->setFlash( __( 'You didn\'t specify the location for which any equipment should be added.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }

    if( !$this->Fixture->Building->belongs_to( $location['Building']['id'], $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( __( 'You\'re not authorized to view that building\'s data.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }
    
    if( empty( $fixture ) ) {
      $this->Session->setFlash( __( 'Sorry, we couldn\'t find the piece of equipment you wanted to edit.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'action' => 'add', $location['Building']['id'] ) ), null, true );
    }
    
    $this->Fixture->id = $fixture_id;
    
    if( !empty( $this->data ) ) {
      if( $this->save( $this->data ) ) {
        $this->Session->setFlash( __( 'Your equipment has been updated.', true ), null, null, 'success' );
        $this->redirect( array( 'action' => 'add', $location['Building']['id'] ), null, true );
      }
      else {
        $this->Session->setFlash( __( 'Sorry, we couldn\'t update this piece of equipment. Please fix the errors below.', true ), null, null, 'error' );
      }
    }
    
    # Passed along in the form's action
    $action_param = $fixture['Fixture']['id'];
    
    # Listed in the right sidebar
    $fixtures = $this->Fixture->Building->Fixture->find(
      'all',
      array(
        'contain'    => array( 'Technology' ),
        'conditions' => array(
          'Fixture.building_id' => $location['Building']['id'],
          'Fixture.service_out' => null,
          'Fixture.id <> '      => $fixture_id,
        ),
        'fields' => array(
          'Fixture.id',
          'Fixture.name',
          'Fixture.make',
          'Fixture.model',
          'Technology.title',
        ),
        'order' => array( 'Fixture.modified DESC' ),
      )
    );
    
    # For display purposes
    $location_name = !empty( $location['Building']['name'] )
      ? $location['Building']['name']
      : $location['Address']['address_1'];
      
    # Retrieve and repackage the technology dropdown options
    $raw_tech = $this->Fixture->Technology->grouped();
    $technologies = array();
    foreach( $raw_tech as $group_title => $group ) {
      $technologies[$group_title] = array();
      
      foreach( $group as $technology ) {
        $technologies[$group_title][$technology['Technology']['id']] = Inflector::singularize( $technology['Technology']['title'] );
      }
    }
    
    # If data was submitted, we need to retain that for display
    if( empty( $this->data ) ) {
      $this->data = $fixture;
    }
    
    $this->set( compact( 'action_param', 'fixtures', 'location', 'location_name', 'technologies' ) );
	}
  
	public function retire( $id ) {
    $location_id = $this->Fixture->field( 'building_id', array( 'Fixture.id' => $id ) );
    
    if( !$this->Fixture->Building->belongs_to( $location_id, $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( __( 'You\'re not authorized to view that building\'s data.', true ), null, null, 'warning' );
      $this->redirect( $this->referer( array( 'controller' => 'users', 'action' => 'dashboard' ) ), null, true );
    }
    
		if( $this->Fixture->retire( $id ) ) {
      $this->Session->setFlash( __( 'The selected piece of equipment has been retired.', true ), null, null, 'success' );
      $this->redirect( array( 'action' => 'add', $location_id ), null, true );
    }
		$this->flash( __( 'The selected piece of equipment could not be retired.', true) );
		$this->redirect( array( 'action' => 'edit', $id ), null, true );
	}

  /**
   * PRIVATE METHODS
   */
  
  /**
   * Saves fixture data.
   *
   * @param   $data
   * @return  boolean
   * @access  private
   */
  private function save( $data ) {
    if( !empty( $data ) && is_array( $data ) ) {
      $data['Fixture']['purchase_price'] = !empty( $data['Fixture']['purchase_price'] )
        ? money_format( '%.2i', $this->data['Fixture']['purchase_price'] )
        : null;
      
      return $this->Fixture->save( $data );
    }
  }

}
