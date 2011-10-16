<?php

class Building extends AppModel {
	public $name = 'Building';
	public $belongsTo = array(
		'Client' => array(
			'className' => 'User',
			'foreignKey' => 'client_id'
		),
    'ElectricityProvider' => array(
      'className' => 'Utility',
      'fields'    => array( 'id', 'name' ),
    ),
    'GasProvider' => array(
      'className' => 'Utility',
      'fields'    => array( 'id', 'name' ),
    ),
		'Inspector' => array(
			'className' => 'User',
			'foreignKey' => 'inspector_id'
		),
		'Realtor' => array(
			'className' => 'User',
			'foreignKey' => 'realtor_id'
		),
    'WaterProvider' => array(
      'className' => 'Utility',
      'fields'    => array( 'id', 'name' ),
    ),
	);
  public $hasOne  = array(
    'Address' => array(
      'className'  => 'Address',
      'foreignKey' => 'foreign_key',
      'conditions' => array( 'Address.model' => 'Building' ),
      'dependent'  => true,
    ),
  );
	public $hasMany = array(
    'Fixture' => array(
      'dependent' => true,
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
   * CALLBACK METHODS
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
   * @param 	$zip_code
   * @param   $technology_ids
   * @param   $conditions   Array of conditions to forward along
   * @return	array
   */
  public function incentives( $zip_code, $technology_ids = array() ) {
    return $this->Address->ZipCode->Incentive->TechnologyIncentive->all( $zip_code, $technology_ids );
  }
  
  /**
   * Returns the address for a given building.
   *
   * @param 	$location_id
   * @param   $include_location Whether to include the location model data
   * @return	string
   */
  public function address( $location_id, $include_location = false ) {
    $address = $this->find(
      'first',
      array(
        'contain' => array(
          'Address' => array(
            'ZipCode'
          ),
        ),
        'conditions' => array( 'Building.id' => $location_id ),
      )
    );
    
    if( !$include_location ) {
      # The building is only included for filtering
      unset( $address['Building'] );
    }
    
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
      'Fixture.building_id' => $building_id,
      'Fixture.service_out' => null,
    );
    
    # Optionally filter for a equipment of a specific technology
    if( !empty( $technology_id ) ) {
      $conditions['Fixture.technology_id'] = $technology_id;
    }
    
    return $this->Fixture->find(
      'all',
      array(
        'contain'    => array( 'Fixture' => array( 'Technology' ) ),
        'conditions' => $conditions,
      )
    );
  }
}
