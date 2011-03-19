<?php

class BuildingsController extends AppController {
  public $name = 'Buildings';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( 'questionnaire', 'create', 'rebates' );
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
  
  /**
   * Creates a building record (and associated records) from the
   * questionnaire form.
   *
   * @see $this::questionnaire()
   */
  public function create() {
    if( !$this->RequestHandler->isPost() || empty( $this->data ) ) {
      $this->redirect( '/questionnaire' );
    }
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
    
    /** Handle utility providers if an unknown was specified */
    /** TODO: Can we move this down the stack somewhere? */
    foreach( $this->Building->Address->ZipCode->ZipCodeUtility->type_codes as $code => $type ) {
      $type     = strtolower( $type );
      $name     = $this->data['Building'][$type . '_provider_name'];
      
      /** Empty the utility id if the name is empty */
      $this->data['Building'][$type . '_provider_id'] = !empty( $name )
        ? $this->data['Building'][$type . '_provider_id']
        : null;
      
      $id = $this->data['Building'][$type . '_provider_id'];
      
      if( !empty( $name ) ) {
        $provider = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->known( $name, $id );
        
        if( !$provider ) { # The specified provider is not recognized
          /** Pull the state code for the building zip code */
          if( !isset( $state ) ) {
            $state = $this->Building->Address->ZipCode->find(
              'first',
              array(
                'contain'    => false,
                'fields'     => array( 'ZipCode.state' ),
                'conditions' => array( 'ZipCode.zip' => $this->data['Address']['zip_code'] ),
              )
            );
          }
          
          /** Build and save a Utility record and a ZipCodeUtility record */
          $this->data['Utility'] = array(
            'name'     => $name,
            'source'   => 'User',
            'reviewed' => 0,
          );
          $this->data['ZipCodeUtility'] = array(
            'zip'      => $this->data['Address']['zip_code'],
            'state'    => $state['ZipCode']['state'],
            'coverage' => 0,
            'source'   => 'User',
            'reviewed' => 0,
            'type'     => $code
          );
          
          if( $this->Building->Address->ZipCode->ZipCodeUtility->Utility->save( $this->data['Utility'] ) ) {
            $this->data['ZipCodeUtility']['utility_id'] = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->id;
            
            if( !$this->Building->Address->ZipCode->ZipCodeUtility->save( $this->data['ZipCodeUtility'] ) ) {
              /** TODO: Do we want to do something else here? */
              $this->Session->setFlash( 'Unable to attach the specified ' . strtolower( $type ) . ' provider (' . $name . ') to the ' . $this->data['Address']['zip_code'] . ' zip code.', null, null, 'warning' );
            }
          }
          else {
            /** TODO: Do we want to do something else here? */
            $this->Session->setFlash( 'Unable to save ' . strtolower( $type ) . ' provider name (' . $name . ')', null, null, 'warning' );
          }
        }
        else {
          /** If the name is known, use the id from the database */
          $this->data['Building'][$type . '_provider_id'] = $provider;
        }
      }
    }
    
    /**
     * As with users, we don't want redundant products in our catalog.
     * For products, the combination of make, model & serial number
     * determines uniqueness.
     */ 
    foreach( $this->data['Product'] as $i => $product ) {
      $make       = $product['make'];
      $model      = $product['model'];
      $energy     = $product['energy_source_id'];
      
      /** If no equipment info was entered, move along. */
      if( empty( $make ) && empty( $model ) ) {
        continue;
      }
      
      $product_id = $this->Building->BuildingProduct->Product->known( $make, $model, $energy );
      
      if( !$product_id ) {
        $this->Building->BuildingProduct->Product->create();
        if( $this->Building->BuildingProduct->Product->save( $product ) ) {
          $product_id = $this->Building->BuildingProduct->Product->id;
        }
        else {
          $this->Session->setFlash( 'Unable to save product (' . $make . ' ' . $model . ')', null, null, 'warning' );
        }
      }
      
      if( $product_id ) {
        $this->data['BuildingProduct'][$i]['product_id'] = $product_id;
      }
    }
    
    if( $this->Building->saveAll( $this->data ) ) {
      $this->Session->setFlash( 'Thanks for participating.', null, null, 'success' );
      $this->redirect( array( 'action' => 'rebates', $this->Building->id ) );
    }
    else {
      $invalid_fields = $this->Building->invalidFields();
      if( !empty( $invalid_fields ) ) {
        $this->Session->setFlash( 'Oh noz. There is a problem with the questionnaire. Please correct the errors below.', null, null, 'validation' );
      }
      $this->setAction( 'questionnaire' );
    }
  }
  
  /**
   * Displays the set of rebates available for a given building.
   *
   * @param 	$building_id
   */
  public function rebates( $building_id ) {
    exit( 'Rebates for building ' . $building_id . ' will be displayed here' );
  }
}
