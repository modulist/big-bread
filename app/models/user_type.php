<?php

class UserType extends AppModel {
	public $name = 'UserType';

	public $hasMany = array( 'User' );

  const OWNER     = '4d71115d-0f74-43c5-93e9-2f8a3b196446';
  const BUYER     = '4d6d9699-a7a4-42a1-855e-4f606e891b5e';
  const INSPECTOR = '4d6d9699-5088-48db-9f56-47ea6e891b5e';
  const REALTOR   = '4d6d9699-f19c-41e3-a723-45ae6e891b5e';
  
  /**
   * Returns the user type name based on an id.
   *
   * @param 	$user_type_id
   * @return	string
   * @access	public
   */
  static public function name( $user_type_id ) {
    return $this->field( 'name', array( 'UserType.id' => $user_type_id ) );
  }
}
