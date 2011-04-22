<?php

class Contact extends AppModel {
  public $useTable = false;
  public $_schema  = array(
    'name'         => array( 'type' => 'string', 'length' => 255 ), 
    'email'        => array( 'type' => 'string', 'length' => 255 ), 
    'company'      => array( 'type' => 'string', 'length' => 255 ), 
    'phone_number' => array( 'type' => 'string', 'length' => 255 ), 
    'zip_code'     => array( 'type' => 'string', 'length' => 255 ),
    'user_type'    => array( 'type' => 'string', 'length' => 255 ),
    'message'      => array( 'type' => 'text' ),
  );
  
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'email' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Email address cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
        'last'       => true,
			),
			'email' => array(
				'rule'       => array( 'email' ),
				'message'    => 'Email address is invalid.',
				'allowEmpty' => false,
				'required'   => true,
        'last'       => true,
			),
		),
		'phone_number' => array(
			'phoneNumber' => array(
				'rule'       => array( 'phone', null, 'us' ),
				'message'    => 'Phone number is invalid.',
				'allowEmpty' => true,
				'required'   => false,
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
		'user_type' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'User type cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'message' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Message cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
	);
}
