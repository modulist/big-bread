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
  
  public $hasAndBelongsToMany = array(
    'Product' => array(
      'className'             => 'Product',
      'joinTable'             => 'building_products',
      'foreignKey'            => 'building_id',
      'associationForeignKey' => 'product_id',
    ),
  );
  
  public $actsAs = array(
    'Auditable' => array(
      'ignore'  => array( 'created', 'modified' ),
    )
  );
  
	public $validate = array(
    'year_built' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid year.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'finished_sf' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid square footage.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'stories_above_ground' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid number of stories.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'skylight_count' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid number of skylights.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'setpoint_heating' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid thermostat setting.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'setpoint_cooling' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid thermostat setting.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'window_percent_average' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid number of average windows.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'window_percent_small' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid number of small windows.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'window_percent_large' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid number of large windows.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'window_wall_sf' => array(
      'integer' => array(
        'rule'  => array( 'integer' ),
        'message' => 'Invalid square footage.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
    'window_wall_sf' => array(
      'numeric' => array(
        'rule'  => 'numeric',
        'message' => 'Invalid square footage.',
        'allowEmpty' => true,
        'required'   => false,
      )
    ),
  );
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Retrieves the relevant incentives (rebates) for a given building.
   *
   * @param 	$building_id
   * @return	array
   */
  public function incentives( $building_id ) {
    # Pull the incentives
    return $this->Address->ZipCode->incentives( $building_id, $this->zipcode( $building_id ) );
  }
  
  /**
   * Returns the zip code for a given building.
   *
   * @param 	$building_id
   * @return	string
   */
  public function zipcode( $building_id ) {
    $address = $this->Address->find(
      'first',
      array(
        'contain'    => array( 'Building' ),
        'fields'     => array( 'Address.zip_code' ),
        'conditions' => array( 'Building.id' => $building_id ),
      )
    );
    
    return $address['Address']['zip_code'];
  }
}
