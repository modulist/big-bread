<?php

class ApiRoute extends CakeRoute {
  function parse( $url ) {
    $params = parent::parse( $url );
    
    if( empty( $params ) ) {
      return false;
    }
    
    # Redirect to the API controller with the appropriate method
    $params['method']     = $params['controller'] . '_' . $params['action'];
    $params['controller'] = 'api';
    $params['action']     = 'dispatch';
    
    return $params;
  }
}
