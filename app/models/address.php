<?php

class Address extends AppModel {
	public $name = 'Address';
  public $whitelist = array(
    'model',
    'foreign_key',
    'address_1',
    'address_2',
    'zip_code',
  );	
	public $belongsTo = array(
    'Building'   => array( 'foreignKey' => 'foreign_key' ),
    'Contractor' => array( 'foreignKey' => 'foreign_key' ),
    'ZipCode'    => array( 'foreignKey' => 'zip_code' ),
  );
  
  public $actsAs = array(
    'AuditLog.Auditable'
  );
  
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
        'rule'    => array( 'known_zip_code' ), 
        'message' => 'Please check the zip code. This one is not in our database.' 
      ),
		),
	);
  
  /**
   * CUSTOM VALIDATION
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
