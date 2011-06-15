<?php

class TechnologiesController extends AppController {
	public $name = 'Technologies';
  
  /**
   * PUBLIC METHODS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();

    $this->Auth->allow( '*' );
  }
  
  /**
   * Retrieves manufacturers of a given technology.
   *
   * @param 	$technology_id
   * @access	public
   */
  public function manufacturers( $technology_id ) {
    $manufacturers = $this->Technology->manufacturers( $technology_id );
    
    $this->set( compact( 'manufacturers' ) );
  }
}
