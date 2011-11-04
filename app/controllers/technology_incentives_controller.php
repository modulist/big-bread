<?php

class TechnologyIncentivesController extends AppController {
	public $name       = 'TechnologyIncentives';
  public $components = array( 'FormatMask.Format' );
  public $helpers    = array( 'FormatMask.Format' );

  /**
   * Displays the details of a given incentive.
   *
   * @param   uuid  $id
   * @param   uuid  $location_id  Used by the "get a quote" link.
   * @access	public
   */
  public function details( $id, $location_id = null ) {
    $rebate = $this->TechnologyIncentive->get( $id );

    $this->loadModel( 'User' );    
    $user_has_locations = $this->User->has_locations();
    
    $this->set( compact( 'location_id', 'rebate', 'user_has_locations' ) );
  }
}
