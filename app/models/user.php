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
  
  const TYPE_HOMEOWNER = '4d71115d-0f74-43c5-93e9-2f8a3b196446';
  const TYPE_HOMEBUYER = '4d6d9699-a7a4-42a1-855e-4f606e891b5e';
  const TYPE_INSPECTOR = '4d6d9699-5088-48db-9f56-47ea6e891b5e';
  const TYPE_REALTOR   = '4d6d9699-f19c-41e3-a723-45ae6e891b5e';
  
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
   * beforeValidate
   *
   * @return	boolean
   * @access	public
   * @todo    What the hell is getting validated?
   */
  public function beforeValidate() {
    /**
     * When registering a user, an empty password value is salted and
     * sent so that notempty rules do not validate properly. Detect that
     * possibility and empty the value.
     */
    if( !empty( $this->data ) ) {
      $empty_password = Security::hash( '', null, true );
      
      if( isset( $this->data[$this->alias]['password'] ) && $this->data[$this->alias]['password'] == $empty_password ) {
        $this->data[$this->alias]['password'] = '';
      }
      if( isset( $this->data[$this->alias]['confirm_password'] ) && $this->data[$this->alias]['confirm_password'] == $empty_password ) {
        $this->data[$this->alias]['confirm_password'] = '';
      }
    }
    
    return true;
  }
  
  /**
   * beforeFind
   *
   * @param 	$query
   * @return	mixed
   * @access	public
   */
  public function beforeFind( $query ) {
    if( empty( $query['fields'] ) ) {
      // Don't return the password field when returning everything
      $query['fields'] = array(
        'id',
        'user_type_id',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone_number',
        'invite_code',
        'show_questionnaire_instructions',
        'last_login',
        'deleted',
        'created',
        'modified',
      );
    }
    
    return $query;
  }
  
  /**
   * PUBLIC METHODS
   */

  /**
   * Generates an invite code
   *
   * @return	string
   * @access	public
   */
  static public function generate_invite_code() {
    return md5( String::uuid() );
  }
  
  /**
   * Creates a user record.
   *
   * @param 	$data
   * @return	boolean
   * @access	public
   */
  public function add( $data ) {
    $user = !empty( $data[$this->alias]['email'] )
      ? $this->known( $data[$this->alias]['email'] ) # returns the user's id
      : false;
    
    if( !$user ) { # We don't know this user, create a new record
      if( $this->save( $data[$this->alias] ) ) {
        $user = $this->id;
      }
    }
    
    return $user;
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
      
      if( !empty( $compare ) && $value !== $compare ) {
        return false; 
      }
      else { 
        continue; 
      } 
    }
    
    return true; 
  } 
}
