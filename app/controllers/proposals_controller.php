<?php

class ProposalsController extends AppController {
	public $name       = 'Proposals';
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );
  public $helpers    = array( 'Form', 'FormatMask.Format' );

  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();
    
    # Squash the phone number if it exists in a data array to prep for save
    if( !empty( $this->data['Requestor']['phone_number'] ) && is_array( $this->data['Requestor']['phone_number'] ) ) {
      $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $this->data['Requestor']['phone_number'] );
    }
  }
  
  public function beforeRender() {
    parent::beforeRender();
    
    # Explode the phone number if it exists in a data array to prep for form display
    $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $this->data['Requestor']['phone_number'] );
  }

  /**
   * PUBLIC METHODS
   */
  
  /**
   * Displays the page to request a quote.
   *
   * @param   $id           The rebate to be quoted.
   * @param   $location_id  The location to which the quote applies.
   * @access	public
   */
  public function request( $id, $location_id = null ) {
    $rebate   = $this->Proposal->TechnologyIncentive->get( $id );
    $location = ClassRegistry::init( 'Building' )->find(
      'first',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
          'ElectricityProvider',
          'GasProvider',
          'WaterProvider',
        ),
        'conditions' => array( 'Building.id' => $location_id ),
      )
    );
    
    # Update a few validation rules that are specific to this context
    $this->Proposal->Requestor->validate = Set::merge(
      $this->Proposal->Requestor->validate,
      array(
        'phone_number' => array(
          'notempty' => array(
            'rule'       => 'notEmpty',
            'message'    => 'Please enter a phone number so can can contact you with any questions about the work.',
            'allowEmpty' => false,
            'required'   => true,
            'last'       => true,
          ),
          'usphone' => array(
            'allowEmpty' => false,
            'required'   => true,
          ),
        )
      )
    );

    if( !empty( $this->data ) ){
      $this->Proposal->Requestor->id = $this->Auth->user( 'id' );
      $this->Proposal->Building->id = $this->data['Building']['id'];
      
      # In this context, utility data isn't required.
      foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility ) {
        $this->Proposal->Building->{$utility . 'Provider'}->validate = array();
        
        # That said, if they'e emptied a value that already exists, we just want
        # to remove that utility's association with this building; not update the
        # utility itself.
        if( isset( $this->data[$utility . 'Provider'] ) && empty( $this->data[$utility . 'Provider']['name'] ) ) {
          $this->data['Building'][strtolower( $utility ) . '_provider_id'] = null;
          unset( $this->data[$utility . 'Provider'] );
        }
      }
      
      # Compile our validation errors from each separate
      $validationErrors = array();
      
      $this->Proposal->Requestor->set( $this->data['Requestor'] );
      if( !$this->Proposal->Requestor->validates( array( 'fieldList' => array( 'phone_number' ) ) ) ) {
        $validationErrors['Requestor'] = $this->Proposal->Requestor->validationErrors;
      }
      if( !$this->Proposal->Building->saveAll( $this->data, array( 'validate' => 'only' ) ) ) {
        $validationErrors = array_merge( $validationErrors, $this->Proposal->Building->validationErrors );
      }
      
      if( empty( $validationErrors ) ) {
        $this->Proposal->Requestor->saveField( 'phone_number', $this->data['Requestor']['phone_number'] );
        $this->Proposal->Building->unbindModel( array( 'hasMany' => array( 'Proposal' ) ) ); # We don't want to save the proposal just yet
        $this->Proposal->Building->saveAll( $this->data, array( 'validate' => false ) ); # This was validated above

        # With basic validation done...get everything in one place
        $this->data = Set::merge( Set::merge( $rebate, $location ), $this->data );

        $this->data['Proposal']['user_id']                 = $this->Auth->user( 'id' );
        $this->data['Proposal']['technology_incentive_id'] = $this->data['TechnologyIncentive']['id'];
        $this->data['Proposal']['location_id']             = $this->Proposal->Building->id;
        
        if( $this->Proposal->save( $this->data['Proposal'] ) ) {
          # TODO: Retrieve the set of qualified contractors and iterate
          # -- Generate a message record for each contractor recipient
          $stackable_rebates = $this->Proposal->TechnologyIncentive->related( $this->data['TechnologyIncentive'], $this->data['Address']['zip_code'], $this->data['Incentive']['equipment_manufacturer_id'] );
          $fixtures = $this->Proposal->TechnologyIncentive->Technology->Fixture->find(
            'all',
            array(
              'contain'    => false,
              'conditions' => array(
                'Fixture.building_id'   => $this->data['Building']['id'],
                'Fixture.technology_id' => $this->data['Technology']['id']
              ),
            )
          );
          
          $this->loadModel( 'ZipCode' );
          $replacements = array(
            'sender_full_name' => sprintf( '%s %s', $this->data['User']['first_name'], $this->data['User']['last_name'] ),
            'proposal' => array(
              'scope_of_work' => $this->data['Proposal']['scope_of_work'] == 'install'
                ? sprintf( __( 'Install or replace my %s.', true ), strtolower( Inflector::singularize( $this->data['Technology']['title'] ) ) )
                : sprintf( __( 'Repair or service my %s.', true ), strtolower( Inflector::singularize( $this->data['Technology']['title'] ) ) ),
              'under_warranty' => $this->data['Proposal']['under_warranty'],
              'permission_to_examine' => $this->data['Proposal']['permission_to_examine'],
              'notes' => $this->data['Proposal']['notes'],
            ),
            'fixtures' => $fixtures,
            'location' => array(
              'address_1' => $this->data['Address']['address_1'],
              'address_2' => $this->data['Address']['address_2'],
              'city'      => $this->ZipCode->field( 'city', array( 'ZipCode.zip' => $this->data['Address']['zip_code'] ) ),
              'state'     => $this->ZipCode->field( 'state', array( 'ZipCode.zip' => $this->data['Address']['zip_code'] ) ),
              'zip_code'  => $this->data['Address']['zip_code'],
            ),
            'sender' => array(
              'phone_number' => $this->data['Requestor']['phone_number'],
              'email'        => $this->Auth->user( 'email' ),
            ),
            'rebate' => array(
              'amount' => $this->data['TechnologyIncentive']['amount'],
              'name'   => $this->data['Incentive']['name'],
              'amount_type' => array(
                'code'   => $this->data['IncentiveAmountType']['incentive_amount_type_id'],
                'symbol' => $this->data['IncentiveAmountType']['name'],
              ),
              'expiration_date' => $this->data['Incentive']['expiration_date'],
              'energy_source' => Set::extract( '/EnergySource/name', $this->data ),
              'options' => Set::extract( '/TechnologyOption/name', $this->data ),
              'terms' => $this->data['TechnologyTerm'],
            ),
            'stackable_rebates' => $stackable_rebates,
            'technology' => $this->data['Technology'],
          );
          
          # TODO: change the recipient id
          # Currently null recipient to messages to go to Tony
          $this->Proposal->Message->queue( MessageTemplate::TYPE_PROPOSAL, 'Proposal', $this->Proposal->id, $this->Auth->user( 'id' ), null, $replacements );
           
          $this->Session->setFlash( 'Your request for a quote has been delivered.', null, null, 'success' );
          $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard', $this->data['Building']['id'] ), null, true );
        }
        else {
          $this->Session->setFlash( 'There was a problem generating your proposal', null, null, 'error' );
        }
      }
      else {
        # Write the complete list of validation errors to the view
        $this->set( compact( 'validationErrors' ) );
      }
    }
    else {
      $user = $this->Auth->user();

      $this->data = Set::merge( $rebate, $location );
      $this->data['Requestor'] = $user[$this->Auth->getModel()->alias];
    }
    
    $this->set( compact( 'location', 'rebate' ) );
  }
  
  /**
   * Displays the UI to begin the process of redeeming a rebate.
   *
   * @param 	$TBD
   * @access	public
   */
  public function redeem() {
    
  }
}
