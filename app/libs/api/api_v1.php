<?php

App::import( 'Lib', 'api/Api' );
class ApiV1 extends Api {
  /**
   * Retrieves the energy sources for a given technology.
   *
   * @param 	$technology_id
   * @return	array
   * @access	public
   */
  public function technologies_energy_sources( $technology_id ) {
    return ClassRegistry::init( 'Technology' )->energy_sources( $technology_id );
  }
  
  /**
   * Retrieves manufacturers of a given technology.
   *
   * @param 	$technology_id
   * @access	public
   */
  public function technologies_manufacturers( $technology_id ) {
    return ClassRegistry::init( 'Technology' )->manufacturers( $technology_id );
  }
  
  /**
   * Retrieves all counties in a given state.
   *
   * @param 	$state  The two-letter state abbreviation
   * @return	array
   * @access	public
   */
  public function states_counties( $state ) {
    return ClassRegistry::init( 'State' )->counties( $state );
  }
  
  /**
   * Retrieves the locale (city, state ) for a given zip code.
   *
   * @param 	$zip
   * @return	type
   * @access	public
   */
  public function zip_codes_locale( $zip ) {
    return ClassRegistry::init( 'ZipCode' )->locale( $zip );
  }
  
  /**
   * Returns the utilities operating in a given zip code
   *
   * @param 	$zip
   * @param   $type
   * @return	array
   * @access	public
   */
  public function zip_codes_utilities( $zip, $type ) {
    if( !in_array( $type, array( 'Electricity', 'Gas', 'Water' ) ) ) {
      # TODO: 400 error
    }
    
    return ClassRegistry::init( 'ZipCode' )->utilities( $zip, $type );
  }
  
  /**
   * Retrieves all US states.
   *
   * @return  array
   * @access	public
   */
  public function states() {
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
        'invite_link' => 'http://' . $_SERVER['HTTP_HOST'] . '/invite/' . $data['User']['invite_code'],
      );
    }
    else {
      return array( 'errors' => $this->User->invalidFields() );
    }
  }
}
