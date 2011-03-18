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
    'ElectricityProvider' => array(
      'className' => 'Utility',
    ),
    'GasProvider' => array(
      'className' => 'Utility',
    ),
		'Occupant',
		'Questionnaire',
    'WaterProvider' => array(
      'className' => 'Utility',
    ),
  );
	public $hasMany = array(
    'BuildingProduct',
		'BuildingRoofSystem',
		'BuildingWindowSystem',
	);
  
	public $validate = array();
}
