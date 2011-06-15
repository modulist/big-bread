<?php

class ContractorsController extends AppController {
	public $name = 'Contractors';

  /**
   * CALLBACKS
   */

  /**
   * PUBLIC METHODS
   */
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param 	$user_id
   * @access	public
   */
  public function contact_info( $user_id ) {
    # Is this an existing contractor?
    $contractor = $this->Contractor->find(
      'first',
      array(
        'contain' => array( 'BillingAddress' ),
        'conditions' => array(
          'Contractor.user_id' => $user_id,
        )
      )
    );
    
    if( !empty( $this->data ) ) {
      # If the contractor exists, set the model id so that the existing
      # record gets updated.
      if( !empty( $contractor ) ) {
        $this->Contractor->id = $contractor['Contractor']['id'];
        $this->data['Contractor']['id'] = $this->Contractor->id;
      }
      
      $this->data['Contractor']['user_id'] = $user_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'service_area', $this->Contractor->id ) );
      }
      else {
        $this->Session->setFlash( 'Please correct the errors below.', null, null, 'validation' );
      }
    }
    else {
      $this->data = $contractor;
    }
    
    $this->set( compact( 'user_id' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param 	$contractor_id
   * @access	public
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
    
    $previous_url = array( 'action' => 'contact_info', $contractor['Contractor']['user_id'] );
    
    $this->set( compact( 'previous_url', 'serviced_counties', 'serviced_state_counties', 'states' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify the technologies
   * they service, manufacturers they are certified by and incentive
   * programs they belong to.
   *
   * @param 	$contractor_id
   * @access	public
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
   * @param 	$contractor_id
   * @access	public
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
    
    $zip_codes = $this->Contractor->service_area_by_zip_code( $contractor_id, false );
    $utilities = $this->Contractor->County->ZipCode->ZipCodeUtility->Utility->by_zip_code( $zip_codes );
    
    # Chunk the utility list for column display
    $utilities = array_chunk( $utilities, ceil( count( $utilities ) / 3 ), true );
    
    $previous_url = array( 'action' => 'scope', $this->data['Contractor']['id'] );
    
    $this->set( compact( 'previous_url', 'utilities' ) );
  }
  
  /**
   * Displays a form where contractors can enter their payment details.
   *
   * @param 	$contractor_id
   * @access	public
   */
  public function payment( $contractor_id ) {
    exit( 'Payment details not yet implemented' );
  }
    
  /**
   * PRIVATE METHODS
   */
}
