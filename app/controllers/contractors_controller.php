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
    if( !empty( $this->data ) ) {
      $this->Contractor->id = $contractor_id;
      $this->data['Contractor']['id'] = $contractor_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'action' => 'scope', $contractor_id ) );
      }
      else {
        $this->Session->setFlash( 'We were unable to save your service area details.', null, null, 'error' );
      }
    }
    else {
      $this->data['Contractor']['id'] = $contractor_id;
    }
    
    $states = $this->Contractor->County->State->states();
    # Massage to list format (e.g. MD => Maryland )
    $states = Set::combine( $states, '{n}.State.code', '{n}.State.state' );
    
    $this->set( compact( 'states', 'user_id' ) );
  }
  
  /**
   * Displays a form allowing contractors to identify the technologies
   * they service, manufacturers they are certified by and incentive
   * programs they belong to.
   *
   * @param 	$contractor_id
   * @access	public
   */
  public function scope( $contractor_id ) {
    if( !empty( $this->data ) ) {
      $this->Contractor->id = $contractor_id;
      $this->data['Contractor']['id'] = $contractor_id;
      
      if( $this->Contractor->saveAll( $this->data ) ) {
        $this->redirect( array( 'controller' => 'contacts', 'action' => 'index' ) );
      }
      else {
        $this->Session->setFlash( 'We were unable to save your service area details.', null, null, 'error' );
      }
    }
    else {
      $this->data['Contractor']['id'] = $contractor_id;
    }
    
    $technologies = $this->Contractor->Technology->find(
      'list',
      array(
        'contain'    => false,
        'conditions' => array( 'Technology.display' => 1 ),
        'order'      => 'Technology.name',
      )
    );
    $technologies = array_chunk( $technologies, ceil( count( $technologies ) / 4 ), true );
    
    $this->set( compact( 'technologies' ) );
  }
    
  /**
   * PRIVATE METHODS
   */
}
