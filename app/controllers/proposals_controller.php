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
      $this->data['Proposal']['user_id']       = $this->Auth->user( 'id' );
      $this->data['Proposal']['technology_id'] = $tech_incentive['Technology']['id'];
      $this->data['Proposal']['incentive_id']  = $tech_incentive['Incentive']['id'];
      
      $this->Proposal->Requestor->id = $this->Auth->user( 'id' );
      if( $this->Proposal->Requestor->saveField( 'phone_number', $this->data['Requestor']['phone_number'] /** , true */ ) ) {  # Validating creates display issues
        # Update the auth user info
        $this->Session->write( 'Auth.User.phone_number', $this->data['Requestor']['phone_number'] );
        
        if( $this->Proposal->save( $this->data ) ) {
          return $this->setAction( 'send_request' );
        }
      }
      else {
        # Probably an invalid phone number. Restore what was passed
        $this->data['Requestor']['phone_number'] = $phone_number_input;
      }
    }
    else {
      # Set the phone number based on auth data if nothing was passed
      $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $this->Auth->user( 'phone_number' ) );
    }
    
    $this->data['Building']['id']            = $building_id;
    $this->data['TechnologyIncentive']['id'] = $technology_incentive_id;
    
    $this->set( 'technology', Inflector::singularize( $tech_incentive['Technology']['name'] ) );
  }
  
  /**
   * Sends a proposal request
   *
   * @access	public
   */
  public function send_request() {
    $this->helpers[] = 'FormatMask.Format';
    
    $address = $this->Proposal->Requestor->Building->address( $this->data['Building']['id'] );
    $incentives = $this->Proposal->Requestor->Building->incentives(
      $this->data['Building']['id'],
      array( 'technology_id' => $this->data['Proposal']['technology_id'], )
    );
      
    /** 
    $this->SwiftMailer->smtpType = 'tls'; 
    $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
    $this->SwiftMailer->smtpPort = 465; 
    $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
    $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
    */
    $this->SwiftMailer->sendAs   = 'html'; # TODO: send to 'both'?
    $this->SwiftMailer->from     = $this->Auth->user( 'email' ); 
    $this->SwiftMailer->fromName = $this->Auth->user( 'full_name' );
    $this->SwiftMailer->to       = 'wamaull@federatedpower.com';
    
    # set variables to template as usual
    $sender             = $this->Auth->user();
    $rebate             = array_shift( Set::extract( '/TechnologyIncentive[id=' . $this->data['TechnologyIncentive']['id'] . ']/..', $incentives ) );
    $related_incentives = $incentives;
    $proposal           = $this->data['Proposal'];
    $technology         = Inflector::singularize( $rebate['Technology']['name'] );
    $technology_id      = $rebate['TechnologyIncentive']['id'];
    
    $this->set( compact( 'address', 'proposal', 'rebate', 'related_incentives', 'sender', 'technology', 'technology_id' ) );
     
    try {
      if( !$this->SwiftMailer->send( 'proposal_request', $this->Auth->user( 'full_name' ) . ' requests a proposal from a qualified contractor', 'native' ) ) {
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
