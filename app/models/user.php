<?php

class User extends AppModel {
	public $name = 'User';
  public $belongsTo = array( 'UserType' );
  
	public $validate = array(
		'first_name' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'First name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Last name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'email' => array(
			'email' => array(
				'rule'       => array( 'email' ),
				'message'    => 'Email address is invalid.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'phone_number' => array(
			'phoneNumber' => array(
				'rule' => array( 'phone', null, 'us' ),
				'message' => 'Phone number is invalid.',
				'allowEmpty' => true,
				'required' => false,
			),
		),
	);
}
