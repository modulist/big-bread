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
}
