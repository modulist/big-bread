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
      $this->data['Contractor']['user_id'] = $user_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'service_area', $this->Contractor->id ) );
      }
    }
    
    $this->set( compact( 'user_id' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify their service area.
   *
   * @param 	$contractor_id
   * @access	public
   */
  public function service_area( $contractor_id ) {
    $this->Contractor->id = $contractor_id;
    
    if( !empty( $this->data ) ) {
      exit( 'do stuff' );
    }
    
    $states = $this->Contractor->County->State->states();
    # Massage to list format (e.g. MD => Maryland )
    $states = Set::combine( $states, '{n}.State.code', '{n}.State.state' );
    
    $this->set( compact( 'states', 'user_id' ) );
  }
    
  /**
   * PRIVATE METHODS
   */
}
