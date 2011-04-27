<?php

class BuildingProductsController extends AppController {
	public $name = 'BuildingProducts';

  /**
   * Retire a piece of equpment.
   *
   * @param 	$id
   * @access	public
   */
  public function retire( $id ) {
    $this->autoRender = false;
    
    if( $this->RequestHandler->isAjax() && $this->RequestHandler->isPost() ) {
      $this->BuildingProduct->id = $id;
      // $this->BuildingProduct->saveField( 'service_out', date( 'Y-m-d H:i:s', time() ) );
    }
    else {
      // Send HTTP error status (400?)
    }
  }
}
