<?php

class User extends AppModel {
	public $name = 'User';
  public $displayField = 'full_name';
  
  public $belongsTo = array(
    'UserType',
    'ZipCode'    => array( 'foreignKey' => 'zip_code' ),
  );
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
    'Message' => array(
      'className'   => 'Message',
      'foreignKey' => 'foreign_key',
      'conditions'  => array( 'Message.model' => 'User' ),
    ),
    'Property' => array(
      'className'  => 'Building',
      'foreignKey' => 'realtor_id',
      'dependent'  => true,
    ),
    'Proposal' => array(
      'dependent' => true,
    ),
    'ReceivedMessage' => array(
      'className'   => 'Message',
      'foreignKey' => 'recipient_id',
      'conditions'  => array( 'ReceivedMessage.model' => 'User' ),
    ),
    'SentMessage' => array(
      'className'   => 'Message',
      'foreignKey' => 'sender_id',
      'conditions'  => array( 'SentMessage.model' => 'User' ),
    ),
    'TechnologyWatchList' => array(
      'className'  => 'WatchList',
      'foreignKey' => 'foreign_key',
      'conditions' => array(
        'model' => 'Technology',
      ),
      'dependent'  => true,
    )
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
			),
			'unique' => array(
				'rule'       => 'isUnique',
				'message'    => 'This email address is already in use.',
				'allowEmpty' => false,
				'required'   => true,
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
    'zip_code' => array(
			'postal' => array(
				'rule'       => array( 'postal', null, 'us' ),
				'message'    => 'Zip code must be a valid US postal code.',
				'allowEmpty' => false,
				'required'   => true,
        'last'       => true,
			),
      'known' => array(
        'rule'    => array( 'known_zip_code' ), 
        'message' => 'Please check the zip code. This one is not in our database.' 
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
    # Generate a whitelist that doesn't require me to make an update every time
    # I add a property...unless I don't want that property to be batch updated.
    $this->whitelist = array_diff( array_keys( $this->schema() ), array( 'id', 'admin', 'last_login', 'active', 'created', 'modified' ) );
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
    # Don't return the password field unless it's specified.
    $query['fields'] = empty( $query['fields'] )
      ? array_diff( array_keys( $this->schema() ), array( 'password' ) )
      : $query['fields'];
    
    return $query;
  }
  
  /**
   * CUSTOM VALIDATION METHODS
   */
  
  /**
   * Custom validation method to ensure that the entered zip exists in
   * the database. Everything we do hinges on the zip code so an invalid
   * value needs to be caught and reported.
   *
   * @param   $field
   * @access  public
   */
  public function known_zip_code( $field ) {
    $zip_code = array_shift( $field );
    
    return $this->ZipCode->find(
      'count',
      array(
        'contain'    => false,
        'conditions' => array( 'ZipCode.zip' => $zip_code ),
      )
    );
  }
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Retrieves the authenticated user data or, optionally, a specific
   * property of the user data.
   *
   * @param 	$property
   * @return	mixed
   * @access	public
   */
  static public function get( $property = null ) {
    $user = Configure::read( 'User' );
    if( empty( $user ) || ( !empty( $property ) && !array_key_exists( $property, $user ) ) ) {
      return false;
    }
    
    return empty( $property ) ? $user : $user[$property];
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
   * Generates an invite code
   *
   * @return	string
   * @access	public
   */
  static public function generate_invite_code() {
    return md5( String::uuid() );
  }
  
  /**
   * Determines whether a user is associated with at least one building
   * by returning the number of associated buildings.
   *
   * @param   $user_id
   * @return  integer
   * @access  public
   */
  public function has_locations( $user_id = null ) {
    $user_id = !empty( $user_id ) ? $user_id : self::get( 'id' );
    
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
   * Alias for has_locations. Available for semantic purposes only.
   *
   * @param   $user_id
   * @return  integer
   * @access  public
   */
  public function location_count( $user_id = null ) {
    return $this->has_locations( $user_id );
  }
  
  /**
   * Retrieves the buildings associated with a given user.
   *
   * @param 	$user_id
   * @param   $limit
   * @return	array
   */
  public function locations( $user_id = null, $limit = null, $conditions = array() ) {
    $user_id = !empty( $user_id ) ? $user_id : self::get( 'id' );
    
    if( !User::admin( $user_id ) ) {
      $conditions['OR'] = array(
        'Building.client_id'    => $user_id,
        'Building.realtor_id'   => $user_id,
        'Building.inspector_id' => $user_id,
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
        'order'      => 'Building.created DESC',
        'limit'      => !empty( $limit ) ? $limit : false,
      )
    );
  }
  
  /**
   * Legacy alias for User::locations().
   *
   * @param 	$user_id
   * @param   $limit 
   * @return	array
   * @access	public
   */
  public function buildings( $user_id = null, $limit = null ) {
    return $this->locations( $user_id, $limit );
  }
  
  /**
   * Retrieves a user's watchlist for a given scenario.
   *
   * @param   $location_id
   * @param   $user_id
   * @return  array
   * @access  public
   */
  public function technology_watch_list( $location_id = null, $user_id = null ) {
    $user_id = !empty( $user_id ) ? $user_id : self::get( 'id' );
    
    $conditions = array(
      'TechnologyWatchList.user_id'     => $user_id,
      'TechnologyWatchList.model'       => 'Technology',
    );
    
    if( !empty( $location_id ) ) {
      $conditions['TechnologyWatchList.location_id'] = $location_id;
    }
    
    return $this->TechnologyWatchList->find(
      'all',
      array(
        'contain'    => false,
        'fields'     => array(
          'TechnologyWatchList.id',
          'TechnologyWatchList.foreign_key AS technology_id',
        ),
        'conditions' => $conditions,
      )
    );
  }
  
  /**
   * Adds a technology to a user's watch list.
   *
   * @param   $model        What are we watching? e.g. Technology
   * @param   $id           Which one are we watching? The watched item's id.
   * @param   $location_id
   * @param   $user_id
   * @return	boolean
   * @access	public
   */
  public function watch( $model, $id, $user_id, $location_id = null ) {
    $user_id = !empty( $user_id ) ? $user_id : self::get( 'id' );
    $watchable = array( 'Technology' );
    
    # We can't add just anything to a watchlist.
    if( !in_array( $model, WatchList::$watchable ) ) {
      return false;
    }
    
    $data = array(
      'user_id'     => $user_id,
      'model'       => $model,
      'location_id' => $location_id,
      'foreign_key' => $id,
    );
    
    return $this->TechnologyWatchList->save( $data );
  }
  
  /**
   * Removes a technology from a user's watch list.
   *
   * @param   $technology_id
   * @param 	$user_id
   * @return	boolean
   * @access	public
   */
  public function unwatch( $model, $id, $user_id, $location_id = null ) {
    $user_id = !empty( $user_id ) ? $user_id : self::get( 'id' );
    
    $watch_list_id = $this->TechnologyWatchList->field(
      'id',
      array(
       'TechnologyWatchList.user_id'     => $user_id,
       'TechnologyWatchList.model'       => $model,
       'TechnologyWatchList.location_id' => $location_id,
       'TechnologyWatchList.foreign_key' => $id,
      )
    );
    
    return $this->TechnologyWatchList->delete( $watch_list_id );
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
