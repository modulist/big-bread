<?php

class Building extends AppModel {
	public $name = 'Building';
  
	public $belongsTo = array(
		'Address',
		'BasementType',
    'BuildingShape',
		'BuildingType',
		'ExposureType',
		'Client' => array(
			'className' => 'User',
			'foreignKey' => 'client_id'
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
  public $hasOne  = array(
    'BuildingWallSystem', # Built for hasMany, but currently implemented as hasOne
  );
	public $hasMany = array(
    'BuildingAppliance',
    'BuildingHotWaterSystem',
		'BuildingHvacSystem',
		'BuildingRoofSystem',
		'BuildingWindowSystem',
		'Occupant',
		'Survey',
	);
  
	public $validate = array();
}
