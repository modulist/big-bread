<?php

class ApiRoute extends CakeRoute {
  function parse( $url ) {
    $params = parent::parse( $url );

    if( empty( $params ) ) {
      return false;
    }
    
    # API method that will be called by ApiController::dispatch()
    $params['method']         = $params['controller'] . '_' . $params['action'];
    $params['api_controller'] = $params['controller'];
    $params['api_action']     = $params['action'];
    $params['controller']     = 'api';
    $params['action']         = 'dispatch';
    
    return $params;
  }
}
