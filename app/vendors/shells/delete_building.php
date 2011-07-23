<?php
    
App::import( 'Core', 'Security' );
    
/**
 * Validates key links in the system and emails a report.
 * Usage: ./cake/console/cake -app <path to app/ directory> delete_building <building_id>
 */
class DeleteBuildingShell extends Shell {
	public $uses = array( 'Building' );

  public function startup() {
    parent::startup();
  }

	public function main() {
		if( isset( $this->args[0] ) && strlen( $this->args[0] ) === 36 ) {
      # Assume a UUID was passed
      $building_id = $this->args[0];
		}
    else {
      # Assume we're testing and create a building before deleting.
      $building_id = $this->create_dummy_building( $building_id );
      $this->out( 'Created a dummy building with id ' . $building_id );
      $this->out( 'Pausing for 30 seconds to verify that the dummy building was created.' );
      sleep( 30 );
    }
    
    $this->out( 'Deleting building ' . $building_id );
    $this->Building->delete( $building_id );
  }
  
  public function create_dummy_building() {
    $user = array(
      'Client' => array(
        'user_type_id' => UserType::OWNER,
        'first_name'   => 'Dummy',
        'last_name'    => 'Data',
        'email'        => 'dummy@data.com',
      ),
    );
    
    if( $this->Building->Client->save( $user ) ) {
      $client_id = $this->Building->Client->id;
    }
    else {
      exit( "Unable to save dummy client: " . debug( $this->Building->Client->invalidFields() ) . "\n" );
    }
    
    $building = array(
      'Questionnaire' => array(
        'deleted' => 0,
      ),
      'Building' => array(
        'building_type_id' => '4d6ff15d-c9d0-4d44-9379-793d3b196446', # Single family
        'client_id'        => $client_id,
        'maintenance_level_id' => '4d6ff15d-fe04-47db-8811-793d3b196446', # Good
        'year_built'           => '1920',
        'finished_sf'          => '2200',
        'stories_above_ground' => 2,
        'insulated_foundation' => 1,
        'skylight_count'       => 4,
        'setpoint_heating'     => 67,
        'setpoint_cooling'     => 76,
      ),
      'BuildingProduct' => array(
        array(
          'product_id' => '4db6bda2-6088-4ed8-a4b5-6d924293f4e1',
          'serial_number' => 'serial_number_1',
        ),
        array(
          'product_id' => '4db6c721-5b74-4bc2-b01b-24754293f4e1',
          'serial_number' => 'serial_number_2',
        ),
        array(
          'product_id' => '4dcc3d7c-68d0-49de-9a52-62964293f4e1',
          'serial_number' => 'serial_number_3',
        ),
      ),
      'BuildingRoofSystem' => array(
        array(
          'roof_system_id' => '4d77eeb6-d174-44e8-9997-99156e891b5e', # Finished attic
          'living_space_ratio' => 100,
        ),
      ),
      'BuildingWallSystem' => array(
        'wall_system_id'      => '4d6ffa65-dba0-4594-8346-7bcd3b196446', # Timber framed
        'insulation_level_id' => '4d700e7a-6108-44cf-9fe4-82376e891b5e', # Good
      ),
      'BuildingWindowSystem' => array(
        array(
          'window_pane_type_id' => '4d6ffa65-73f8-412e-ab8c-7bcd3b196446', # Gas filled
          'frame_material_id'   => '4d6ff15d-63b8-4499-a6cd-793d3b196446', # Wood
          'tinted'              => 0,
          'low_e'               => 1,
        ),
      ),
      'Occupant' => array(
        'age_14_64' => 2,
        'daytime_occupancy' => 1,
        'heating_override'  => 0,
        'cooling_override'  => 1,
      ),
      'Address' => array(
        'model'     => 'Building',
        'address_1' => '1234 Bite Me',
        'zip_code'  => '21224',
      ),
    );
    
    if( !$this->Building->saveAll( $building ) ) {
      debug( $this->Building->invalidFields() );
      exit;
    }
    
    return $this->Building->id;
  }
}
