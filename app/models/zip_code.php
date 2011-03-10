<?php

class ZipCode extends AppModel {
	public $name       = 'ZipCode';
	public $useTable   = 'us_zipcode';
	public $primaryKey = 'zip';
	
  /** TODO: Add state assoc */
	public $hasOne = array(
		'Address' => array(
			'className' => 'Address',
			'foreignKey' => 'zip_code'
		),
	);
}
