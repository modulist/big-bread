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
  public function questionnaire( $building_id = null ) {
    $this->helpers[] = 'Form';
    $this->layout    = 'sidebar';
    
    if( !empty( $building_id ) ) {
      $this->redirect( array( 'action' => 'edit', $building_id ) );
    }
    
    # All of the addresses associated with a given user (sidebar display)
    $addresses = $this->Building->Client->buildings( $this->Auth->user( 'id' ) );
    
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
    $roofInsulationLevels = $insulationLevels;
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
    $this->set( compact( 'addresses', 'buildingTypes', 'basementTypes', 'buildingShapes', 'energySources', 'exposureTypes', 'frameMaterials', 'insulationLevels', 'maintenanceLevels', 'roofInsulationLevels', 'roofSystems', 'shadingTypes', 'technologies', 'userTypes', 'wallSystems', 'windowPaneTypes' ) );
  }
  
  /**
   * Displays questionnaire information with the ability to edit
   *
   * @param 	$building_id
   * @access	public
   */
  public function edit( $building_id, $model = null ) {
    $this->helpers[] = 'Form';
    $this->layout    = 'sidebar';
    
    # All of the addresses associated with a given user (sidebar display)
    $addresses = $this->Building->Client->buildings( $this->Auth->user( 'id' ) );
    
    # Looks like we're updating something
    if( !empty( $model ) ) {
      $model    = Inflector::classify( $model ); // normalize the model name
      $redirect = false;
      
      // Save associated model data
      if( !empty( $this->data[$model] ) && method_exists( $this, 'update_' . strtolower( $model ) ) ) {
        if( $this->{'update_' . strtolower( $model )}( $building_id ) ) {
          $redirect = true;
        }
      }
      
      // We have to edit actual building properties too...
      if( !empty( $this->data['Building'] ) ) {
        $this->Building->id = $building_id;
        
        if( $this->Building->save( $this->data ) ) {
          $redirect = $redirect && true;
        }
      }
      
      if( $redirect ) {
        $this->redirect( array( 'action' => 'edit', $building_id ) );
      }
    }
    
    if( !empty( $building_id ) ) {
      $this->data = $this->Building->find(
        'first',
        array(
          'contain' => array(
            'Address' => array( 'ZipCode' ),
            'BuildingProduct' => array(
              'Product' => array(
                'EnergySource',
                'Technology' => array( 'EnergySource' => array( 'fields' => array( 'incentive_tech_energy_type_id', 'name' ) ) )
              ),
            ),
            'BuildingRoofSystem',
            'BuildingWallSystem',
            'BuildingWindowSystem',
            'Client',
            'Inspector',
            'Occupant',
            'Realtor',
          ),
          'conditions' => array( 'Building.id' => $building_id ),
        )
      );
      
      if( empty( $this->data ) ) {
        $this->Session->setFlash( 'We were unable to find that building.', null, null, 'warning' );
      }
    }
    
    # Lookups
    $technologies = $this->Building->BuildingProduct->Product->Technology->find(
      'list',
      array(
        'conditions' => array( 'Technology.questionnaire_product' => 1 ),
        'order' => array( 'Technology.name' ),
      )
    );
    
    $this->set( 'building', $this->data );
    
    $this->set( compact( 'addresses', 'technologies' ) );
  }
  
  /**
   * Creates a building record (and associated records) from the
   * questionnaire form.
   *
   * @see $this::questionnaire()
   */
  public function create() {
    if( empty( $this->data ) ) {
      $this->redirect( '/questionnaire' );
    }
    
    $roles   = array( 'Realtor', 'Inspector', 'Client' );
    $invites = array();
    foreach( $roles as $role ) {
      # Realtor and Inspector are optional. If key fields are empty, Move along.
      if( $role != 'Client' && empty( $this->data[$role]['email'] ) ) {
        unset( $this->data[$role] );
        continue;
      }
      
      $user = !empty( $this->data[$role]['email'] )
        ? $this->Building->{$role}->known( $this->data[$role]['email'] )
        : false;
      
      if( $user ) { # This user is already in the system
        $this->data['Building'][strtolower( $role ) . '_id'] = $user;
        unset( $this->data[$role] );
      }
      else { # We don't know this user, create an invite code & save
        $this->data[$role]['invite_code'] = md5( String::uuid() );
        $this->Building->{$role}->save( $this->data[$role] );
        $this->data['Building'][strtolower( $role ) . '_id'] = $this->Building->{$role}->id;
        $this->data[$role]['role'] = $role;
        array_push( $invites, $this->data[$role] );
        unset($this->data[$role] );
      }
    }
    
    $this->data = $this->prep_utility_data( $this->data );
    $this->data = $this->prep_product_data( $this->data );
    $this->data = $this->prep_roof_data( $this->data );
    
    if( $this->Building->saveAll( $this->data ) ) {
      $this->Session->setFlash( 'Thanks for participating.', null, null, 'success' );
      
      # Send new user invites
      $this->send_invite( $invites );
      
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

    $this->set( compact( 'building', 'addresses', 'incentive_count', 'incentives' ) );
  }
  
  /**
   * Downloads the questionnaire PDF.
   */
  public function download_questionnaire() {
    $this->view = 'Media';
    $params     = array(
      'id'        => 'questionnaire.pdf',
      'name'      => 'questionnaire',
      'download'  => true,
      'extension' => 'pdf',  // must be lower case
      'path'      => 'files' . DS   // don't forget terminal 'DS'
   );
    
   $this->set( $params );
  }
  
  /**
   * PRIVATE METHODS
   */
  
  /**
   * Updates realtor information
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function update_realtor( $building_id ) {
    return $this->update_user( $building_id, 'realtor' );
  }
  
  /**
   * Updates inspector information
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function update_inspector( $building_id ) {
    return $this->update_user( $building_id, 'inspector' );
  }
  
  /**
   * Updates associated user data.
   *
   * @param 	$role
   * @return	boolean
   * @access	private
   */
  private function update_user( $building_id, $role ) {
    $model = Inflector::classify( $role );
    
    $this->Building->id = $building_id; // Ultimately, we're here to update the building data
    
    $user = !empty( $this->data[$model]['email'] )
        ? $this->Building->{$model}->known( $this->data[$model]['email'] )
        : false;
      
    if( !$user ) { # We don't know this user.
      $this->data[$model]['invite_code'] = md5( String::uuid() );
      
      if( $this->Building->{$model}->save( $this->data ) ) {
        $user = $this->Building->{$model}->id;
        $this->send_invite( array( $this->data[$model] ) );
      }
      else {
        $this->Session->setFlash( 'We weren\'t able to make that change.', null, null, 'validation' );
        
        return false;
      }
    }
    
    # Update the building property if we have a user at this point.
    if( $user ) {
      $this->Building->saveField( $role . '_id', $user );
      $this->Session->setFlash( 'The building\'s ' . $role . ' has been updated.', null, null, 'success' );
      
      return true;
    }
    
    return false;
  }
  
  /**
   * Updates associated occupancy data
   *
   * @param 	$building_id
   * @return  boolean
   * @access	private
   */
  private function update_occupant( $building_id ) {
    if( !empty( $this->data['Occupant']['id'] ) ) {
      $this->Building->Occupant->id = $this->data['Occupant']['id'];
      
      if( $this->Building->Occupant->save( $this->data ) ) {
        return true;
      }
    }
    
    return false;
  }
  
  /**
   * Updates building technologies
   *
   * @param 	$building_id
   * @access	private
   */
  private function update_product( $building_id ) {
    # In an edit scenario, we'll have an indexed array of products, although
    # there will always be only one. If a property (make) cannot be accessed
    # directly, it's probably indexed so we need to normalize.
    if( !isset( $this->data['Product']['make'] ) ) {
      $this->data['Product']         = array_shift( $this->data['Product'] );
      $this->data['BuildingProduct'] = array_shift( $this->data['BuildingProduct'] );
    }
    
    $this->Building->BuildingProduct->id = $this->data['BuildingProduct']['id'];
    
    $make   = $this->data['Product']['make'];
    $model  = $this->data['Product']['model'];
    $energy = isset( $this->data['Product']['energy_source_id'] ) ? $this->data['Product']['energy_source_id'] : null;
    
    $product_id = $this->Building->Product->known( $make, $model, $energy );
    
    if( !$product_id ) {
      if( $this->Building->Product->save( $this->data ) ) {
        $this->log( 'Product saved successfully', LOG_DEBUG );
        $product_id = $this->Building->Product->id;
      }
    }
    
    if( $product_id ) {
      $this->data['BuildingProduct']['product_id']  = $product_id;
      $this->data['BuildingProduct']['building_id'] = $building_id;
      
      if( $this->Building->BuildingProduct->save( $this->data ) ) {
        return true;
      }
    }
    
    $this->log( 'Zoiks! Returning false', LOG_DEBUG );
    
    return false;
  }
  
  /**
   * Sends an invitation email
   *
   * @param 	$to     An INDEXED array of invited users
   * @access	public
   */
  private function send_invite( $to ) {
    foreach( $to as $invitee ) {
      $this->log( '{BuildingsController::create} Sending invite to ' . $invitee['email'] . '. Code: ' . $invitee['invite_code'], LOG_DEBUG );
      /** 
      $this->SwiftMailer->smtpType = 'tls'; 
      $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
      $this->SwiftMailer->smtpPort = 465; 
      $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
      $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
      */
      $this->SwiftMailer->sendAs   = 'both'; 
      $this->SwiftMailer->from     = 'DO-NOT-REPLY@bigbread.net'; 
      $this->SwiftMailer->fromName = 'BigBread.net';
      $this->SwiftMailer->to       = $invitee['email'];
      
      //set variables to template as usual 
      $this->set( 'invite_code', $invitee['invite_code'] ); 
       
      try { 
        if( !$this->SwiftMailer->send( 'invite', 'You\'ve been invited to save', 'native' ) ) {
          foreach($this->SwiftMailer->postErrors as $failed_send_to) { 
            $this->log( 'Failed to send invitation email to ' . $failed_send_to . ' (' . $invitee['role'] . ')' ); 
          }
        } 
      } 
      catch( Exception $e ) { 
        $this->log( 'Failed to send email: ' . $e->getMessage() ); 
      } 
    }
  }
  
  /**
   * 
   *
   * @param 	$data
   */
  private function prep_utility_data( $data ) {
    /** Handle utility providers if an unknown was specified */
    /** TODO: Can we move this down the stack somewhere? */
    foreach( $this->Building->Address->ZipCode->ZipCodeUtility->type_codes as $code => $type ) {
      $type = strtolower( $type );
      $name = $data['Building'][$type . '_provider_name'];
      
      # Empty the utility id if the name is empty
      $data['Building'][$type . '_provider_id'] = !empty( $name )
        ? $data['Building'][$type . '_provider_id']
        : null;
      
      $id = $data['Building'][$type . '_provider_id'];
      
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
                'conditions' => array( 'ZipCode.zip' => $data['Address']['zip_code'] ),
              )
            );
          }
          
          # Build and save a Utility record and a ZipCodeUtility record
          $data['Utility'] = array(
            'name'     => $name,
            'source'   => 'User',
            'reviewed' => 0,
          );
          $data['ZipCodeUtility'] = array(
            'zip'      => $data['Address']['zip_code'],
            'state'    => $state['ZipCode']['state'],
            'coverage' => 0,
            'source'   => 'User',
            'reviewed' => 0,
            'type'     => $code
          );
         
          if( $this->Building->Address->ZipCode->ZipCodeUtility->Utility->save( $data['Utility'] ) ) {
            $data['ZipCodeUtility']['utility_id'] = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->id;
            
            if( $this->Building->Address->ZipCode->ZipCodeUtility->save( $data['ZipCodeUtility'] ) ) {
              # At this point, we should have a provider id for the new record.
              $data['Building'][$type . '_provider_id'] = $this->Building->Address->ZipCode->ZipCodeUtility->Utility->id;
            }
            else {
              # TODO: Do we want to do something else here?
              $this->Session->setFlash( 'Unable to attach the specified ' . strtolower( $type ) . ' provider (' . $name . ') to the ' . $data['Address']['zip_code'] . ' zip code.', null, null, 'warning' );
              
              # new PHPDump( $this->Building->Address->ZipCode->ZipCodeUtility->invalidFields(), 'Utility-Zip Errors' ); exit;
            }
          }
          else {
            # TODO: Do we want to do something else here?
            $this->Session->setFlash( 'Unable to save ' . strtolower( $type ) . ' provider name (' . $name . ')', null, null, 'warning' );
            
            # new PHPDump( $this->Building->Address->ZipCode->ZipCodeUtility->Utility->invalidFields(), 'Utility Errors' );
            # new PHPDump( $data, 'Data' ); exit;
          }
        }
        else {
          # If the name is known, use the id from the database
          $data['Building'][$type . '_provider_id'] = $provider;
        }
      }
    }
    
    return $data;
  }
  
  /**
   * description
   *
   * @param 	$data
   */
  private function prep_product_data( $data ) {
  
    /**
     * As with users, we don't want redundant products in our catalog.
     * For products, the combination of make, model & serial number
     * determines uniqueness.
     */
    foreach( $data['Product'] as $i => $product ) {
      $make       = $product['make'];
      $model      = $product['model'];
      $energy     = isset( $product['energy_source_id'] ) ? $product['energy_source_id'] : null;
      
      # Ensure that the product is valid. If not, kill it.
      if( empty( $product['technology_id'] ) || empty( $make ) || empty( $model ) || empty( $energy ) ) {
        # TODO: Maybe pull the tech name and display a warning if the tech_id was entered?
        unset( $data['Product'][$i] );
        unset( $data['BuildingProduct'][$i] );
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
        $data['BuildingProduct'][$i]['product_id'] = $product_id;
      }
    }
    
    # Clear the product structures if empty.
    if( empty( $data['Product'] ) ) {
      unset( $data['Product'] );
    }
    if( empty( $data['BuildingProduct'] ) ) {
      unset( $data['BuildingProduct'] );
    }
    
    return $data;
  }
  
  /**
   * 
   *
   * @param 	$data
   */
  private function prep_roof_data( $data ) {
    foreach( $data['BuildingRoofSystem'] as $i => $roof_system ) {
      if( !$roof_system['roof_system_id'] ) {
        unset( $data['BuildingRoofSystem'][$i] );
      }
    }
    
    if( empty( $data['BuildingRoofSystem'] ) ) {
      unset( $data['BuildingRoofSystem'] );
    }
    
    return $data;
  }
}
