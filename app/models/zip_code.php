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
   * Retrieves the relevant incentives (rebates) for a given zip code.
   *
   * @param   $building_id
   * @param 	$zip
   * @return	array
   */
  public function incentives( $building_id, $zip ) {
    return $this->Incentive->TechnologyIncentive->by_zip( $building_id, $zip );
  }
}

