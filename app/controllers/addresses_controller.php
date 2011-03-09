<?php

class AddressesController extends AppController {
	public $name = 'Addresses';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( '*' );
  }
  
  public function locale( $zip_code ) {
    $locale = $this->Address->ZipCode->find(
      'first', array(
        'contain'    => false,
        'fields'     => array( 'city', 'state' ),
        'conditions' => array( 'zip' => $zip_code ),
      )
    );
    
    $this->set( compact( 'locale' ) );
  }

  public function zipcodes() {
    $zip_codes = $this->Address->ZipCode->find(
      'all',
      array( 'contain' => false, 'fields' => array( 'zip' ), 'order' => array( 'zip' ) )
    );
    
    $this->set( 'zip_codes', array_keys( Set::combine( $zip_codes, '{n}.ZipCode.zip' ) ) );
  }
}
