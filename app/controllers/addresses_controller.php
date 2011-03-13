<?php

class AddressesController extends AppController {
	public $name = 'Addresses';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    $this->Auth->allow( '*' );
  }
  
  /**
   * Retrieves the locale (city, state) for a given zip code.
   *
   * @param   $zip_code
   * @return  array
   */
  public function locale( $zip_code ) {
    $locale = $this->Address->ZipCode->find(
      'first',
      array(
        'contain'    => false,
        'fields'     => array( 'ZipCode.city', 'ZipCode.state' ),
        'conditions' => array( 'ZipCode.zip' => $zip_code ),
      )
    );
    
    $this->set( compact( 'locale' ) );
  }

  /**
   * Retrieves the known utility providers for a given zip code.
   *
   * @param   $zip_code
   * @return  array
   */
  public function utilities( $zip_code, $type ) {
    $type = strtoupper( $type );
    
    if( !in_array( $type, array( 'ELE', 'GAS', 'WTR' ) ) ) {
      /** TODO: Return a 403 (?) error? */
    }
    
    $utilities = $this->Address->ZipCode->ZipCodeUtility->find(
      'all',
      array(
        'contain'    => 'Utility',
        'fields'     => array( 'Utility.id', 'Utility.utility_id', 'Utility.name' ),
        'conditions' => array( 'ZipCodeUtility.zip' => $zip_code, 'ZipCodeUtility.type' => $type ),
      )
    );
    
    # new PHPDump( $utilities ); exit;
    
    $this->set( compact( 'utilities' ) );
  }

  /**
   * Returns all known zip codes. This method is a huge performance hit
   * and its use should be avoided.
   *
   * @return  array
   * @ignore
   */
  public function zipcodes() {
    $zip_codes = $this->Address->ZipCode->find(
      'all',
      array( 'contain' => false, 'fields' => array( 'ZipCode.zip' ), 'order' => array( 'ZipCode.zip' ) )
    );
    
    $this->set( 'zip_codes', array_keys( Set::combine( $zip_codes, '{n}.ZipCode.zip' ) ) );
  }
}
