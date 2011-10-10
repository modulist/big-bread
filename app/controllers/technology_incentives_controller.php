<?php

class TechnologyIncentivesController extends AppController {
	public $name = 'TechnologyIncentives';

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
   * @access	public
   */
  public function quote() {
    
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
