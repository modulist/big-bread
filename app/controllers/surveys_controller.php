<?php

class SurveysController extends AppController {
  public $name = 'Surveys';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( 'create' );
  }

  
  /**
   * Displays the survey form.
   *
   * @param 	$arg
   * @return	type		description
   */
  public function create() {
    if( !$this->accessible() ) {
      $this->header( 'HTTP/1.1 403 Forbidden' );
      throw new Exception( 'Access Forbidden' );
    }
    
    $this->layout           = 'iframe';
    $this->helpers[]        = 'Form';
    
    /** Populate Lookups */
    $applianceTypes = $this->Survey->Building->BuildingAppliance->Appliance->ApplianceType->find(
      'all',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $basementTypes = $this->Survey->Building->BasementType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $buildingShapes = $this->Survey->Building->BuildingShape->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $buildingTypes = $this->Survey->Building->BuildingType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $energySources = $this->Survey->Building->BuildingAppliance->Appliance->EnergySource->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $exposureTypes = $this->Survey->Building->ExposureType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $insulationLevels = $this->Survey->Building->BuildingWallSystem->InsulationLevel->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $maintenanceLevels = $this->Survey->Building->MaintenanceLevel->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $roofSystems = $this->Survey->Building->BuildingRoofSystem->RoofSystem->find(
      'all',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $shadingTypes = $this->Survey->Building->ShadingType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $states = $this->Survey->Building->Address->State->find(
      'list',
      array( 'order' => 'state' )
    );
    $userTypes = $this->Survey->Building->Client->UserType->find(
      'list',
      array( 'conditions' => array( 'name' => array( 'Homeowner', 'Buyer' ), 'deleted' => 0 ), 'order' => 'name' )
    );
    $wallSystems = $this->Survey->Building->BuildingWallSystem->WallSystem->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $windowSystems = $this->Survey->Building->BuildingWindowSystem->WindowSystem->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    
    /** Prepare the view */
    $this->set( compact( 'applianceTypes', 'buildingTypes', 'basementTypes', 'buildingShapes', 'energySources', 'exposureTypes', 'insulationLevels', 'maintenanceLevels', 'roofSystems', 'shadingTypes', 'states', 'userTypes', 'wallSystems', 'windowSystems' ) );
  }
}
