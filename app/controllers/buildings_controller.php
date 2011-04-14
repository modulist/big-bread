<?php

class BuildingsController extends AppController {
  public $name = 'Buildings';
  public $components = array( 'SwiftMailer' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
    
    # $this->Auth->allow( 'questionnaire', 'create', 'rebates' );
  }

  public function beforeRender() {
    # Generate a list of tech groups for the rebate bar
    $technology_groups = $this->Building->BuildingProduct->Product->Technology->TechnologyGroup->find(
      'list',
      array(
        'conditions' => array( 'TechnologyGroup.rebate_bar' => 1 ),
        'order' => array( 'TechnologyGroup.title' ),
      )
    );
    $this->set( compact( 'technology_groups' ) );
  }
  
  /**
   * Displays the survey form.
   *
   * @param 	$arg
   * @return	type		description
   */
  public function questionnaire() {
    $this->helpers[] = 'Form';
    $this->layout    = 'sidebar';
    
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
    $frameMaterials = $this->Building->BuildingWindowSystem->FrameMaterial->find(
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
    $roofSystems = $this->Building->BuildingRoofSystem->RoofSystem->find(
      'all',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $shadingTypes = $this->Building->ShadingType->find(
      'list',
      array( 'conditions' => array( 'deleted' => 0 ), 'order' => 'name' )
    );
    $technologies = $this->Building->BuildingProduct->Product->Technology->find(
      'list',
      array(
        'conditions' => array( 'Technology.questionnaire_product' => 1 ),
        'order' => array( 'Technology.name' ),
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
    
    if( in_array( $this->Session->read( 'Auth.UserType.name' ), array( 'Homeowner', 'Buyer' ) ) ) {
      $this->data['Client'] = $this->Session->read( 'Auth.User' );
    }
    else {
      $this->data[$this->Session->read( 'Auth.UserType.name' )] = $this->Session->read( 'Auth.User' );
    }
    
    /** 
    $this->Building->Realtor->validate['first_name']['notempty']['required'] = false;
    $this->Building->Realtor->validate['last_name']['notempty']['required'] = false;
    $this->Building->Realtor->validate['email']['notempty']['required'] = false;
    # debug( $this->Building->Realtor->validate );
    */
    
    /** Prepare the view */
    $this->set( compact( 'buildingTypes', 'basementTypes', 'buildingShapes', 'energySources', 'exposureTypes', 'frameMaterials', 'insulationLevels', 'maintenanceLevels', 'roofSystems', 'shadingTypes', 'technologies', 'userTypes', 'wallSystems', 'windowPaneTypes' ) );
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
    $roles = array( 'Realtor', 'Inspector', 'Client' );
    foreach( $roles as $role ) {
      # Realtor and Inspector are optional. If key fields are empty, Move along.
      if( $role != 'Client' ) {
        if( empty( $this->data[$role]['first_name'] ) && empty( $this->data[$role]['last_name'] ) && empty( $this->data[$role]['email'] ) ) {
          unset( $this->data[$role] );
          continue;
        }
      }
      
      $user = !empty( $this->data[$role]['email'] )
        ? $this->Building->{$role}->known( $this->data[$role]['email'] )
        : false;
      
      if( $user ) { # This user is already in the system
        $this->data['Building'][strtolower( $role ) . '_id'] = $user;
        unset( $this->data[$role] );
      }
      else { # We don't know this user, create an invite code
        $this->data[$role]['invite_code'] = md5( String::uuid() );
      }
    }
    /** END : user detection */
  
    /** Handle utility providers if an unknown was specified */
    /** TODO: Can we move this down the stack somewhere? */
    foreach( $this->Building->Address->ZipCode->ZipCodeUtility->type_codes as $code => $type ) {
      $type = strtolower( $type );
      $name = $this->data['Building'][$type . '_provider_name'];
      
      # Empty the utility id if the name is empty
      $this->data['Building'][$type . '_provider_id'] = !empty( $name )
        ? $this->data['Building'][$type . '_provider_id']
        : null;
      
      $id = $this->data['Building'][$type . '_provider_id'];
      
      if( !empty( $name ) ) {
        $provider = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->known( $name, $id );
        
        if( !$provider ) { # The specified provider is not recognized
          # Pull the state code for the building zip code
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
          
          # Build and save a Utility record and a ZipCodeUtility record
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
            
            if( $this->Building->Address->ZipCode->ZipCodeUtility->save( $this->data['ZipCodeUtility'] ) ) {
              # At this point, we should have a provider id for the new record.
              $this->data['Building'][$type . '_provider_id'] = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->id;
            }
            else {
              # TODO: Do we want to do something else here?
              $this->Session->setFlash( 'Unable to attach the specified ' . strtolower( $type ) . ' provider (' . $name . ') to the ' . $this->data['Address']['zip_code'] . ' zip code.', null, null, 'warning' );
              
              new PHPDump( $this->Building->Address->ZipCode->ZipCodeUtility->invalidFields(), 'Utility-Zip Errors' ); exit;
            }
          }
          else {
            # TODO: Do we want to do something else here?
            $this->Session->setFlash( 'Unable to save ' . strtolower( $type ) . ' provider name (' . $name . ')', null, null, 'warning' );
            
            new PHPDump( $this->Building->Address->ZipCode->ZipCodeUtility->Utility->invalidFields(), 'Utility Errors' );
            new PHPDump( $this->data, 'Data' ); exit;
          }
        }
        else {
          # If the name is known, use the id from the database
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
      $energy     = isset( $product['energy_source_id'] ) ? $product['energy_source_id'] : null;
      
      # Ensure that the product is valid. If not, kill it.
      if( empty( $product['technology_id'] ) || empty( $make ) || empty( $model ) || empty( $energy ) ) {
        # TODO: Maybe pull the tech name and display a warning if the tech_id was entered?
        unset( $this->data['Product'][$i] );
        unset( $this->data['BuildingProduct'][$i] );
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
    
    # Clear the product structures if empty.
    if( empty( $this->data['Product'] ) ) {
      unset( $this->data['Product'] );
    }
    if( empty( $this->data['BuildingProduct'] ) ) {
      unset( $this->data['BuildingProduct'] );
    }
    
    if( $this->Building->saveAll( $this->data ) ) {
      $this->Session->setFlash( 'Thanks for participating.', null, null, 'success' );
      
      # Send new user invites
      foreach( $roles as $role ) {
        if( isset( $this->data[$role]['invite_code'] ) ) {
          if( Configure::read( 'debug' ) > 0 ) $this->log( '{BuildingsController::crete} Sending invite to a ' . $role . ' (' . $this->data[$role]['email'] . '). Code: ' . $this->data[$role]['invite_code'], LOG_DEBUG );
          /** 
          $this->SwiftMailer->smtpType = 'tls'; 
          $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
          $this->SwiftMailer->smtpPort = 465; 
          $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
          $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
          */
          $this->SwiftMailer->sendAs = 'both'; 
          $this->SwiftMailer->from = 'rob@robwilkerson.org'; 
          $this->SwiftMailer->fromName = 'BigBread.net';
          # TODO: Change To address
          $this->SwiftMailer->to = 'rob@robwilkerson.org';
          
          //set variables to template as usual 
          $this->set( 'invite_code', $this->data[$role]['invite_code'] ); 
           
          try { 
            if( !$this->SwiftMailer->send( 'invite', 'You\'ve been invited to save', 'native' ) ) { 
              $this->log( 'Error sending email' ); 
            } 
          } 
          catch( Exception $e ) { 
            $this->log( 'Failed to send email: ' . $e->getMessage() ); 
          } 
        }
      }
      
      $this->redirect( array( 'action' => 'incentives', $this->Building->id ) );
    }
    else {
      $invalid_fields = $this->Building->invalidFields();
      if( !empty( $invalid_fields ) ) {
        $this->Session->setFlash( 'There is a problem with the data you provided. Please correct the errors below.', null, null, 'validation' );
      }
      $this->setAction( 'questionnaire' );
    }
  }
  
  /**
   * Displays the set of rebates available for a given building.
   *
   * @param 	$building_id
   */
  public function incentives( $building_id = null ) {
    $this->layout = 'sidebar';
    
    # All of the addresses associated with a given user (sidebar display)
    $addresses = $this->Building->Client->buildings( $this->Auth->user( 'id' ) );
    
    # This user is not associated with any buildings
    if( empty( $addresses ) ) {
      $this->Session->setFlash( 'We can\'t help you save unless you fill out the questionnaire.', null, null, 'warning' );
      $this->redirect( Router::url( '/questionnaire' ) );
    }
    
    # If no building is specified, use the most recent for the user
    $building_id = !empty( $building_id ) ? $building_id : $addresses[0]['Building']['id'];
    
    $building = $this->Building->find(
      'first',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
          'Client',
          'Inspector',
          'Realtor',
        ),
        'conditions' => array( 'Building.id' => $building_id ),
      )
    );
    
    # Something bad happened.
    if( empty( $building ) ) {
      $this->Session->setFlash( 'We\'re sorry, but we couldn\'t find a structure to show incentives for.', null, null, 'warning' );
      $this->redirect( Router::url( '/questionnaire' ) );
    }
    
    $incentives      = $this->Building->incentives( $building_id );
    # Count the incentives before grouping them
    $incentive_count = count( $incentives );
    # Group the incentives by technology group for display
    $incentives      = Set::combine( $incentives, '{n}.TechnologyIncentive.id', '{n}', '{n}.TechnologyGroup.title');

    $this->set( compact( 'building', 'buildings', 'incentive_count', 'incentives' ) );
  }
}
