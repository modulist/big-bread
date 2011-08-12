<?php

class ZipCode extends AppModel {
	public $name       = 'ZipCode';
	public $useTable   = 'us_zipcode';
	public $primaryKey = 'zip';

  public $hasMany = array(
		'ZipCodeIncentive' => array(
			'className' => 'ZipCodeIncentive',
			'foreignKey' => 'zip',
		),
    'ZipCodeUtility' => array(
      'className'  => 'ZipCodeUtility',
      'foreignKey' => 'zip',
    ),
  );
	public $hasOne = array(
		'Address' => array( 'foreignKey' => 'zip_code' ),
    'State'   => array( 'foreignKey' => 'state' ),
	);
  public $hasAndBelongsToMany = array(
    'Incentive' => array(
      'className'             => 'Incentive',
      'joinTable'             => 'incentive_zips',
      'foreignKey'            => 'zip',
      'associationForeignKey' => 'incentive_id',
    ),
  );
  
  /**
   * Returns the state that owns a given zip code.
   *
   * @param 	$zip_code
   * @return	string
   * @access	public
   */
  public function state( $zip_code ) {
    return $this->field( 'state', array( 'ZipCode.zip' => $zip_code ) );
  }
  
  /**
   * Returns the locale (city, state) for a given zip code
   *
   * @param 	$zip
   * @return	array
   * @access	public
   */
  public function locale( $zip ) {
    return $this->find(
      'first',
      array(
        'contain'    => false,
        'fields'     => array( 'ZipCode.city', 'ZipCode.state' ),
        'conditions' => array( 'ZipCode.zip' => $zip ),
      )
    );
  }
  
  /**
   * Returns the id of each incentive specifically targeting a
   * particular zip code.
   *
   * THIS METHOD DOES NOT RETURN ALL INCENTIVES OR EVEN ALL INCENTIVE
   * DATA. IDs ONLY AND ONLY FOR THOSE INCENTIVES THAT TARGET A
   * SPECIFIC ZIP CODE.
   *
   * @param 	$zip_code
   * @return	array
   * @access	public
   */
  public function incentives( $zip_code ) {
    $cache_config = 'day';
    $cache_key    = strtolower( 'zipcode_incentives_' . $zip_code );
    
    $zip_code_incentives = Cache::read( $cache_key, $cache_config );
    
    if( $zip_code_incentives === false ) {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{ZipCode::incentives} Running query for incentives (cache key: ' . $cache_key . ')', LOG_DEBUG );
      
      $zip_code_incentives = $this->ZipCodeIncentive->find(
        'all',
        array(
          'fields' => array( 'DISTINCT ZipCodeIncentive.incentive_id'),
          'conditions' => array( 'ZipCodeIncentive.zip' => $zip_code ),
        )
      );
      
      $zip_code_incentives = Set::extract( '/ZipCodeIncentive/incentive_id', $zip_code_incentives );
      
      Cache::write( $cache_key, $zip_code_incentives, $cache_config );
    }
    else {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{ZipCode::incentives} Pulling incentives data from cache (cache key: ' . $cache_key . ')', LOG_DEBUG );
    }
    
    return $zip_code_incentives;
  }
  
  /**
   * Retrieves the known utility providers for a given zip code.
   *
   * @param   $zip
   * @param   $type
   * @return  array
   */
  public function utilities( $zip, $type ) {
    $type = ucwords( $type );
    
    if( !in_array( $type, array( 'Electricity', 'Gas', 'Water' ) ) ) {
      return false;
    }
    
    $type_code = ZipCodeUtility::$type_code_reverse_lookup[$type];
    $utilities = $this->ZipCodeUtility->find(
      'all',
      array(
        'recursive'  => 0,
        'fields'     => array( 'Utility.id', 'Utility.name' ),
        'conditions' => array(
          'Utility.reviewed'    => 1,
          'ZipCodeUtility.zip'  => $zip,
          'ZipCodeUtility.type' => $type_code
        ),
      )
    );
    
    $type = array( 'code' => $type_code, 'name' => $type );
    
    return array( 'Type' => $type, 'Utilities' => $utilities );
  }
}

