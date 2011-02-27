<?php

class SurveysController extends AppController {
  public $name = 'Survey';
  
  /**
   * Displays the survey form.
   *
   * @param 	$arg
   * @return	type		description
   */
  public function create() {
    if( !$this->accessible() ) {
      exit( 'not accessible' );
    }
    
    exit( 'accessible' );
  }
}
