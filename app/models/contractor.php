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
				'required'   => true,
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
		'ManufacturerIncentiveCertification' => array(
			'className'  => 'ManufacturerIncentiveCertification',
			'foreignKey' => 'contractor_id',
			'dependent'  => true,
		),
		'UtilityIncentiveCertification' => array(
			'className'  => 'UtilityIncentiveCertification',
			'foreignKey' => 'contractor_id',
			'dependent'  => true,
		)
	);


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
		)
	);
  
  # TODO: function service_area_counties
  # TODO: function service_area_zip_codes
}
