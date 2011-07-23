<?php

class User extends AppModel {
	public $name = 'User';
  
  public $belongsTo = array( 'UserType' );
  public $hasOne = array(
    'ApiUser' => array(
      'dependent' => true,
    ),
    'Contractor' => array(
      'dependent' => true,
    )
  );
  public $hasMany   = array(
    'Building' => array(
      'className'  => 'Building',
      'foreignKey' => 'inspector_id',
      'dependent'  => true,
    ),
    'Home' => array(
      'className'  => 'Building',
      'foreignKey' => 'client_id',
      'dependent'  => true,
    ),
    'Property' => array(
      'className'  => 'Building',
      'foreignKey' => 'realtor_id',
      'dependent'  => true,
    ),
    'Proposal' => array(
      'dependent' => true,
    ),
  );
  
  public $actsAs = array(
    'AuditLog.Auditable' => array(
      'ignore' => array( 'last_login' ),
    ),
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
      'identical' => array(
        'rule'    => array( 'identical', 'password' ), 
        'message' => 'Passwords do not match.' 
      ),
    ),
		'phone_number' => array(
			'usphone' => array(
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
    $this->whitelist = array_diff( array_keys( $this->schema() ), array( 'id', 'admin', 'last_login', 'deleted', 'created', 'modified' ) );
  }
  
  /**
   * CALLBACKS
   */
  
  /**
   * beforeValidate
   *
   * @return	boolean
   * @access	public
   */
  public function beforeValidate() {
    if( !empty( $this->data ) ) {
      /**
       * An empty password value is never empty. The auth module hashes the
       * empty value and that fools the validation rule. This is bad. We
       * want to know an empty password when we see one and throw it out, so
       * we have to make that adjustment manually.
       */
      $empty_password = Security::hash( '', null, true );
      
      if( isset( $this->data[$this->alias]['password'] ) && $this->data[$this->alias]['password'] == $empty_password ) {
        if( !empty( $this->id ) ) {
          # When editing, just remove the data so no change is made.
          # This allows users leave their password empty unless they
          # actually want to change it.
          unset( $this->data[$this->alias]['password'] );
          unset( $this->data[$this->alias]['confirm_password'] );
        }
        else {
          # When creating, empty the value so it will be caught by validation.
          $this->data[$this->alias]['password'] = '';
          $this->data[$this->alias]['confirm_password'] = '';
        }
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
        'admin',
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
   * @param   $admin    Whether the user is an admin
   * @return	array
   */
  public function buildings( $user_id ) {
    if( User::admin( $user_id ) ) {
      $conditions = false;
    }
    else {
      $conditions = array(
        'OR' => array(
          'Building.client_id'    => $user_id,
          'Building.realtor_id'   => $user_id,
          'Building.inspector_id' => $user_id,
        )
      );
    }
    
    /** TODO: include only fields we need */
    return $this->Building->find(
      'all',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
        ),
        'conditions' => $conditions,
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
  
  /**
   * Determines whether a given user has admin privileges.
   *
   * @param 	$user_id
   * @return	boolean
   * @access	public
   */
  static public function admin( $user_id ) {
    return ClassRegistry::init( 'User' )->field( 'User.admin', array( 'User.id' => $user_id ) );
  }
  
  /**
   * Determines whether a given user holds a "client" role.
   *
   * @param 	$user_id
   * @return	boolean
   * @access	public
   */
  static public function client( $user_id ) {
    $user_type_id = ClassRegistry::init( 'User' )->field( 'User.user_type_id', array( 'User.id' => $user_id ) );
    
    return in_array( $user_type_id, array( UserType::OWNER, UserType::BUYER ) );
  }
}
