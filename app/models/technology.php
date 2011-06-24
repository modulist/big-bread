<?php

class Technology extends AppModel {
	public $name         = 'Technology';
  
  public $hasOne = array(
    'GlossaryTerm' => array(
      'className'  => 'GlossaryTerm',
      'foreignKey' => 'foreign_key',
      'fields'     => array( 'GlossaryTerm.definition' ),
      'conditions' => array( 'GlossaryTerm.model' => 'Technology' ),
    ),
  );
  public $hasMany = array(
    'EnergySource' => array(
      'className'  => 'EnergySource',
      'foreignKey' => 'technology_id',
    ),
    'Product',
    'TechnologyIncentive' => array(
      'className'  => 'TechnologyIncentive',
      'foreignKey' => 'incentive_tech_id',
      'conditions' => array( 'TechnologyIncentive.is_active' => 1 ),
    ),
  );
  public $belongsTo = array(
    'TechnologyGroup' => array(
      'className'  => 'TechnologyGroup',
    ),
  );
	public $hasAndBelongsToMany = array(
		'EquipmentManufacturer' => array(
			'className' => 'EquipmentManufacturer',
			'joinTable' => 'equipment_manufacturers_technologies',
			'foreignKey' => 'technology_id',
			'associationForeignKey' => 'equipment_manufacturer_id',
			'unique' => true,
		),
	);
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Retrieves the energy sources relevant to a given technology.
   *
   * @param 	$technology_id
   * @return	array
   * @access	public
   */
  public function energy_sources( $technology_id ) {
    return $this->EnergySource->find(
      'all',
      array(
        'contain'    => false,
        'fields'     => array( 'EnergySource.incentive_tech_energy_type_id', 'EnergySource.name' ),
        'conditions' => array( 'EnergySource.technology_id' => $technology_id ),
        'order'      => array( 'EnergySource.name' ),
      )
    );
  }
  
  /**
   * Retrieves a list of manufacturers for a given technology.
   *
   * @param 	$technology_ids
   * @param   $scope          Find type. first|all. If null, the
   *                          method attempts to be intelligent.
   * @return  array
   * @access	public
   */
  public function manufacturers( $technology_ids, $scope = null ) {
    if( !is_array( $technology_ids ) ) {
      $technology_ids = array( $technology_ids );
    }
    
    $cache_config = 'day';
    $cache_key    = 'Technology_manufacturers_' . join( '_', $technology_ids );
    
    $manufacturers = Cache::read( $cache_key, $cache_config );
    
    if( $manufacturers === false ) {
      if( empty( $scope ) ) {
        $scope = count( $technology_ids === 1 ) ? 'first' : 'all';
      }
      
      $manufacturers = $this->find(
        $scope,
        array(
          'contain' => array(
            'EquipmentManufacturer' => array( 'order' => 'EquipmentManufacturer.name')
          ),
          'conditions' => array( 'Technology.id' => $technology_ids ),
          'order'      => array( 'Technology.name' ),
        )
      );
      
      Cache::write( $cache_key, $manufacturers, $cache_config );
    }
    
    return $manufacturers;
  }
}
