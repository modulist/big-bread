<?php

class TechnologyIncentivesController extends AppController {
	public $name       = 'TechnologyIncentives';
  public $components = array( 'FormatMask.Format' );
  public $helpers    = array( 'FormatMask.Format' );

  /**
   * Displays the details of a given incentive.
   *
   * @param   $id
   * @access	public
   */
  public function details( $id ) {
    $rebate = $this->TechnologyIncentive->get( $id );
    
    $this->set( compact( 'rebate' ) );
  }
  
  /**
   * Displays the page to request a quote.
   *
   * @param   $id           The rebate to be quoted.
   * @param   $location_id  The location to which the quote applies.
   * @access	public
   */
  public function quote( $id, $location_id = null ) {
    if( !empty( $this->data ) ){
      
    }
    else {
      $user     = $this->Auth->user();
      $rebate   = $this->TechnologyIncentive->get( $id );
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

      $this->data = Set::merge( $rebate, $location );
      $this->data['Requestor'] = $user[$this->Auth->getModel()->alias];
    }
    
    # Explode the user's phone number if it exists in a data array
    if( isset( $this->data['Requestor']['phone_number'] ) && is_string( $this->data['Requestor']['phone_number'] ) ) {
      $this->data['Requestor']['phone_number'] = $this->Format->phone_number( $this->data['Requestor']['phone_number'] );
    }
    
    # new PHPDump( $this->data ); exit;
    
    # $this->set( compact( 'location', 'rebate' ) );
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
