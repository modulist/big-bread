<?php

class Building extends AppModel {
	public $name = 'Building';
	public $belongsTo = array(
		'BasementType',
    'BuildingShape',
		'BuildingType',
		'Client' => array(
			'className' => 'User',
			'foreignKey' => 'client_id'
		),
		'ExposureType',
    'ElectricityProvider' => array(
      'className' => 'Utility',
    ),
    'GasProvider' => array(
      'className' => 'Utility',
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
    'WaterProvider' => array(
      'className' => 'Utility',
    ),
	);
  public $hasOne  = array(
    'Address' => array(
      'className'  => 'Address',
      'foreignKey' => 'foreign_key',
      'conditions' => array( 'Address.model' => 'Building' ),
      'dependent'  => true,
    ),
    'BuildingWallSystem' => array( # Built for hasMany, but currently implemented as hasOne
      'dependent' => true,
    ), 
		'Occupant' => array(
      'dependent' => true,
    ),
  );
	public $hasMany = array(
    'BuildingProduct' => array(
      'dependent' => true,
    ),
		'BuildingRoofSystem' => array(
      'dependent' => true,
    ),
		'BuildingWindowSystem' => array(
      'dependent' => true,
    ),
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
    'AuditLog.Auditable',
  );
  
	public $validate = array(
    'name' => array(
      'notEmpty' => array(
        'rule'       => 'notEmpty',
        'message'    => 'Give this location a name.',
        'allowEmpty' => false,
        'required'   => true,
      ),
    ),
    'client_id'  => array(
      'notEmpty' => array(
        'rule'       => 'notEmpty',
        'message'    => 'A building must be created on behalf of a client.',
        'allowEmpty' => false,
        'required'   => true,
      )
    ),
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
   * OVERRIDES
   */
  
  /**
   * Overrides Model::saveAll()
   */
  public function saveAll( $data = null, $options = array() ) {
    # The address model is polymorphic, so when saving multiple
    # models, ensure that the proper polymorphic model value is
    # set.
    if( isset( $data['Address'] ) && !isset( $data['Address']['model'] ) ) {
      $data['Address']['model'] = $this->alias;
    }
    
    return parent::saveAll( $data, $options );
  }
  
  /**
   * CALLBACKS
   */
  
  
  /**
   * PUBLIC METHODS
   */
  
  public function __construct( $id = false, $table = null, $ds = null ) {
    parent::__construct( $id, $table, $ds );
    
    # Generate a whitelist that doesn't require me to make an update every time
    # I add a property...unless I don't want that property to be batch updated.
    $this->whitelist = array_diff( array_keys( $this->schema() ), array( 'id', 'deleted', 'created', 'modified' ) );
  }
  
  /**
   * Determines whether a given user is associated with a given building.
   *
   * @param 	$building_id
   * @return	boolean
   * @access	public
   */
  public function belongs_to( $building_id, $user_id ) {
    $conditions = array( 'Building.id' => $building_id, );
    
    if( !User::admin( $user_id ) ) {
      $conditions['OR'] = array(
        'Building.client_id'    => $user_id,
        'Building.realtor_id'   => $user_id,
        'Building.inspector_id' => $user_id,
      );
    }
    
    return $this->find(
      'count',
      array(
        'contain'    => false,
        'conditions' => $conditions,
      )
    );
  }
  
  /**
   * Retrieves the relevant incentives (rebates) for a given building.
   *
   * @param 	$building_id
   * @param   $conditions   Array of conditions to forward along
   * @return	array
   */
  public function incentives( $building_id, $conditions = array() ) {
    return $this->Address->ZipCode->Incentive->TechnologyIncentive->incentives( $this->zip_code( $building_id ), $building_id, $conditions );
  }
  
  /**
   * Returns the address for a given building.
   *
   * @param 	$building_id
   * @return	string
   */
  public function address( $building_id ) {
    $address = $this->Address->find(
      'first',
      array(
        'contain'    => array( 'Building', 'ZipCode' ),
        'conditions' => array( 'Building.id' => $building_id ),
      )
    );
    
    # The building is only included for filtering
    unset( $address['Building'] );
    
    return $address;
  }
  
  /**
   * Returns the zip code for a given building.
   *
   * @param 	$building_id
   * @return	string
   */
  public function zip_code( $building_id ) {
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
  
  /**
   * Returns all equipment installed in the building.
   *
   * @param 	$building_id
   * @return	array
   * @access	public
   */
  public function equipment( $building_id, $technology_id = null ) {
    $conditions = array(
      'BuildingProduct.building_id' => $building_id,
      'BuildingProduct.service_out' => null,
    );
    
    # Optionally filter for a equipment of a specific technology
    if( !empty( $technology_id ) ) {
      $conditions['Product.technology_id'] = $technology_id;
    }
    
    return $this->BuildingProduct->find(
      'all',
      array(
        'contain'    => array( 'Product' => array( 'Technology' ) ),
        'conditions' => $conditions,
      )
    );
  }
}
