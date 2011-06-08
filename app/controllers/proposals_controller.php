<?php

class ProposalsController extends AppController {
	public $name       = 'Proposals';
  public $components = array( 'SwiftMailer', 'FormatMask.Format' );

  /**
   * PUBLIC METHODS
   */
  
  /**
   * Displays the request form.
   *
   * @param   $building_id
   * @param 	$technology_incentive_id
   * @access	public
   */
  public function request( $building_id = null, $technology_incentive_id = null ) {
    $this->helpers[] = 'Form';
    $this->helpers[] = 'FormatMask.Format';
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
        'fields'     => array( 'Technology.id', 'Technology.name', 'Incentive.id' ),
        'conditions' => array( 'TechnologyIncentive.id' => $technology_incentive_id ),
      )
    );
    
    if( !empty( $this->data ) ) {
      $phone_number_input = $this->data['Requestor']['phone_number'];
      
      # Set data points
      $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $this->data['Requestor']['phone_number'] );
      $this->data['Proposal']['user_id']       = $requestor['User']['id'];
      $this->data['Proposal']['technology_id'] = $tech_incentive['Technology']['id'];
      $this->data['Proposal']['incentive_id']  = $tech_incentive['Incentive']['id'];
      
      $this->Proposal->Requestor->id = $requestor['User']['id'];
      if( $this->Proposal->Requestor->saveField( 'phone_number', $this->data['Requestor']['phone_number'] /** , true */ ) ) {  # Validating creates display issues
        # Update the auth user info (if auth user is requestor)
        if( $requestor['User']['id'] == $this->Auth->user( 'id' ) ) {
          $this->update_auth_session( $this->Proposal->Requestor );
        }
        
        if( $this->Proposal->save( $this->data ) ) {
          return $this->setAction( 'send_request', $requestor );
        }
      }
      else {
        # Probably an invalid phone number. Restore what was passed
        $this->data['Requestor']['phone_number'] = $phone_number_input;
      }
    }
    else {
      # Set the phone number based on auth data if nothing was passed
      $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $requestor['User']['phone_number'] );
    }
    
    $this->data['Building']['id']            = $building_id;
    $this->data['TechnologyIncentive']['id'] = $technology_incentive_id;
    
    $this->set( 'technology', Inflector::singularize( $tech_incentive['Technology']['name'] ) );
  }
  
  /**
   * Sends a proposal request
   *
   * @param   $requestor  Requesting user data array
   * @access	public
   */
  public function send_request( $requestor = null ) {
    $this->helpers[] = 'FormatMask.Format';
    
    # The incentive that was specifically selected for the proposal request.
    $quoted_incentive   = $this->Proposal->Requestor->Building->Address->ZipCode->Incentive->TechnologyIncentive->get( $this->data['TechnologyIncentive']['id'] );
    
    # If the quoted incentive is manufacturer-specific, we need to ignore
    # incentives for other manufacturers.
    $manufacturer       = null;
    if( $quoted_incentive['Incentive']['incentive_type_id'] === 'MANU' && !empty( $quoted_incentive['Incentive']['equipment_manufacturer_id'] ) ) {
      $manufacturer = $quoted_incentive['Incentive']['equipment_manufacturer_id'];
    }
    
    # Related incentives (ignoring the quoted incentive)
    $related_incentives = $this->Proposal->Requestor->Building->incentives(
      $this->data['Building']['id'],
      array(
        'technology_id' => $this->data['Proposal']['technology_id'],
        'equipment_manufacturer_id' => $manufacturer,
        'not' => array( $quoted_incentive['TechnologyIncentive']['id'] ),
      )
    );
    $requestor = empty( $requestor ) ? $this->Auth->user() : $requestor;
    $address   = $this->Proposal->Requestor->Building->address( $this->data['Building']['id'] );
    $existing_equipment = $this->Proposal->Requestor->Building->equipment( $this->data['Building']['id'], $this->data['Proposal']['technology_id'] );

    # Use redirected email addresses, if warranted
    $cc_email = Configure::read( 'email.redirect_all_email_to' )
      ? Configure::read( 'email.redirect_all_email_to' )
      : $requestor['User']['email'];
        
    /** 
    $this->SwiftMailer->smtpType = 'tls'; 
    $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
    $this->SwiftMailer->smtpPort = 465; 
    $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
    $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
    */
    $this->SwiftMailer->sendAs   = 'html'; # TODO: send to 'both'?
    $this->SwiftMailer->from     = $requestor['User']['email']; 
    $this->SwiftMailer->fromName = $requestor['User']['full_name'];
    $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
        ? Configure::read( 'email.redirect_all_email_to' )
        : Configure::read( 'email.proposal_recipient' );
    $this->SwiftMailer->cc       = array( $cc_email => $requestor['User']['full_name'] );
    
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
      $this->log( 'Failed to send email: ' . $e->getMessage() ); 
        
      $this->Session->setFlash( 'There was a problem sending your request.', null, null, 'error' );
      $this->redirect( array( 'action' => 'request' ) );
    }
  }
}
