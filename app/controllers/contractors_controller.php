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
  public function add( $user_id ) {
    if( !empty( $this->data ) ) {
      exit( 'do stuff' );
    }
    
    $this->set( compact( 'user_id' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param 	$user_id
   * @access	public
   */
  public function service_area( $user_id ) {
    $states = $this->Contractor->County->State->states();
    
    if( !empty( $this->data ) ) {
      exit( 'do stuff' );
    }
    
    $this->set( compact( 'states', 'user_id' ) );
  }
    
  /**
   * PRIVATE METHODS
   */
}
