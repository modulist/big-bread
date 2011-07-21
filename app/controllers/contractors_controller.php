<?php

class ContractorsController extends AppController {
  public $name       = 'Contractors';
  public $helpers    = array( 'Form', 'FormatMask.Format' );
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );

  /**
   * CALLBACKS
   */

  public function beforeFilter() {
    parent::beforeFilter();
    
    if( !Configure::read( 'Feature.contractor_registration.enabled' ) ) {
      $this->cakeError( 'error404' );
    }
    
    $this->Auth->allow( 'index' );
    
    # Squash the phone number if it exists in a data array to prep for save
    if( !empty( $this->data[$this->Contractor->User->alias]['phone_number'] ) && is_array( $this->data[$this->Contractor->User->alias]['phone_number'] ) ) {
      $this->data[$this->Contractor->User->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Contractor->User->alias]['phone_number'] );
    }
  }
  
  public function beforeRender() {
    parent::beforeRender();
    
    # Explode the phone number if it exists in a data array to prep for form display
    if( isset( $this->data[$this->Contractor->User->alias]['phone_number'] ) && is_string( $this->data[$this->Contractor->User->alias]['phone_number'] ) ) {
      $this->data[$this->Contractor->User->alias]['phone_number'] = $this->Format->phone_number( $this->data[$this->Contractor->User->alias]['phone_number'] );
    }
  }

  /**
   * PUBLIC METHODS
   */
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param   $user_id
   * @access  public
   */
  public function index( $contractor_id = null ) {
    $this->Contractor->id = $contractor_id;
    
    if( !empty( $this->data ) ) {
      # When editing, we need to do a little data prep
      if( !empty( $contractor_id ) ) {
        # Make sure the data represents an edit action
        $this->data['Contractor']['id']     = $contractor_id;
        $this->data['User']['id']           = $this->Contractor->field( 'Contractor.user_id', array( 'Contractor.id' => $contractor_id ) );
        $this->data['BillingAddress']['id'] = $this->Contractor->field( 'Contractor.billing_address_id', array( 'Contractor.id' => $contractor_id ) );
        
        # If no password value is passed, assume no change should be made
        # and remove the empty data to avoid validation errors.
        if( empty( $this->data['User']['password'] ) ) {
          unset( $this->data['User']['password'] );
          unset( $this->data['User']['confirm_password'] );
        }
      }
      
      # The password value is hashed automagically. We need to hash the
      # confirmation value manually for validation.
      # @see User::identical()     
      if( isset( $this->data['User']['password'] ) ) {
        $this->data['User']['confirm_password'] = $this->Auth->password( $this->data['User']['confirm_password'] );        
      }
      
      $this->data['User']['user_type_id'] = UserType::CONTRACTOR;
      
      # debug( $this->data ); exit;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->Auth->login( $this->data['User'] );
        $this->Contractor->User->saveField( 'last_login', date( 'Y-m-d H:i:s' ) );
        $this->redirect( array( 'action' => 'service_area', $this->Contractor->id ) );
      }
      else if( !empty( $this->Contractor->validationErrors ) ){
        $this->Session->setFlash( 'Please correct the errors below.', null, null, 'validation' );
      }
      else {
        $this->Session->setFlash( 'An error occurred while attempting to save this data.', null, null, 'validation' );
      }
      
      unset( $this->data['User']['password'] );
      unset( $this->data['User']['confirm_password'] );
    }
    else {
      $this->data = $this->Contractor->find(
        'first',
        array(
          'contain' => array( 'User', 'BillingAddress' ),
          'conditions' => array( 'Contractor.id' => $contractor_id ),
        )
      );
    }
  }
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param   $contractor_id
   * @access  public
   */
  public function service_area( $contractor_id ) {
    $contractor = $this->Contractor->find(
      'first',
      array(
        'contain' => array(
          'County' => array( 'State' ),
        ),
        'conditions' => array(
          'Contractor.id' => $contractor_id,
        )
      )
    );
    
    if( !empty( $this->data ) ) {
      $this->Contractor->id = $contractor_id;
      $this->data['Contractor']['id'] = $contractor_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'scope', $contractor_id ) );
      }
      else {
        $this->Session->setFlash( 'We were unable to save your service area details.', null, null, 'error' );
      }
    }
    else {
      $this->data['Contractor']['id'] = $contractor_id;
    }
    
    # Get states in list format
    $states = $this->Contractor->County->State->states( 'list' );
    # Counties in the serviced states
    $serviced_state_counties = $this->Contractor->County->State->counties( array_unique( Set::extract( '/County/State/code', $contractor ) ) );
    # County data grouped by state
    $serviced_state_counties = Set::combine( $serviced_state_counties, '{n}.County.county', '{n}', '{n}.State.state' );
    # The county ids actually serviced by this contractor
    $serviced_counties = Set::extract( '/County/id', $contractor );
    
    $previous_url = array( 'action' => 'index', $contractor['Contractor']['id'] );
    
    $this->set( compact( 'previous_url', 'serviced_counties', 'serviced_state_counties', 'states' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify the technologies
   * they service, manufacturers they are certified by and incentive
   * programs they belong to.
   *
   * @param   $contractor_id
   * @access  public
   */
  public function scope( $contractor_id ) {
    $contractor = $this->Contractor->find(
      'first',
      array(
        'contain' => array(
          'Technology',
          'ManufacturerDealer'
        ),
        'conditions' => array(
          'Contractor.id' => $contractor_id,
        )
      )
    );
    
    if( !empty( $this->data ) ) {
      $this->Contractor->id = $contractor_id;
      $this->data['Contractor']['id'] = $contractor_id;
      
      # For our purposes, we can treat ManufacturerDealer records as HABTM
      # even though it's technically not. We have to recreate the "magic", though,
      # by deleting all association records first.
      $this->Contractor->ManufacturerDealer->deleteAll( array( 'ManufacturerDealer.contractor_id' => $contractor_id ), true, true );
      
      # Some manufacturers exist across multiple technologies, so we need to
      # dedup the contractor-selected list before we save.
      $checked = array();
      foreach( $this->data['ManufacturerDealer'] as $i => $manufacturer ) {
        $manufacturer_id = $manufacturer['equipment_manufacturer_id'];
        
        if( !array_key_exists( $manufacturer_id, $checked ) ) {
          $checked[$manufacturer_id] = $manufacturer_id;
        }
        else {
          # Unset the duplicate
          unset( $this->data['ManufacturerDealer'][$i] );
        }
      }
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'utility_rebates', $contractor_id ) );
      }
      else {
        $this->Session->setFlash( 'We were unable to save your work details.', null, null, 'error' );
      }
    }
    else {
      $this->data = $contractor;
    }
    
    # All available technologies for checkbox display, organized into columns
    $technologies = $this->Contractor->Technology->find(
      'list',
      array(
        'contain'    => false,
        'conditions' => array( 'Technology.display' => 1 ),
        'order'      => 'Technology.name',
      )
    );
    $technologies = array_chunk( $technologies, ceil( count( $technologies ) / 4 ), true );
    
    # Technologies the contractor has said s/he services
    $technology_scope    = Set::extract( '/Technology/id', $contractor );
    # Manufacturers for the technologies in the contractor scope
    $tech_manufacturers  = $this->Contractor->Technology->manufacturers( $technology_scope, 'all' );
    # Manufacturers the contractor is a dealer for and incentive participation
    $manufacturer_dealer = Set::combine( $contractor, 'ManufacturerDealer.{n}.equipment_manufacturer_id', 'ManufacturerDealer.{n}' );
    
    $previous_url = array( 'action' => 'service_area', $this->data['Contractor']['id'] );
    
    $this->set( compact( 'manufacturer_dealer', 'previous_url', 'technologies', 'tech_manufacturers', 'technology_scope' ) );
  }
  
  /**
   * Displays the form that allows contractors to indicate the utilities
   * whose incentive programs they participate in.
   *
   * @param   $contractor_id
   * @access  public
   */
  public function utility_rebates( $contractor_id ) {
    if( !empty( $this->data ) ) {
      $this->Contractor->id = $contractor_id;
      $this->data['Contractor']['id'] = $contractor_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'payment', $contractor_id ) );
      }
      else {
        $this->Session->setFlash( 'We were unable to save your utility participation settings.', null, null, 'error' );
      }
    }
    else {
      $this->data['Contractor']['id'] = $contractor_id;
    }
    
    $zip_codes = $this->Contractor->zip_codes_serviced( $contractor_id, false );
    
    # All utilities operating in the contractor's service area
    $utilities = $this->Contractor->Utility->by_zip_code( $zip_codes );
    $utilities = array_chunk( $utilities, ceil( count( $utilities ) / 3 ), true );
    
    # Utilities the contractor has already defined a relationship with
    $utility_relationships = $this->Contractor->utilities( $contractor_id );
    $utility_relationships = Set::combine( $utility_relationships, '{n}.id', '{n}' );
    
    $previous_url = array( 'action' => 'scope', $this->data['Contractor']['id'] );
    
    $this->set( compact( 'previous_url', 'utilities', 'utility_relationships' ) );
  }
  
  /**
   * Displays a form where contractors can enter their payment details.
   *
   * @param   $contractor_id
   * @access  public
   */
  public function payment( $contractor_id ) {
    exit( 'Payment details are not yet implemented.' );
  }
    
  /**
   * PRIVATE METHODS
   */
}
