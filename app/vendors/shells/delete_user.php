<?php
    
App::import( 'Core', 'Security' );
    
/**
 * Validates key links in the system and emails a report.
 * Usage: ./cake/console/cake -app <path to app/ directory> delete_user <email>
 */
class DeleteUserShell extends Shell {
	public $uses = array( 'User' );

  public function startup() {
    parent::startup();
  }

	public function main() {
		if( isset( $this->args[0] ) && Validation::email( $this->args[0] ) ) {
      $email = $this->args[0];
		}
    else {
      # Assume we're trying to test the script and create a user to delete
      $this->create_dummy_user( 'dummy.' . md5( String::uuid() ) . '@user.com' );
      $this->out( 'Pausing for 30 seconds to verify that the dummy user was created.' );
      sleep( 30 );
    }
    
    $user_id = $this->User->field( 'id', array( 'User.email' => $email ) );
    
    if( !empty( $user_id ) ) {
      # TODO: Find buildings associated with only this user
      $this->User->delete( $user_id );
      # TODO: Delete buildings associated with only this user
      #       Can we call DeleteBuildingShell, maybe?
    }
    else {
      $this->out( 'No user with an email address of ' . $email . ' was found. No user was deleted.' );
    }
  }
  
  public function create_dummy_user( $email ) {
    $user = array(
      'User' => array(
        'user_type_id' => UserType::CONTRACTOR,
        'first_name'   => 'Dummy',
        'last_name'    => 'Data',
        'email'        => $email,
      ),
      'Contractor' => array(
        'company_name'   => 'My Company',
        'certified_nate' => 1,
        'certified_bpi'  => 1,
      ),
      'BillingAddress' => array(
        'model'     => 'Contractor',
        'address_1' => '1234 Bite Me',
        'zip_code'  => '21224',
      ),
    );
    
    if( !$this->User->Contractor->saveAll( $user ) ) {
      debug( $this->User->Contractor->invalidFields() );
      exit;
    }
  }
}
