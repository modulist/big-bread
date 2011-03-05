<?php

class Building extends AppModel {
	public $name = 'Building';
	public $validate = array();
  
	public $belongsTo = array(
		'Address',
		'BasementType',
    'BuildingShape',
		'BuildingType',
		'ExposureType',
		'Homeowner' => array(
			'className' => 'User',
			'foreignKey' => 'homeowner_id'
		),
		'Inspector' => array(
			'className' => 'User',
			'foreignKey' => 'inspector_id'
		),
    'MaintenanceLevel',
		'Realtor' => array(
			'className' => 'User',
			'foreignKey' => 'realtor_id'
		),
		'ShadingType',
	);

	public $hasMany = array(
    'BuildingAppliance',
    'BuildingHotWaterSystem',
		'BuildingHvacSystem',
		'BuildingRoofSystem',
		'BuildingWallSystem',
		'BuildingWindowSystem',
		'Occupant',
		'Survey',
	);
}