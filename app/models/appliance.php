<?php

class Appliance extends AppModel {
	public $name = 'Appliance';
  
	public $hasMany   = array( 'BuildingAppliance' );
	public $belongsTo = array( 'ApplianceType', 'EnergySource' );
  
	public $validate = array(
		'appliance_type_id' => array(
			'notempty' => array(
				'rule' => array( 'notempty' ),
				'message' => 'Appliance Type cannot be empty',
				'allowEmpty' => false,
				'required' => true,
			),
		),
	);
}
