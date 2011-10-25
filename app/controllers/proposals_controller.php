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
  public function quote( $id, $location_id = null ) {
    $rebate   = $this->Proposal->Technology->TechnologyIncentive->get( $id );
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
      $this->Proposal->Requestor->Building->id = $this->data['Building']['id'];
      
      # In this context, utility data isn't required.
      foreach( array( 'Electricity', 'Gas', 'Water' ) as $utility ) {
        $this->Proposal->Requestor->Building->{$utility . 'Provider'}->validate = array();
        
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
      if( !$this->Proposal->Requestor->Building->saveAll( $this->data, array( 'validate' => 'only' ) ) ) {
        $validationErrors = array_merge( $validationErrors, $this->Proposal->Requestor->Building->validationErrors );
      }
      
      if( empty( $validationErrors ) ) {
        $this->Proposal->Requestor->saveField( 'phone_number', $this->data['Requestor']['phone_number'] );
        $this->Proposal->Requestor->Building->saveAll( $this->data, array( 'validate' => false ) ); # This was validated above
          
        # With basic validation done...get everything in one place
        $this->data = Set::merge( $rebate, $location, $this->data );
        
        $this->data['Proposal']['user_id']                 = $this->Auth->user( 'id' );
        $this->data['Proposal']['technology_incentive_id'] = $this->data['TechnologyIncentive']['id'];
        $this->data['Proposal']['location_id']             = $this->data['Building']['id'];
        
        if( $this->Proposal->save( $this->data['Proposal'] ) ) {
          # TODO: Retrieve the set of qualified contractors and iterate
          # -- Generate a message record for each contractor recipient
          # TODO: Pull existing equipment for this technology in this location
          # TODO: Pull related rebates
          
          # new PHPDump( $this->data ); exit;
          
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
            'location' => array(
              'address_1' => $this->data['Address']['address_1'],
              'address_2' => $this->data['Address']['address_2'],
              'city'      => $this->data['Address']['ZipCode']['city'],
              'state'     => $this->data['Address']['ZipCode']['state'],
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
              )
            ),
          );
          
          # TODO: change the recipient id
          $this->Proposal->Message->queue( MessageTemplate::TYPE_PROPOSAL, 'Proposal', $this->Proposal->id, $this->Auth->user( 'id' ), $this->Auth->user( 'id' ), $replacements );
           
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
  
  /**
   * Displays the request form.
   *
   * @param   $building_id
   * @param 	$technology_incentive_id
   * @access	public
   */
  /* 
  public function request( $building_id = null, $technology_incentive_id = null ) {
    $this->layout    = 'blank';
    
    $building_id = empty( $this->data['Building']['id'] )
      ? $building_id
      : $this->data['Building']['id'];
    $technology_incentive_id = empty( $this->data['TechnologyIncentive']['id'] )
      ? $technology_incentive_id
      : $this->data['TechnologyIncentive']['id'];
    $requestor = $this->Auth->user();
    
    # If the auth user is an admin, the requestor is really the
    # building's "client".
    if( User::admin( $this->Auth->user( 'id' ) ) ) {
      $client = $this->Proposal->Requestor->Building->find(
        'first',
        array(
          'contain'    => array( 'Client' ),
          'conditions' => array( 'Building.id' => $building_id )
        )
      );
      
      $requestor['User'] = $client['Client'];
    }
    
    $tech_incentive = $this->Proposal->Requestor->Building->Address->ZipCode->Incentive->TechnologyIncentive->find(
      'first',
      array(
        'contain'    => array( 'Technology', 'Incentive' ),
        'fields'     => array( 'Technology.id', 'Technology.title', 'Incentive.id' ),
        'conditions' => array( 'TechnologyIncentive.id' => $technology_incentive_id ),
      )
    );
    
    if( !empty( $this->data ) ) {
      $phone_number_input = $this->data['Requestor']['phone_number'];

      # Set data points
      $this->data['Proposal']['user_id']       = $requestor['User']['id'];
      $this->data['Proposal']['technology_id'] = $tech_incentive['Technology']['id'];
      $this->data['Proposal']['incentive_id']  = $tech_incentive['Incentive']['id'];
      
      $this->Proposal->Requestor->id = $requestor['User']['id'];
      if( $this->Proposal->Requestor->saveField( 'phone_number', $this->data['Requestor']['phone_number'] ) ) {
        # Update the auth user info (if auth user is requestor)
        if( $requestor['User']['id'] === $this->Auth->user( 'id' ) ) {
          $this->refresh_auth( 'phone_number', $this->data['Requestor']['phone_number'] );
        }
        
        if( $this->Proposal->save( $this->data ) ) {
          return $this->setAction( 'send_request', $requestor );
        }
      }
    }
    else {
      $this->data['Requestor']['phone_number'] = $requestor['User']['phone_number'];
    }
    
    $this->data['Building']['id']            = $building_id;
    $this->data['TechnologyIncentive']['id'] = $technology_incentive_id;
    
    $this->set( 'technology', Inflector::singularize( $tech_incentive['Technology']['name'] ) );
  }
  */
  
  /**
   * Sends a proposal request
   *
   * @param   $requestor  Requesting user data array
   * @access	public
   */
  /* 
  public function send_request( $requestor = null ) {
    # We could get to TechnologyIncentive through associations, but
    # it's a long chain. This way feels cleaner.
    $this->TechnologyIncentive = ClassRegistry::init( 'TechnologyIncentive' );
    
    # The incentive that was specifically selected for the proposal request.
    $quoted_incentive = $this->TechnologyIncentive->get( $this->data['TechnologyIncentive']['id'] );
    
    # If the quoted incentive is manufacturer-specific, we need to
    # identify the manufacturer so we can ignore incentives offered
    # by other manufacturers.
    $manufacturer = null;
    
    if( $quoted_incentive['Incentive']['incentive_type_id'] === 'MANU' && !empty( $quoted_incentive['Incentive']['equipment_manufacturer_id'] ) ) {
      $manufacturer = $quoted_incentive['Incentive']['equipment_manufacturer_id'];
    }
    
    # Related incentives (will ignore the quoted incentive)
    $zip_code = $this->Proposal->Requestor->Building->zip_code( $this->data['Building']['id'] );
    $related_incentives = $this->TechnologyIncentive->related(
      $quoted_incentive,
      $zip_code,
      $manufacturer
    );
    $requestor = empty( $requestor ) ? $this->Auth->user() : $requestor;
    $address   = $this->Proposal->Requestor->Building->address( $this->data['Building']['id'] );
    $existing_equipment = $this->Proposal->Requestor->Building->equipment( $this->data['Building']['id'], $this->data['Proposal']['technology_id'] );

    # Use redirected email addresses, if warranted
    $cc_email = Configure::read( 'email.redirect_all_email_to' )
      ? Configure::read( 'email.redirect_all_email_to' )
      : $requestor['User']['email'];
    
    # @see AppController::__construct() for common settings
    $this->SwiftMailer->sendAs   = 'html'; # TODO: send to 'both'?
    $this->SwiftMailer->from     = $requestor['User']['email']; 
    $this->SwiftMailer->fromName = $requestor['User']['full_name'];
    $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
        ? Configure::read( 'email.redirect_all_email_to' )
        : Configure::read( 'email.proposal_recipient' );
    
    if( !Configure::read( 'email.redirect_all_email_to' ) ) {
      $this->SwiftMailer->cc = array( $cc_email => $requestor['User']['full_name'] );
    }
    
    $proposal      = $this->data['Proposal'];
    $technology    = $quoted_incentive['Technology']['name'];
    $technology_id = $quoted_incentive['TechnologyIncentive']['id'];
    
    # set variables to template as usual
    $this->set( compact( 'address', 'existing_equipment', 'proposal', 'quoted_incentive', 'related_incentives', 'requestor', 'technology', 'technology_id' ) );

    try {
      if( !$this->SwiftMailer->send( 'proposal_request', $requestor['User']['full_name'] . ' requests a proposal from a qualified contractor', 'native' ) ) {
        foreach($this->SwiftMailer->postErrors as $failed_send_to) { 
          $this->log( 'Failed to send request for proposal to ' . $failed_send_to ); 
        }
        
        $this->Session->setFlash( 'There was a problem sending your request.', null, null, 'error' );
        $this->redirect( array( 'action' => 'request' ) );
      }
    } 
    catch( Exception $e ) { 
      $this->log( 'Failed to send proposal email: ' . $e->getMessage() ); 
        
      $this->Session->setFlash( 'There was a problem sending your request.', null, null, 'error' );
      $this->redirect( array( 'action' => 'request' ) );
    }
  }
  */
}
