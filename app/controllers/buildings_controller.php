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
    
    $anchor = empty( $this->data['Building']['anchor'] ) ? 'general' : $this->data['Building']['anchor'];
    
    # Steps to progress through the pseudo-wizard
    $steps = array( 'general', 'demographics', 'equipment', 'characteristics', 'envelope' );
    
    # Pull the existing record to pre-populate data, if available
    $building = array();
    if( !empty( $building_id ) ) {
      $building = $this->Building->find(
        'first',
        array(
          'contain' => array(
            'Address' => array( 'ZipCode' ),
            'BuildingProduct' => array(
              'conditions' => array( 'BuildingProduct.service_out' => null ),
              'Product' => array(
                'EnergySource',
                'Technology' => array( 'EnergySource' => array( 'fields' => array( 'incentive_tech_energy_type_id', 'name' ) ) )
              ),
            ),
            'BuildingRoofSystem',
            'BuildingWallSystem',
            'BuildingWindowSystem',
            'Client' => array( 'fields' => array( 'Client.id', 'Client.user_type_id', 'Client.first_name', 'Client.last_name', 'Client.full_name', 'Client.email', 'Client.phone_number' ) ),
            'Inspector' => array( 'fields' => array( 'Inspector.id', 'Inspector.user_type_id', 'Inspector.first_name', 'Inspector.last_name', 'Inspector.full_name', 'Inspector.email', 'Inspector.phone_number' ) ),
            'Occupant',
            'Realtor' => array( 'fields' => array( 'Realtor.id', 'Realtor.user_type_id', 'Realtor.first_name', 'Realtor.last_name', 'Realtor.full_name', 'Realtor.email', 'Realtor.phone_number' ) ),
          ),
          'conditions' => array( 'Building.id' => $building_id ),
        )
      );
      
      # Whoops, no record of that building
      if( empty( $building ) ) {
        $this->Session->setFlash( 'We were unable to find your building.', null, null, 'warning' );
        $this->redirect( array( 'action' => $this->action ) );
      }
    }
    
    # Process incoming data
    if( !empty( $this->data ) ) {
      $this->Building->id = $building_id;
      
      # Merge existing data with incoming to avoid validation errors
      # and other such fun. Incoming data overrides existing.
      $this->data = Set::merge( $building, $this->data );
      
      # Ensure that the current user is associated with the building they
      # may be trying to update.
      if( !empty( $building_id ) && !$this->Building->belongs_to( $building_id ) ) {
        $this->Session->setFlash( 'You\'re not authorized to modify this property.', null, null, 'warning' );
        $this->redirect( array( 'action' => $this->action ) );
      }
      
      $success = true;
      
      # Handle associated models that must be saved before the building
      # or that require some pre-processing
      foreach( $this->data as $model => $data ) {
        # Ignore the "User" model that's passed by default. The User model
        # data we care about here is all aliased (Client, Realtor, Inspector).
        if( in_array( $model, array( 'User' ) ) ) {
          continue;
        }
        
        $method = 'save_' . Inflector::underscore( $model );
        if( method_exists( $this, $method ) ) {
          $success = $success && $this->{$method}( $building_id );
        }
        else {
          # No update method exists for whatever reason. That's cool.
          $success = $success && true;
        }
      }

      # Save anything that's left. This updates the building record in
      # the process, but we can live with that.
      if( $this->Building->saveAll( $this->data ) ) {
        $building_id = $this->Building->id;
        
        if( empty( $anchor ) ) { # Assume we just finished the first step
          $current = array( 'action' => $this->action, $building_id, '#' => $steps[0] );
          $next    = array( 'action' => $this->action, $building_id, '#' => $steps[1] );
        }
        else if( $anchor == end( $steps ) ) { # Just finished the last step
          $current = array( 'action' => $this->action, $building_id, '#' => end( $steps ) );
          $next    = array( 'action' => 'incentives', $building_id );
        }
        else {
          $current = array_search( $anchor, $steps );
          $next    = array( 'action' => $this->action, $building_id, '#' => $steps[$current + 1] );
          $current = array( 'action' => $this->action, $building_id, '#' => $steps[$current] );
        }
        
        $this->Session->setFlash( 'Your property data has been saved.', null, null, 'success' );
        
        if( $this->data['Building']['continue'] ) {
          $this->redirect( $next );
        }
        else {
          $this->redirect( $current );
        }
      }
      else {
        $this->log( '{BuildingsController::questionnaire} Error saving building data: ' . json_encode( $this->Building->validationErrors ), LOG_ERR );
        $this->Session->setFlash( 'There is a problem with the data you provided. Please correct the errors below.', null, null, 'validation' );
      }
    }
    else {
      # No incoming data. Just set the data array so that form inputs
      # can be pre-populated.
      $this->data = $building;
    }
    
    # All of the addresses associated with a given user (sidebar display)
    $addresses = $this->Building->Client->buildings( $this->Auth->user( 'id' ) );
    
    if( in_array( $this->Session->read( 'Auth.UserType.name' ), array( 'Homeowner', 'Buyer' ) ) ) {
      $this->data['Client'] = $this->Session->read( 'Auth.User' );
    }
    else {
      $this->data[$this->Session->read( 'Auth.UserType.name' )] = $this->Session->read( 'Auth.User' );
    }
    
    /** Prepare the view */
    $this->populate_lookups();
    $this->set( compact( 'addresses' ) );
  }

  /**
   * Displays the set of rebates available for a given building.
   *
   * @param 	$building_id
   * @param   $technology_group_slug
   */
  public function incentives( $building_id = null, $technology_group_slug = null ) {
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
    $incentives      = Set::combine( $incentives, '{n}.TechnologyIncentive.id', '{n}', '{n}.TechnologyGroup.title' );
    
    $this->set( compact( 'building', 'addresses', 'incentive_count', 'incentives', 'technology_group_slug' ) );
  }
  
  /**
   * Creates a new user of a given type and updates the appropriate
   * building association.
   *
   * @param   $building_id
   * @param 	$role
   * @access	public
   */
  public function change_user( $building_id, $role ) {
    $foreign_key = strtolower( $role ) . '_id';
    $user        = $this->save_user( $building_id, 'Inspector' );
    
    if( $user ) {
      $this->Building->id = $building_id;
      $this->Building->saveField( $foreign_key, $user );
    }
  }

  /**
   * Creates a new user identified as a client and associates the building
   * with the new client.
   *
   * @param   $building_id
   * @param 	$role
   * @access	public
   */
  public function change_client( $building_id ) {
    $this->change_user( $building_id, 'Client' );
  }

  /**
   * Creates a new user identified as an inspector and associates the building
   * with the new inspector.
   *
   * @param   $building_id
   * @param 	$role
   * @access	public
   */
  public function change_inspector( $building_id ) {
    $this->change_user( $building_id, 'Inspector' );
  }
  
  /**
   * Creates a new user identified as a realtor and associates the building
   * with the new inspector.
   *
   * @param   $building_id
   * @param 	$role
   * @access	public
   */
  public function change_realtor( $building_id ) {
    $this->change_user( $building_id, 'Realtor' );
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
   * Sets the variables required to populate all of the dropdowns used
   * in the questionnaire. This method returns nothing because it sets
   * the variables in the view space.
   *
   * @access	private
   */
  private function populate_lookups() {
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
    
    $this->set( compact( 'basementTypes', 'buildingShapes', 'buildingTypes', 'exposureTypes', 'frameMaterials', 'insulationLevels', 'maintenanceLevels', 'roofInsulationLevels', 'roofSystems', 'shadingTypes', 'technologies', 'userTypes', 'wallSystems', 'windowPaneTypes' ) );
  }
  
  /**
   * Saves a client record.
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function save_client( $building_id = null ) {
    return $this->save_user( $building_id, 'Client' );
  }
  
  /**
   * Saves an inspector record. An inspector is not required so if no
   * email value is passed, don't even bother to save.
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function save_inspector( $building_id = null ) {
    if( empty( $this->data['Inspector']['email'] ) ) {
      unset( $this->data['Inspector'] );
      $response = true;
    }
    else {
      $response = $this->save_user( $building_id, 'Inspector' );
    }
    
    return $response;
  }
  
  /**
   * Saves a realtor record. A realtor is not required so if no
   * email value is passed, don't even bother to save.
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function save_realtor( $building_id = null ) {
    if( empty( $this->data['Realtor']['email'] ) ) {
      unset( $this->data['Realtor'] );
      $response = true;
    }
    else {
      $response = $this->save_user( $building_id, 'Realtor' );
    }
    
    return $response;
  }
  
  /**
   * Saves a user record.
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function save_user( $building_id = null, $role ) {
    $foreign_key = strtolower( $role ) . '_id';
    
    $user = !empty( $this->data[$role]['email'] )
      ? $this->Building->{$role}->known( $this->data[$role]['email'] )
      : false;
    
    if( $user ) { # This user is already in the system
      $this->data[$role]['id']              = $user;
      $this->data['Building'][$foreign_key] = $user;
    }
    else { # We don't know this user, add him/her
      $this->Building->{$role}->create(); # We're in a loop so let's be safe, kids.
      
      if( $this->Building->{$role}->add( $this->data ) ) {
        $user                    = $this->Building->{$role}->id;
        $this->data[$role]['id'] = $user;
        
        # Generate an invite code and save it off
        $this->data[$role]['invite_code'] = md5( String::uuid() );
        $this->Building->{$role}->saveField( 'invite_code', $this->data[$role]['invite_code'] );
        
        # Temporary property used in this::send_invite()
        $this->data[$role]['role'] = $role; 
        
        # Set the building's foreign key
        $this->data['Building'][$foreign_key] = $user;
        
        # Send new user invite
        $this->send_invite( array( $this->data[$role] ) );
      }
      else {
        $this->Building->invalidate( $role . '_id' );
      }
    }
    
    return $user;
  }

  /**
   * Saves a product record and the associated building-product record.
   *
   * @param 	$building_id
   * @return  boolean
   * @access  private
   */
  private function save_product( $building_id ) {
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
        
      /**
       * As with users, we don't want redundant products in our catalog.
       * For products, the combination of make, model & serial number
       * determines uniqueness.
       */
      $product_id = $this->Building->BuildingProduct->Product->known( $make, $model, $energy );
      
      if( !$product_id ) { # This product is not in the catalog yet
        $this->Building->BuildingProduct->Product->create();
        if( $this->Building->BuildingProduct->Product->save( $product ) ) {
          $product_id = $this->Building->BuildingProduct->Product->id; 
        }
        else {
          $this->log( '{BuildingsController::save_product} Unable to save product to the catalog. ' . json_encode( $this->Building->BuildingProduct->Product->validationErrors ), LOG_ERR );
        }
      }
      
      # If we have a product, we can save off the building equipment
      if( $product_id ) {
        $this->data['BuildingProduct'][$i]['product_id']  = $product_id;
        
        if( !empty( $building_id ) ) {
          $this->data['BuildingProduct'][$i]['building_id']  = $building_id;
        } 
      }
    }
    
    # If there's nothing left, then clear it all
    if( empty( $this->data['Product'] ) ) {
      unset( $this->data['Product'] );
    }
    if( empty( $this->data['BuildingProduct'] ) ) {
      unset( $this->data['BuildingProduct'] );
    }
    
    return true;
  }

  /**
   * Updates the building roof system(s).
   *
   * @param 	$building_id
   * @return	boolean
   * @access	private
   */
  private function save_building_roof_system( $building_id ) {
    # Cull out the unselected roof systems
    foreach( $this->data['BuildingRoofSystem'] as $i => $roof_system ) {
      if( empty( $roof_system['roof_system_id'] ) ) {
        unset( $this->data['BuildingRoofSystem'][$i] );
      }
      else if( !empty( $building_id ) ) {
        $this->data['BuildingRoofSystem'][$i]['building_id'] = $building_id;
      }
    }
    
    # If there's nothing left, then clear it all
    if( empty( $this->data['BuildingRoofSystem'] ) ) {
      unset( $this->data['BuildingRoofSystem'] );
    }
    
    return true;
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
}
