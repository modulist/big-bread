<?php

class User extends AppModel {
	public $name = 'User';
  public $belongsTo = array( 'UserType' );
  public $hasMany   = array(
    'Home' => array(
      'className'  => 'Building',
      'foreignKey' => 'realtor_id',
    ),
    'Property' => array(
      'className'  => 'Building',
      'foreignKey' => 'realtor_id',
    ),
    'Building' => array(
      'className'  => 'Building',
      'foreignKey' => 'inspector_id',
    )
  );
  
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
      'identical' => array(
        'rule'    => array( 'identical', 'password' ), 
        'message' => 'Passwords do not match.' 
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
   * Constructor.
   *
   * This model uses several aliases (e.g. Client, Realtor, Inspector),
   * so the virtual fields must be defined here.
   * @see http://book.cakephp.org/view/1632/Virtual-fields-and-model-aliases
   */
  public function __construct( $id = false, $table = null, $ds = null ) {
    parent::__construct( $id, $table, $ds );
    
    $this->virtualFields['full_name'] = sprintf( 'CONCAT(%s.first_name, " ", %s.last_name)', $this->alias, $this->alias );
  }
  
  /**
   * CALLBACKS
   */
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Registers (creates) a new user that is being created by any means
   * other than user registration. For example, a 3rd party associated with
   * a building who is created via the questionnaire.
   *
   * @param 	$data
   * @return	array
   * @access	public
   */
  public function save( $data ) {
    $user = !empty( $data[$this->alias]['email'] )
      ? $this->known( $data[$this->alias]['email'] )
      : false;
    
    if( !$user ) { # This is a new user (or the same user with a different email addy)
      $data[$this->alias]['invite_code'] = md5( String::uuid() );
      
      parent::save( $data[$this->alias] );
    }
  }
  
  /**
   * Retrieves the buildings associated with a given user.
   *
   * @param 	$user_id
   * @return	array
   */
  public function buildings( $user_id ) {
    /** TODO: include only fields we need */
    return $this->Building->find(
      'all',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
        ),
        'conditions' => array(
          'OR' => array(
            'Building.client_id'    => $user_id,
            'Building.realtor_id'   => $user_id,
            'Building.inspector_id' => $user_id,
          )
        ),
        'order' => 'Building.created DESC'
      )
    );
  }
  
  /**
   * Returns the identifier of the most recently created building
   * associated with the specified user.
   */
  public function has_building( $user_id ) {
    return $this->Building->find(
      'count',
      array(
        'contain'    => false,
        'conditions' => array(
          'OR' => array(
            'Building.client_id'    => $user_id,
            'Building.realtor_id'   => $user_id,
            'Building.inspector_id' => $user_id,
          )
        ),
      )
    );
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
  public function identical( $field = array(), $confirm_field = null ) { 
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
}
