<?php

class BuildingsController extends AppController {
  public $name       = 'Buildings';
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );
  public $helpers    = array( 'FormatMask.Format' );
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
    
    # TODO: Move this to a component callback?
    # Squash the phone number if it exists in a data array to prep for save
    if( !empty( $this->data[$this->Building->Client->alias]['phone_number'] ) && is_array( $this->data[$this->Building->Client->alias]['phone_number'] ) ) {
      $this->data[$this->Building->Client->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Building->Client->alias]['phone_number'] );
    }
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
    
    # Explode the phone number if it exists in a data array to prep for form display
    if( isset( $this->data[$this->Building->Client->alias]['phone_number'] ) && is_string( $this->data[$this->Building->Client->alias]['phone_number'] ) ) {
      $this->data[$this->Building->Client->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Building->Client->alias]['phone_number'] );
    }
  }
  
  /**
   * Displays the form to add a new location/building.
   *	
   * @access	public
   */
  public function add() {
    
  }
  
  /**
   * Displays the form to edit a new location/building.
   *	
   * @access	public
   */
  public function edit() {
    
  }
  
  /**
   * Displays the form to add/edit building characteristics.
   *
   * @access	public
   */
  public function characteristics() {
    
  }
  
  /**
   * Displays the form to add/edit building equipment.
   *
   * @access	public
   */
  public function equipment() {
    
  }
  
  /**
   * Displays the ways to save content.
   *
   * @param 	$building_id	
   * @access	public
   */
  public function ways_to_save( $building_id ) {
    
  }
  
  /**
   * Displays the survey form.
   *
   * @param 	$building_id
   * @param   $section
   * @return	type		description
   */
  public function questionnaire( $building_id = null, $anchor = null ) {
    $this->helpers[] = 'Form';
    $this->layout    = 'sidebar';

    # All of the addresses associated with a given user (sidebar display)
    $addresses = $this->Building->Client->buildings( $this->Auth->user( 'id' ) );
    
    # Show homeowners the building the were most recently associated
    # with by default. Other user types get a blank questionnaire.
    if( $this->Auth->user( 'user_type_id' ) == UserType::OWNER && empty( $building_id ) ) {
      if( !empty( $addresses ) ) {
        $building_id = $addresses[0]['Building']['id'];
      }
    }
    
    # Empty the default building_id placeholder so that later processing
    # doesn't think it's a real value.
    if( $building_id == 'new' ) {
      $building_id = null;
    }
    
    # Steps to progress through the pseudo-wizard
    $steps = array( 'general', 'demographics', 'equipment', 'characteristics', 'envelope' );
    
    # Set the default anchor based on parameters
    if( empty( $building_id ) ) {
      $anchor = 'general';
    }
    else if( empty( $anchor ) ) {
      $anchor = 'demographics';
    }
    
    # If the authenticated user can't see this building, throw them out
    if( !empty( $building_id ) && !$this->Building->belongs_to( $building_id, $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( 'You\'re not authorized to view that building\'s data.', null, null, 'warning' );
      $this->redirect( array( 'action' => 'questionnaire' ), null, true );
    }
    
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
            'Client' => array(
              'UserType',
              'fields' => array( 'Client.id', 'Client.user_type_id', 'Client.first_name', 'Client.last_name', 'Client.full_name', 'Client.email', 'Client.phone_number' )
            ),
            'ElectricityProvider',
            'GasProvider',
            'Inspector' => array( 'fields' => array( 'Inspector.id', 'Inspector.user_type_id', 'Inspector.first_name', 'Inspector.last_name', 'Inspector.full_name', 'Inspector.email', 'Inspector.phone_number' ) ),
            'Occupant',
            'Realtor' => array( 'fields' => array( 'Realtor.id', 'Realtor.user_type_id', 'Realtor.first_name', 'Realtor.last_name', 'Realtor.full_name', 'Realtor.email', 'Realtor.phone_number' ) ),
            'WaterProvider',
          ),
          'conditions' => array( 'Building.id' => $building_id ),
        )
      );
      
      # Use the utility provider data to populate key values and kill it.
      foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility_type ) {
        if( !empty( $building['Building'][strtolower( $utility_type ) . '_provider_id'] ) ) {
          $building['Building'][strtolower( $utility_type ) . '_provider_name'] = $building[$utility_type . 'Provider']['name'];
        }
        
        unset( $building[$utility_type . 'Provider'] );
      }
      
      # Whoops, no record of that building
      if( empty( $building ) ) {
        $this->Session->setFlash( 'We were unable to find your building.', null, null, 'warning' );
        $this->redirect( array( 'action' => $this->action ), null, true );
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
      if( !empty( $building_id ) && !$this->Building->belongs_to( $building_id, $this->Auth->user( 'id' ) ) ) {
        $this->Session->setFlash( 'You\'re not authorized to modify this property.', null, null, 'warning' );
        $this->redirect( array( 'action' => $this->action ), null, true );
      }
      
      $success = true;
      
      # Handle utility provider data
      foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility_type ) {
        $success = $this->save_utility_provider( $building_id, $utility_type ) && $success;
      }
      
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
          $success = $this->{$method}( $building_id ) && $success;
        }
        else {
          # No update method exists for whatever reason. That's cool.
          $success = true && $success;
        }
      }
      
      # Save anything that's left. This updates the building record in
      # the process, but we can live with that.
      # Note that we're validating first to ensure that we don't end up
      # with unexpected data.
      if( $this->Building->saveAll( $this->data, array( 'validate' => 'only' ) ) && $success ) {
        $this->Building->saveAll( $this->data, array( 'validate' => false ) );
        $building_id = $this->Building->id;
        
        if( empty( $anchor ) ) { # Assume we just finished the first step
          $current = array( 'action' => $this->action, $building_id, $steps[0] );
          $next    = array( 'action' => $this->action, $building_id, $steps[1] );
        }
        else if( $anchor == end( $steps ) ) { # Just finished the last step
          $current = array( 'action' => $this->action, $building_id, end( $steps ) );
          $next    = array( 'action' => 'incentives', $building_id );
        }
        else {
          $current = array_search( $anchor, $steps );
          $next    = array( 'action' => $this->action, $building_id, $steps[$current + 1] );
          $current = array( 'action' => $this->action, $building_id, $steps[$current] );
        }
        
        $this->Session->setFlash( 'Your property data has been saved.', null, null, 'success' );
        
        if( $this->data['Wizard']['continue'] ) {
          $this->redirect( $next, null, true );
        }
        else {
          $this->redirect( $current, null, true );
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
    
    # Pre-populate the current user data in the proper association
    if( empty( $this->data ) && !User::admin( $this->Auth->user( 'id' ) ) ) {
      if( User::client( $this->Auth->user( 'id' ) ) ) {
        $this->data['Client'] = $this->Session->read( 'Auth.User' );
      }
      else {
        $this->data[UserType::name( $this->Auth->user( 'user_type_id' ) )] = $this->Session->read( 'Auth.User' );
      }
    }
    
    # Set a default building_id as a place holder
    $building_id = empty( $building_id ) ? 'new' : $building_id;
    
    /** Prepare the view */
    $middle_steps = array_slice( $steps, 1, count( $steps ) - 2 );
    $show_rebate_link = in_array( $anchor, $middle_steps );
    $this->populate_lookups();
    $this->set( compact( 'addresses', 'anchor', 'building_id', 'is_client', 'show_rebate_link' ) );
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
      $this->redirect( array( 'action' => 'questionnaire' ), null, true );
    }
    
    # If no building is specified, use the most recent for the user
    $building_id = !empty( $building_id ) ? $building_id : $addresses[0]['Building']['id'];
    
    # Verify that the user can access the requested building
    if( !$this->Building->belongs_to( $building_id, $this->Auth->user( 'id' ) ) ) {
      $this->Session->setFlash( 'You\'re not authorized to view that building\'s data. You\'ve been redirected to your most recently created property.', null, null, 'warning' );
      $this->redirect( array( 'action' => 'incentives', $addresses[0]['Building']['id'], $technology_group_slug ), null, true );
    }
    
    $building = $this->Building->find(
      'first',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
          'Client' => array( 'UserType' ),
          'Inspector',
          'Realtor',
        ),
        'conditions' => array( 'Building.id' => $building_id ),
      )
    );
    
    # Something bad happened.
    if( empty( $building ) ) {
      $this->Session->setFlash( 'We\'re sorry, but we couldn\'t find a structure to show incentives for.', null, null, 'warning' );
      $this->redirect( array( 'action' => 'questionnaire' ), null, true );
    }
    
    $incentives = $this->Building->incentives( $building_id );
    # Count the incentives before grouping them
    $incentive_count = count( $incentives );
    # Group the incentives by technology group for display
    $incentives = Set::combine( $incentives, '{n}.TechnologyIncentive.id', '{n}', '{n}.TechnologyGroup.title' );
    
    # Pull a random helpful hint
    $tip = ClassRegistry::init( 'Tip' )->active(
      'first',
      array(
        'fields' => array( 'Tip.text' ),
        'order'  => 'RAND()',
      )
    );
    
    $this->set( compact( 'building', 'addresses', 'incentive_count', 'incentives', 'technology_group_slug', 'tip' ) );
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
        $this->data[$role]['invite_code'] = User::generate_invite_code();
        $this->Building->{$role}->saveField( 'invite_code', $this->data[$role]['invite_code'] );
        
        # Temporary property used in this::send_invite()
        $this->data[$role]['role']      = $role;
        $this->data[$role]['full_name'] = $this->data[$role]['first_name'] . ' ' . $this->data[$role]['last_name'];
        
        # Set the building's foreign key
        $this->data['Building'][$foreign_key] = $user;
        
        # Send new user invite
        $this->send_invite( array( $this->data[$role] ) );
      }
      else {
        $this->Building->invalidate( $role . '_id' );
      }
    }
    
    # Don't make the mistake of uncommenting this. It will prevent the
    # user data from pre-populating in the event of a validation error.
    # unset( $this->data[$role] );
    
    return $user;
  }
  
  /**
   * Saves a utility provider
   *
   * @param 	$building_id
   * @param   $type         Electricity | Gas | Water
   * @return	boolean
   * @access	private
   */
  private function save_utility_provider( $building_id, $type ) {
    $code = ZipCodeUtility::$type_code_reverse_lookup[$type];
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
        }
      }
      else {
        # If the name is known, use the id from the database
        $this->data['Building'][$type . '_provider_id'] = $provider;
      }
    }
    
    return true;
  }

  /**
   * Saves a product record and the associated building-product record.
   *
   * @param 	$building_id
   * @return  boolean
   * @access  private
   */
  private function save_product( $building_id ) {
    $validates = true;
    
    foreach( $this->data['Product'] as $i => $product ) {
      $make       = $product['make'];
      $model      = $product['model'];
      $energy     = isset( $product['energy_source_id'] ) ? $product['energy_source_id'] : null;
      
      # If no product was specified, ignore everything
      if( empty( $product['technology_id'] ) || empty( $make ) || empty( $model ) || empty( $energy ) ) {
        # TODO: Maybe pull the tech name and display a warning if the tech_id was entered?
        unset( $this->data['Product'][$i] );
        unset( $this->data['BuildingProduct'][$i] );
        continue;
      }
       
      /**
       * Determine whether this product already exists in our catalog.
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
          # Try to clean up the purchase price value, if it exists
          if( !empty( $this->data['BuildingProduct'][$i]['purchase_price'] ) ) {
            $price = $this->data['BuildingProduct'][$i]['purchase_price'];
            $this->data['BuildingProduct'][$i]['purchase_price'] = money_format( '%.2i', $price );
          }
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
      
      # Use redirected email addresses, if warranted
      $to_email = Configure::read( 'email.redirect_all_email_to' )
        ? Configure::read( 'email.redirect_all_email_to' )
        : $invitee['email'];
      $cc_email = Configure::read( 'email.redirect_all_email_to' )
        ? Configure::read( 'email.redirect_all_email_to' )
        : $this->Auth->user( 'email' );
        
      # @see AppController::__construct() for common settings
      $this->SwiftMailer->sendAs   = 'both'; 
      $this->SwiftMailer->from     = Configure::read( 'email.do_not_reply_address' ); 
      $this->SwiftMailer->fromName = 'SaveBigBread.com';
      $this->SwiftMailer->to       = array( $to_email => $invitee['full_name'] );
      $this->SwiftMailer->cc       = array( $cc_email => $this->Auth->user( 'full_name' ) );
      
      //set variables to template as usual 
      $this->set( 'invite_code', $invitee['invite_code'] );
      
      try { 
        if( !$this->SwiftMailer->send( 'invite', $this->Auth->user( 'full_name' ) . ' is inviting you to save at SaveBigBread.com' ) ) {
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
    foreach( ZipCode::$type_codes as $code => $type ) {
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
