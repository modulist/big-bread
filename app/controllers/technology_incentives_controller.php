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
   * @param   $id
   * @access	public
   */
  public function quote( $id ) {
    $rebate    = $this->TechnologyIncentive->get( $id );
    $requestor = $this->Auth->user();
    
    # new PHPDump( $rebate ); exit;
    
    $this->set( compact( 'rebate', 'requestor' ) );
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
