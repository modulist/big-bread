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
  
  public $actsAs = array(
    'Auditable' => array(
      'ignore'  => array( 'created', 'modified' ),
    )
  );
  
	public $validate = array();
  
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
    $address = $this->Address->find(
      'first',
      array(
        'contain'    => array( 'Building' ),
        'fields'     => array( 'Address.zip_code' ),
        'conditions' => array( 'Building.id' => $building_id ),
      )
    );
    
    # Pull the incentives
    return $this->Address->ZipCode->incentives( $this->zipcode( $building_id ) );
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
        'contain'    => array(
          'Building' => array(
            'conditions' => array( 'Building.id' => $building_id )
          )
        ),
        'fields'     => array( 'Address.zip_code' ),
      )
    );
    
    return $address['Address']['zip_code'];
  }
}
