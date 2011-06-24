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
  
  /**
   * Retrieves the relevant incentives (rebates) for a given zip code.
   *
   * @param 	$zip
   * @param   $building_id
   * @return	array
   */
  public function incentives( $zip ) {
    return $this->Incentive->TechnologyIncentive->incentives( $zip );
  }
}

