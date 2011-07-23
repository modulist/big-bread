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
		if( !isset( $this->args[0] ) ) {
			$this->out( 'An email address must be specified in order to identify a unique user.' );
			exit();
		}
    
    $email = $this->args[0];

    # TODO: Remove in the wild. This test code.
    # $this->create_dummy_user( $email );
    # $this->out( 'Pausing for 30 seconds to verify that the dummy user was created.' );
    # sleep( 30 );
    
    $user_id = $this->User->field( 'id', array( 'User.email' => $email ) );
    $this->User->delete( $user_id );
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
