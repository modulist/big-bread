<?php

class UserType extends AppModel {
	public $name = 'UserType';

	public $hasMany = array( 'User' );
  
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
   * Returns the user type id for a given name.
   *
   * @param 	string $user_type
   * @return	uuid
   * @access	public
   */
  static public function id( $user_type ) {
    return ClassRegistry::init( 'UserType' )->field( 'id', array( 'UserType.name' => $user_type ) );
  }
}
