<?php

class ApiController extends AppController {
	public $name = 'Api';
  public $uses = null; # no model for this controller
  
  # Ensure that each supported format has a parsed extension.
  # @see app/config/routes, Router::parseExtensions()
  private $supported_formats = array( 'json', 'jsonp' );

  /**
   * beforeFilter callback
   *
   * @return	void
   * @access	public
   */
  public function beforeFilter() {
    parent::beforeFilter();
    
    if( !$this->validate_request_method() ) {
      header( 'Method not allowed', true, 405 );
      exit( 'The requested method (' . env( 'REQUEST_METHOD' ) . ') is not allowed for the resource /' . $this->params['url']['url'] . '.' );
    }
    
    if( !$this->validate_response_format() ) {
      header( 'Not Found', true, 404 );
      exit( 'An invalid format was requested. Supported ' . __n( 'format', 'formats', count( $this->supported_formats ), true ) . ': ' . join( ', ', $this->supported_formats ) . '. Please reformat your request with an appropriate extension.' );
    }
  }

  /**
   * Dispatches an API request to the appropriate method of intended
   * API version.
   *
   * @access	public
   */
  public function dispatch() {
    $params    = $this->params;
    $api_class = 'Api' . strtoupper( $params['version'] ); # e.g. ApiV1
    
    App::import( 'Lib', 'api/' . $api_class );
    $api = new $api_class();
    
    if( method_exists( $api, $params['method'] ) ) {
      if( !empty( $params['form'] ) ) {
        array_push( $params['pass'], $params['form'] );
      }

      # For JSONP requests, we're going to expect a "callback" parameter in either
      # the query string or form data (for GET and POST/PUT requests, respectively).
      # We need to set the callback value so the view can handle it accordingly.
      if( $params['url']['ext'] === 'jsonp' ) {
        $this->RequestHandler->setContent( 'js' );
        
        if( $this->RequestHandler->isGet() && array_key_exists( 'callback', $params['url'] ) ) {
          $this->set( 'callback', $params['url']['callback'] );
        }
        else if( $this->RequestHandler->isPost() && array_key_exists( 'callback', $params['form'] ) ) {
          $this->set( 'callback', $params['form']['callback'] );
        }
        else {
          # TODO: Throw invalid format error of some sort. JSONP requests must have callback.
        }
      }
      
      # Evalutates to $api->$params['method']() with each argument passed.
      $result = call_user_func_array( array( $api, $params['method'] ), $params['pass'] );
      $this->set( 'response', $result );
      
      # Set the layout path based on the extension
      # TODO: I didn't think that setting this path explicitly was necessary.
      # @see http://stackoverflow.com/questions/6565201/cakephp-extensions-and-layouts
      $this->layoutPath = $params['url']['ext'];
      $this->layout     = 'default';
      
      # Use a method-specific view if it exists, the generic otherwise.
      $view_root = '_api/' . $params['version'] . '/' . $params['url']['ext'];
      if( file_exists( $view_root . '/' . $params['api_controller'] . '/' . $params['api_action'] . '.ctp' ) ) {
        $view_path = $view_root . '/' . $params['api_controller'];
        $view      = $params['api_action'];
      }
      else {
        $view_path = $view_root;
        $view      = 'default';
      }
      
      $this->viewPath = $view_path;
      $this->render( $view );
    }
    else {
      header( 'Not Found', true, 404 );
      exit( 'The requested resource does not exist.' );
    }
  }
  
  /**
   * Validates the request method for API actions.
   *
   * @return	boolean
   * @access	public
   */
  public function validate_request_method() {
    $valid = false;
    
    switch( $this->params['api_action'] ) {
      case 'create':
        $valid = $this->RequestHandler->isPost();
        break;
      
      case 'update':
        $valid = $this->RequestHandler->isPut();
        break;
      
      case 'delete':
        $valid = $this->RequestHandler->isDelete();
        break;
      
      default:
        $valid = $this->RequestHandler->isGet();
        break;
    }
    
    return $valid;
  }
  
  /**
   * Validates the requested response format.
   *
   * @return	boolean
   * @access	public
   */
  public function validate_response_format() {
    return in_array( $this->params['url']['ext'], $this->supported_formats );
  }
}
