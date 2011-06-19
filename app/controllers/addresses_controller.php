<?php

class AddressesController extends AppController {
	public $name = 'Addresses';
  
  /**
   * CALLBACKS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();

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
   * Retrieves the list of counties in a given state.
   *
   * @param 	$state_id   e.g. AL, OH, CA, etc.
   * @return	array
   * @access	public
   */
  public function counties( $state_id ) {
    $counties = $this->Address->ZipCode->State->counties( $state_id );
    
    $this->set( compact( 'counties' ) );
  }

  /**
   * Retrieves the known utility providers for a given zip code.
   *
   * @param   $zip_code
   * @return  array
   */
  public function utilities( $zip_code, $type ) {
    $type = ucwords( $type );
    
    if( !in_array( $type, array( 'Electricity', 'Gas', 'Water' ) ) ) {
      /** TODO: Return a 403 (?) error? */
    }
    
    $type_code = ZipCodeUtility::$type_code_reverse_lookup[$type];
    $utilities = $this->Address->ZipCode->ZipCodeUtility->find(
      'all',
      array(
        'fields'     => array( 'Utility.id', 'Utility.name' ),
        'conditions' => array(
          'Utility.reviewed'    => 1,
          'ZipCodeUtility.zip'  => $zip_code,
          'ZipCodeUtility.type' => $type_code
        ),
        'recursive'  => 0,
      )
    );
    
    $type = array( 'code' => $type_code, 'name' => $type );
    
    $this->set( compact( 'type', 'utilities' ) );
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
