<?php

class Address extends AppModel {
	public $name = 'Address';
	
	public $belongsTo = array(
    'State'   => array( 'foreignKey' => 'state' ),
    'ZipCode' => array( 'foreignKey' => 'zip' ),
  );
	public $hasOne    = array( 'Building' );
  
	public $validate  = array(
		'address_1' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Address cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'city' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'City cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'state' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'State cannot be empty',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'zip_code' => array(
			'postal' => array(
				'rule'       => array( 'postal', null, 'us' ),
				'message'    => 'Zip code must be a valid US postal code.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
	);
}
