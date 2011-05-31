<?php

App::import( 'Lib', 'api/Api' );
class ApiV1 extends Api {
  /**
   * Retrieves a list of US states. This is a method to test the API by
   * pulling inocuous data.
   *
   * @return
   * @access	public
   */
  public function states_get() {
    return ClassRegistry::init( 'State' )->find(
      'all',
      array(
        'contain' => false,
        'order'   => 'State.state'
      )
    );
  }
  
  /**
   * Creates a new user.
   *
   * @param   $post_data  An array of POST data forwarded from ApiController::dispatch().
   * @return  array
   * @access	public
   * @todo    Restrict to POST
   */
  public function users_create( $post_data ) {
    $post_data_defaults = array(
      'user_type'    => null,
      'first_name'   => null,
      'last_name'    => null,
      'email'        => null,
      'phone_number' => null,
    );
    
    $data['User'] = array_merge( $post_data_defaults, $post_data );
    
    # We're allowing a limited set of human readable user types that
    # we'll convert to ids. Make sure we got one.
    if( !in_array( strtolower( trim( $data['User']['user_type'] ) ), array( 'owner', 'buyer', 'realtor', 'inspector' ) ) ) {
      # TODO: throw error
    }
    
    # Adjust the friendly user type to the appropriate UUID
    switch( strtolower( trim( $data['User']['user_type'] ) ) ) {
      case 'owner':
        $data['User']['user_type_id'] = UserType::OWNER;
        break;
      case 'buyer':
        $data['User']['user_type_id'] = UserType::BUYER;
      case 'inspector':
        $data['User']['user_type_id'] = UserType::REALTOR;
      case 'inspector':
        $data['User']['user_type_id'] = UserType::INSPECTOR;
      default:
        # TODO: 40X error
        break;
    }
    
    # Create an invite code
    $data['User']['invite_code'] = User::generate_invite_code();
    
    $this->User = ClassRegistry::init( 'User' );
    if( $this->User->save( $data ) ) {
      return array(
        'invite_link' => 'http://bigbread.net/invite/' . $data['User']['invite_code'],
      );
    }
    else {
      return array( 'errors' => $this->User->invalidFields() );
    }
  }
}
