<?php

class UserType extends AppModel {
	public $name = 'UserType';

	public $hasMany = array( 'User' );
  
  public static $lookup = array();
  public static $reverse_lookup = array();
  
  /**
   * Constructor.
   */
  public function __construct( $id = false, $table = null, $ds = null ) {
    parent::__construct( $id, $table, $ds );
    
    # Populate the static types array for easy access
    $types = $this->find(
      'list',
      array(
        'contain'    => false,
        'conditions' => array( 'UserType.selectable' => 1 ),
      )
    );
    foreach( $types as $id => $name ) {
      self::$lookup[$id] = strtoupper( $name );
      self::$reverse_lookup[strtoupper( $name )] = $id;
    }
    
    # new PHPDump( self::$lookup );
    # new PHPDump( self::$reverse_lookup ); exit;
  }
  
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Returns the user type name for a given id.
   *
   * @param 	uuid $user_type_id
   * @return	string
   * @access	public
   */
  static public function name( $user_type_id ) {
    return ClassRegistry::init( 'UserType' )->field( 'name', array( 'UserType.id' => $user_type_id ) );
  }
  
  /**
   * Returns the user type id for a given code.
   *
   * @param 	string $user_type
   * @return	uuid
   * @access	public
   */
  static public function id( $user_type ) {
    return ClassRegistry::init( 'UserType' )->field( 'id', array( 'UserType.code' => $user_type ) );
  }
}
