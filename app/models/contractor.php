<?php

class Contractor extends AppModel {
	public $name = 'Contractor';
	public $displayField = 'company_name';
	public $validate = array(
		'company_name' => array(
			'notempty' => array(
				'rule' => array( 'notempty' ),
				'message'    => 'Please tell us the name of your company',
				'allowEmpty' => false,
				'required'   => false,
			),
		),
	);
	
	public $belongsTo = array(
		'BillingAddress' => array(
			'className'  => 'Address',
			'foreignKey' => 'billing_address_id',
		),
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
		),
	);

	public $hasMany = array(
		'ManufacturerDealer' => array(
			'className'  => 'ManufacturerDealer',
			'foreignKey' => 'contractor_id',
			'dependent'  => true,
		),
	);

  # The deep definition exists because at least one of the models has
  # a non-standard table name.
	public $hasAndBelongsToMany = array(
		'County' => array(
			'className' => 'County',
			'joinTable' => 'contractors_counties',
			'foreignKey' => 'contractor_id',
			'associationForeignKey' => 'county_id',
			'unique' => true,
		),
		'Technology' => array(
			'className' => 'Technology',
			'joinTable' => 'contractors_technologies',
			'foreignKey' => 'contractor_id',
			'associationForeignKey' => 'technology_id',
			'unique' => true,
		),
		'Utility' => array(
			'className' => 'Utility',
			'joinTable' => 'contractors_utilities',
			'foreignKey' => 'contractor_id',
			'associationForeignKey' => 'utility_id',
			'unique' => true,
    ),
	);
  
  /**
   * Returns the list of counties that defines a given contractor's
   * service area.
   *
   * @param 	$contractor_id
   * @return	array
   * @access	public
   */
  public function service_area_by_county( $contractor_id ) {
    $counties = $this->find(
      'first',
      array(
        'contain'    => array( 'County' => array( 'ZipCode' ) ),
        'conditions' => array( 'Contractor.id' => $contractor_id ),
      )
    );
    
    return $counties['County'];
  }
  
  /**
   * Returns a list of zip codes in a given contractor's service area.
   * The service area itself is stored by county.
   *
   * @param 	$contractor_id
   * @param   $all  Whether to return all zip code data or just the zip
   *                code value itself.
   * @return	array
   * @access	public
   */
  public function service_area_by_zip_code( $contractor_id, $all = true ) {
    $counties  = $this->service_area_by_county( $contractor_id );
    $zip_codes = $all
      ? Set::extract( '/ZipCode', $counties )
      : Set::extract( '/ZipCode/zip', $counties );
    
    return $zip_codes;
  }
  
  /**
   * Retrieves the utilities a contractor has indicated an incentive
   * relationship with.
   *
   * @param 	$contractor_id
   * @return	array
   * @access	public
   */
  public function utilities( $contractor_id ) {
    $utilities = $this->find(
      'first',
      array(
        'contain'    => array( 'Utility' ),
        'conditions' => array( 'Contractor.id' => $contractor_id ),
      )
    );
    
    return $utilities['Utility'];
  }
}
