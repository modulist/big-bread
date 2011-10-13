<?php

class FixturesController extends AppController {
	public $name = 'Fixtures';
	
  /**
   * Displays the form to add building equipment.
   *
   * @access	public
   */
  function add( $location_id ) {
    if( !empty( $this->data ) ) {
      # TODO: DO STUFF
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
          'Technology.name',
        ),
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
    
    $location_name = !empty( $location['Building']['name'] )
      ? $location['Building']['name']
      : $location['Address']['address_1'];
      
    # Retrieve and repackage the technology dropdown options
    $raw_tech = $this->Fixture->Technology->grouped();
    $technologies = array();
    foreach( $raw_tech as $group ) {
      $technologies[$group['TechnologyGroup']['title']] = array();
      
      foreach( $group['Technology'] as $technology ) {
        $technologies[$group['TechnologyGroup']['title']][$technology['id']] = $technology['name'];
      }
    }
      
    $this->set( compact( 'location', 'location_name', 'technologies' ) );
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(sprintf(__('Invalid fixture', true)), array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Fixture->save($this->data)) {
				$this->flash(__('The fixture has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Fixture->read(null, $id);
		}
		$buildings = $this->Fixture->Building->find('list');
		$technologies = $this->Fixture->Technology->find('list');
		$energySources = $this->Fixture->EnergySource->find('list');
		$this->set(compact('buildings', 'technologies', 'energySources'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(sprintf(__('Invalid fixture', true)), array('action' => 'index'));
		}
		if ($this->Fixture->delete($id)) {
			$this->flash(__('Fixture deleted', true), array('action' => 'index'));
		}
		$this->flash(__('Fixture was not deleted', true), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
