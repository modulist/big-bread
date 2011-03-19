<?php

class ZipCode extends AppModel {
	public $name       = 'ZipCode';
	public $useTable   = 'us_zipcode';
	public $primaryKey = 'zip';
	
  public $hasMany = array(
    'ZipCodeUtility' => array( 'foreignKey' => 'zip' ),
  );
  
	public $hasOne = array(
		'Address' => array(
			'foreignKey' => 'zip_code',
		),
    'State' => array(
      'foreignKey' => 'state',
    ),
	);
}
