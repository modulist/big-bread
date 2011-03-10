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
    $frameMaterials = $this->Survey->Building->BuildingWindowSystem->FrameMaterial->find(
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
    $technologies = $this->Survey->Building->BuildingProduct->Product->Technology->find(
      'list',
      array(
        'conditions' => array( 'Technology.questionnaire_product' => 1 ),
        'order' => array( 'incentive_tech_group_id', 'name' ),
      )
    );
    $userTypes = $this->Survey->Building->Client->UserType->find(
      'list',
      array( 'conditions' => array( 'name' => array( 'Homeowner', 'Buyer' ), 'deleted' => 0 ), 'order' => 'name' )
    );
    $wallSystems = $this->Survey->Building->BuildingWallSystem->WallSystem->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $windowPaneTypes = $this->Survey->Building->BuildingWindowSystem->WindowPaneType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    
    /** Prepare the view */
    $this->set( compact( 'buildingTypes', 'basementTypes', 'buildingShapes', 'exposureTypes', 'frameMaterials', 'insulationLevels', 'maintenanceLevels', 'roofSystems', 'shadingTypes', 'states', 'technologies', 'userTypes', 'wallSystems', 'windowPaneTypes' ) );
  }
}
