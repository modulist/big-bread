<?php

class Api extends Object {
  /**
   * Dispatches an API call.
   *
   * @param 	$controller
   * @return	type
   * @access	public
   */
  public function dispatch( $params ) {
    new PHPDump( $params, 'Api::dispatch' );
    exit( 'Api::dispatch' );
  }
}
