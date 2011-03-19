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
			'notempty' => array(
				'rule'       => array( 'notempty' ),
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
			'unique' => array(
				'rule'       => 'isUnique',
				'message'    => 'This email address is already in the system.',
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
	);
  
  /**
   * CALLBACKS
   */

  /**
   * PUBLIC METHODS
   */
  
  /**
   * Determines whether a user already exists (is known) based on an
   * email address (a unique key).
   *
   * @param 	$email
   * @return	uuid    The user identifier
   */
  public function known( $email ) {
    /**
     * TODO: When soft deletable, how do we handle existence? Can't
     * login if deleted, can't create a new profile with the same email.
     */
    $user = $this->find(
      'first',
      array(
        'contain' => false,
        'fields'  => array( $this->alias . '.id' ),
        'conditions' => array( $this->alias . '.email' => $email ),
      )
    );
    
    return !empty( $user ) ? $user[$this->alias]['id'] : false;
  }
}
