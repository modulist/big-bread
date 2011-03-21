<?php

class User extends AppModel {
	public $name = 'User';
  public $belongsTo = array( 'UserType' );
  
	public $validate = array(
		'first_name' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'First name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Last name cannot be empty.',
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
			'unique' => array(
				'rule'       => 'isUnique',
				'message'    => 'This email address is already in use.',
				'allowEmpty' => false,
				'required'   => true,
        'last'       => true,
			),
		),
		'password' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Password cannot be empty.',
				'allowEmpty' => false,
				'required'   => false,
        'last'       => true,
			),
      'identical' => array(
        'rule'    => array( 'identical', 'confirm_password' ), 
        'message' => 'Passwords do not match.' 
      ),
    ),
		'confirm_password' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Password cannot be empty.',
				'allowEmpty' => false,
				'required'   => false,
        'on'         => 'create',
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
		'user_type_id' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Primary role cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
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
   * Custom validation method to ensure that two field values are the
   * same before validating the model. Useful (and ubiquitous) for
   * authentication credentials.
   *
   * @param   $field
   * @param   $confirm_field
   * @access  public
   * @see     http://bakery.cakephp.org/articles/aranworld/2008/01/14/using-equalto-validation-to-compare-two-form-fields
   * @todo    Move this to app_model? Could be useful elsewhere.
   */
  function identical( $field = array(), $confirm_field = null ) { 
    foreach( $field as $key => $value ) { 
      $compare = $this->data[$this->alias][$confirm_field];
      
      if( $value !== $compare ) { 
        return false; 
      }
      else { 
        continue; 
      } 
    }
    
    return true; 
  } 
  
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
