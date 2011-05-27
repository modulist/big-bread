<?php

class ApiController extends AppController {
	public $name = 'Api';
  public $uses = null; # no model for this controller

  /**
   * description
   *
   * @param 	$arg
   * @return	type		description
   * @access	public
   */
  public function dispatch() {
    # Load the appropriate API version and dispatch the call
    $api_class = 'Api' . strtoupper( $this->params['version'] );
    
    App::import( 'Lib', 'api/' . $api_class );
    $api = new $api_class();
    $api->dispatch( $this->params );
  }
}
