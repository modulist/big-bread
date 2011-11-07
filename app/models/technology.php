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
    'Fixture',
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
   * Returns a list of technology groups that have at least one watchable
   * technology.
   *
   * @return  array
   * @access  public
   */
  public function grouped() {
    $technologies = $this->TechnologyGroup->find(
      'all',
      array(
        'contain' => false,
        'conditions' => array(
          'Technology.watchable' => 1,
        ),
        'joins'   => array(
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'TechnologyGroup.id = Technology.technology_group_id' ),
          ),
        ),
        'fields'  => array(
          'TechnologyGroup.id',
          'TechnologyGroup.title',
          'TechnologyGroup.display_order',
          'Technology.id',
          'Technology.name',
          'Technology.title',
        ),
        'order'   => array(
          'TechnologyGroup.display_order',
          'Technology.name',
        ),
      )
    );
    
    $grouped = array();
    foreach( $technologies as $i => $technology ) {
      if( !isset( $grouped[$technology['TechnologyGroup']['title']] ) ) {
        $grouped[$technology['TechnologyGroup']['title']] = array();
      }
      
      array_push( $grouped[$technology['TechnologyGroup']['title']], $technology );
    }
    
    # new PHPDump( $grouped, 'Grouped', '', true );
    
    return $grouped;
  }
  
  /**
   * Retrieves incentive information for a given technology and a
   * given zip code.
   *
   * @param 	$technology_id mixed  A single id or an array of ids.
   * @param   $zip_code
   * @return	array
   * @access	public
   */
  public function incentives( $technology_id, $zip_code ) {
    return $this->TechnologyIncentive->all( $zip_code, $technology_id );
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
    
    if( empty( $scope ) ) {
      $scope = count( $technology_ids === 1 ) ? 'first' : 'all';
    }
    
    $cache_config = 'day';
    $cache_key    = strtolower( 'technology_manufacturers_' . $scope . '_' . join( '_', $technology_ids ) );
    
    $manufacturers = Cache::read( $cache_key, $cache_config );
    
    if( $manufacturers === false ) {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{Technology::manufacturers} Running query for manufacturers (cache key: ' . $cache_key .  ')', LOG_DEBUG );
      
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
    else {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{Technology::manufacturers} Pulling manufacturer data from cache (cache key: ' . $cache_key .  ')', LOG_DEBUG );
    }
    
    return $manufacturers;
  }
}
