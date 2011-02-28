<?php

class SurveysController extends AppController {
  public $name = 'Surveys';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( 'create' );
  }

  
  /**
   * Displays the survey form.
   *
   * @param 	$arg
   * @return	type		description
   */
  public function create() {
    if( !$this->accessible() ) {
      $this->header( 'HTTP/1.1 403 Forbidden' );
      throw new Exception( 'Access Forbidden' );
    }
  }
}
