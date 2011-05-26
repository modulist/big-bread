<?php

class Address extends AppModel {
	public $name = 'Address';
	
	public $belongsTo = array(
    'ZipCode' => array( 'foreignKey' => 'zip_code' ),
  );
	public $hasOne    = array( 'Building' );
  
	public $validate  = array(
		'address_1' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Address cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
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
        'rule'    => array( 'known' ), 
        'message' => 'Please check the zip code. This one is not in our database.' 
      ),
		),
	);
  
  /**
   * Custom validation method to ensure that the entered zip exists in
   * the database. Everything we do hinges on the zip code so an invalid
   * value needs to be caught and reported.
   *
   * @param   $field
   * @access  public
   */
  public function known( $field ) {
    $zip = array_shift( $field );
    
    return $this->ZipCode->find(
      'count',
      array(
        'contain'    => false,
        'conditions' => array( 'ZipCode.zip' => $zip ),
      )
    );
  }
}
