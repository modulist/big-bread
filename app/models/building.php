<?php

class Building extends AppModel {
	public $name = 'Building';
	public $validate = array();
  
	public $belongsTo = array(
		'BuildingType',
		'Address',
		'Realtor' => array(
			'className' => 'User',
			'foreignKey' => 'realtor_id'
		),
		'Inspector' => array(
			'className' => 'User',
			'foreignKey' => 'inspector_id'
		),
		'Homeowner' => array(
			'className' => 'User',
			'foreignKey' => 'homeowner_id'
		),
		'BasementType',
		'ShadingType',
		'InfiltrationType',
		'ExposureType'
	);

	public $hasMany = array(
    'BuildingAppliance',
    'BuildingHotWaterSystem',
		'BuildingHvacSystem',
		'BuildingRoofSystem',
		'BuildingWallSystem',
		'BuildingWindowSystem',
		'Occupant',
		'Survey'
	);
}
