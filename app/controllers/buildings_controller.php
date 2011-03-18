<?php

class BuildingsController extends AppController {
  public $name = 'Buildings';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( 'questionnaire', 'create' );
  }

  
  /**
   * Displays the survey form.
   *
   * @param 	$arg
   * @return	type		description
   */
  public function questionnaire() {
    /** TODO: RE-ENABLE THIS
     *  TODO: Add test for auth so the form can be accessed both ways
     *  TODO: use diff layouts for iframe/authenticated access
    if( $this->Auth ) {
      
    }
    else {
      if( !$this->accessible() ) {
        $this->header( 'HTTP/1.1 403 Forbidden' );
        throw new Exception( 'Access Forbidden' );
      }
    }

    */
    
    $this->layout           = 'iframe';
    $this->helpers[]        = 'Form';
    
    /** Populate Lookups */
    $basementTypes = $this->Building->BasementType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $buildingShapes = $this->Building->BuildingShape->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $buildingTypes = $this->Building->BuildingType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $energySources = $this->Building->BuildingProduct->Product->EnergySource->find(
      'list',
      array( 'order' => 'name' )
    );
    $exposureTypes = $this->Building->ExposureType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $insulationLevels = $this->Building->BuildingWallSystem->InsulationLevel->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $maintenanceLevels = $this->Building->MaintenanceLevel->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $frameMaterials = $this->Building->BuildingWindowSystem->FrameMaterial->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $roofSystems = $this->Building->BuildingRoofSystem->RoofSystem->find(
      'all',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $shadingTypes = $this->Building->ShadingType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $states = $this->Building->Address->State->find(
      'list',
      array( 'order' => 'state' )
    );
    $technologies = $this->Building->BuildingProduct->Product->Technology->find(
      'list',
      array(
        'conditions' => array( 'Technology.questionnaire_product' => 1 ),
        'order' => array( 'incentive_tech_group_id', 'name' ),
      )
    );
    $userTypes = $this->Building->Client->UserType->find(
      'list',
      array( 'conditions' => array( 'name' => array( 'Homeowner', 'Buyer' ), 'deleted' => 0 ), 'order' => 'name' )
    );
    $wallSystems = $this->Building->BuildingWallSystem->WallSystem->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $windowPaneTypes = $this->Building->BuildingWindowSystem->WindowPaneType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    
    /** Prepare the view */
    $this->set( compact( 'buildingTypes', 'basementTypes', 'buildingShapes', 'energySources', 'exposureTypes', 'frameMaterials', 'insulationLevels', 'maintenanceLevels', 'roofSystems', 'shadingTypes', 'states', 'technologies', 'userTypes', 'wallSystems', 'windowPaneTypes' ) );
  }
  
  public function create() {
    new PHPDump( $this->data, 'DATA', '', true ); # exit;
    
    /**
     * We can only take one user with a given email address. If anyone
     * associated with the building has an email that already exists,
     * we're just going to assume that it's the same person and save
     * only the id.
     */
    $realtor = !empty( $this->data['Realtor']['email'] )
      ? $this->Building->Realtor->known( $this->data['Realtor']['email'] )
      : false;
    if( $realtor ) {
      $this->data['Building']['realtor_id'] = $realtor;
      unset( $this->data['Realtor'] );
    }
    $inspector = !empty( $this->data['Inspector']['email'] )
      ? $this->Building->Inspector->known( $this->data['Inspector']['email'] )
      : false;
    if( $inspector ) {
      $this->data['Building']['inspector_id'] = $inspector;
      unset( $this->data['Inspector'] );
    }
    $client = !empty( $this->data['Client']['email'] )
      ? $this->Building->Client->known( $this->data['Client']['email'] )
      : false;
    if( $client ) {
      $this->data['Building']['client_id'] = $client;
      unset( $this->data['Client'] );
    }
    /** END : user detection */
    
    /**
     * As with users, we don't want redundant products in our catalog.
     * For products, the combination of make, model & serial number
     * determines uniqueness.
     */
    /** 
    foreach( $this->data['Product'] as $product ) {
      /** TODO: check existence
    } */
    
    if( $this->Building->saveAll( $this->data ) ) {
      exit( 'saved' );
    }
    else {
      new PHPDump( $this->Building->invalidFields(), 'Invalid fields' );
      exit( 'failed' );
    }
    
  }
}
