<?php

/** Uses the search_view */
class TechnologyIncentive extends AppModel {
	public $name     = 'TechnologyIncentive';
  
  public $belongsTo = array(
    'Incentive' => array(
      'className'  => 'Incentive',
      'type'       => 'inner',
    ),
    'IncentiveAmountType',
    'Technology' => array(
      'className'  => 'Technology',
      'type'       => 'inner',
    ),
  );
  
  public $hasAndBelongsToMany = array(
    'EnergySource' => array(
      'className'             => 'EnergySource',
      'joinTable'             => 'incentive_tech_energy',
      'foreignKey'            => 'technology_incentive_id',
      'associationForeignKey' => 'incentive_tech_energy_type_id',
    ),
    'TechnologyOption' => array(
      'className'             => 'TechnologyOption',
      'joinTable'             => 'incentive_tech_option',
      'foreignKey'            => 'technology_incentive_id',
      'associationForeignKey' => 'incentive_tech_option_type_id',
    ),
    'TechnologyTerm' => array(
      'className'             => 'TechnologyTerm',
      'joinTable'             => 'incentive_tech_term',
      'foreignKey'            => 'technology_incentive_id',
      'associationForeignKey' => 'incentive_tech_term_type_id',
    )
  );
  
  /**
   * Retrieves a specific technology incentive by its identifier along
   * with all of its relevant, associated data
   *
   * @param 	$id
   * @return	array
   * @access	public
   */
  public function get( $id ) {
    return $this->find(
      'first',
      array(
        'contain' => array(
          'EnergySource',
          'Incentive' => array(
            'AdditionalIncentiveNote',
            'IncentiveType',
            'PublicNote',
          ),
          'IncentiveAmountType',
          'Technology' => array(
            'TechnologyGroup',
          ),
          'TechnologyOption',
          'TechnologyTerm',
          'Technology',
        ),
        'conditions' => array(
          'TechnologyIncentive.id' => $id,
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
          'OR' => array(
            'Incentive.expiration_date' => null, 
            'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
          ),
        ),
      )
    );
  }
  
  /**
   * Retrieves a set of incentives for a given zip code. Optionally,
   * this list may be limited to a specific set of technologies.
   *
   * @param 	$zip_codes      mixed One or more zip codes to filter on
   * @param   $technology_ids mixed A technology id or array of technology ids
   * @param   $group          bool  Whether to include/group by the tech group
   * @return	array
   * @access	public
   */
  public function all( $zip_codes, $technology_ids = array(), $group = true ) {
    if( !is_array( $zip_codes ) ) {
      $zip_codes = array( $zip_codes );
    }
    if( !is_array( $technology_ids ) ) {
      $technology_ids = array( $technology_ids );
    }
    
    # Build a complete set of conditions based on the parameters
    $conditions = array(
      'Incentive.excluded' => 0,
      'TechnologyIncentive.is_active' => 1,
      # TODO: REMOVE COMMENTED CODE AFTER SIGNOFF
      # 'TechnologyGroup.display' => 1,
      # 'Technology.display' => 1,
      'OR' => array(
        'Incentive.expiration_date' => null, 
        'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
      ),
      'OR' => self::geo_scope_conditions( $zip_codes ),
    );
    
    if( !empty( $technology_ids ) ) {
      $conditions['Technology.id'] = $technology_ids;
    }
    
    # The order array will be affected by whether grouping is in play
    $order = array(
      'Technology.name',
      'TechnologyIncentive.amount DESC',
    );
    if( $group ) {
      array_unshift( $order, 'TechnologyGroup.display_order' );
    }
    
    $incentives = $this->find(
      'all',
      array(
        'contain' => false,
        'fields'  => array(
          'TechnologyGroup.id',
          'TechnologyGroup.title',
          'Technology.id',
          'Technology.name',
          'Technology.display',
          'Incentive.id',
          'Incentive.name',
          'Incentive.expiration_date',
          'TechnologyIncentive.id',
          'TechnologyIncentive.amount',
          'IncentiveAmountType.id',
          'IncentiveAmountType.incentive_amount_type_id',
          'IncentiveAmountType.name',
        ),
        'joins' => array(
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'TechnologyIncentive.technology_id = Technology.id' ),
          ),
          array(
            'table'      => 'technology_groups',
            'alias'      => 'TechnologyGroup',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'Technology.technology_group_id = TechnologyGroup.id' ),
          ),
          array(
            'table'      => 'incentive',
            'alias'      => 'Incentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'TechnologyIncentive.incentive_id = Incentive.id' ),
          ),
          array(
            'table'      => 'incentive_amount_types',
            'alias'      => 'IncentiveAmountType',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'TechnologyIncentive.incentive_amount_type_id = IncentiveAmountType.id' ),
          )
        ),
        'conditions' => $conditions,
        'order'      => $order,
      )
    );
    
    return $incentives;
  }
  
  /**
   * Pulls the details of a given incentive.
   *
   * @param 	$technology_incentive_id
   * @return	array
   * @access	public
   */
  static public function details( $technology_incentive_id ) {
    # TODO: implement.
    throw new Exception( 'TechnologyIncentive::details() has not be implemented.' );
    
    # TODO: Return appropriate value
    return array();
  }
  
  /**
   * Retrieves a list of incentives that are related to a given incentive.
   * "Related" means that the incentive is offered on the same technology
   * and, in the case of a manufacturer incentive, is not offered by a
   * competing manufacturer. For example, incentives related to a Trane
   * incentive will not include any offered by Carrier.
   *
   * Results are scoped by zip code.
   *
   * @param 	$technology_incentive mixed An id or a complete object
   * @param   $zip_code
   * @param   $manufacturer_id
   * @return	array
   * @access	public
   * @todo    Can we leverate TechnologyIncentive::all() in any way?
   */
  public function related( $technology_incentive, $zip_code, $manufacturer_id = null ) {
    if( !is_array( $technology_incentive ) && strlen( $technology_incentive === 36 ) ) {
      # It looks like a UUID value was passed, so we need to pull
      # source incentive.
      $technology_incentive = $this->get( $technology_incentive );
    }
    
    $incentive_join_conditions = array(
      'TechnologyIncentive.incentive_id = Incentive.id',
    );
    if( !empty( $manufacturer_id ) ) {
      # Only pull incentives that are not manufacturer specific or ones
      # that are specific to the specified manufacturer.
      $incentive_join_conditions['OR'] = array(
        'Incentive.incentive_type_id <> ' => 'MANU',
        array(
          'Incentive.incentive_type_id'         => 'MANU',
          'Incentive.equipment_manufacturer_id' => $manufacturer_id
        )
      );
    }
    
    $technology_join_conditions = array(
      'TechnologyIncentive.technology_id = Technology.id',
      'TechnologyIncentive.technology_id' => $technology_incentive['Technology']['id'],
    );
     
    $related = $this->find(
      'all',
      array(
        'contain' => array(
          'EnergySource' => array(
            'fields' => array( 'EnergySource.name' ), 
          ),
          'TechnologyOption' => array(
            'fields' => array( 'TechnologyOption.name' ),
          ),
          'TechnologyTerm',
        ),
        'joins' => array(
          array(
            'table'      => 'incentive',
            'alias'      => 'Incentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => $incentive_join_conditions,
          ),
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => $technology_join_conditions,
          ),
          array(
            'table'      => 'incentive_amount_types',
            'alias'      => 'IncentiveAmountType',
            'type'       => 'inner',
            'foreignKey' => false,
            'conditions' => array(
              'TechnologyIncentive.incentive_amount_type_id = IncentiveAmountType.id'
            ),
          ),
        ),
        'fields' => array(
          'TechnologyIncentive.id',
          'TechnologyIncentive.incentive_id',
          'TechnologyIncentive.technology_id',
          'TechnologyIncentive.amount',
          'TechnologyIncentive.is_active',
          
          'Incentive.incentive_id',
          'Incentive.incentive_type_id',
          'Incentive.name',
          'Incentive.expiration_date',
          'Incentive.equipment_manufacturer_id',
          'Incentive.excluded',
          
          'IncentiveAmountType.incentive_amount_type_id',
          'IncentiveAmountType.name',
        ),
        'conditions' => array(
          'NOT' => array( 'TechnologyIncentive.id' => $technology_incentive['TechnologyIncentive']['id'] ),
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
          'OR' => self::geo_scope_conditions( $zip_code ),
        ),
        'order' => array(
          'TechnologyIncentive.amount DESC',
          'Incentive.name',
        ),
      )
    );
    
    return $related;
  }
  
  /**
   * Retrieves all available incentives for a given building
   *
   * @param 	$zip          Rebates are available by zip code
   * @param   $building_id  Used to pull products installed in the
   *                        building, if included
   * @param   $conditions      Array of options for further limiting the results
   *          - technology_group_id         Filter by a specifiec tech group
   *          - technology_id               Filter by a specific technology
   *          - equipment_manufacturer_id   Filter by a specific manufacturer id
   *          - not                         An array of technology_incentive_ids to ignore
   * @return	array
   * @todo    REMOVE IN FAVOR OF TechnologyIncentive::all()
   */
  /* 
  public function incentives( $zip, $building_id = null, $conditions = array() ) {
    $default_conditions = array(
      'technology_group_id'       => null,
      'technology_id'             => null,
      'equipment_manufacturer_id' => null,
      'not'                       => null,
    );
    $conditions = array_merge( $default_conditions, $conditions );
    
    # Which state owns this zip code?
    $state = $this->Incentive->ZipCode->field( 'state', array( 'ZipCode.zip' => $zip ) );
    
    # Incentives specific to this zip
    $zip_code_incentives = $this->Incentive->ZipCodeIncentive->find(
      'all',
      array(
        'fields' => array( 'DISTINCT ZipCodeIncentive.incentive_id'),
        'conditions' => array( 'ZipCodeIncentive.zip' => $zip ),
      )
    );
    $zip_code_incentives = Set::extract( '/ZipCodeIncentive/incentive_id', $zip_code_incentives );
    
    #
    # BEWARE: Crazy query follows. Lots of shit going on up in here.
    #
    
    $contain = array(
      'EnergySource',
      'Incentive' => array(
        'AdditionalIncentiveNote',
        'IncentiveType',
        'PublicNote',
      ),
      'IncentiveAmountType',
      'TechnologyOption' => array(
        'GlossaryTerm',
      ),
      'TechnologyTerm' => array(
        'GlossaryTerm',
      ),
      'Technology' => array(
        'GlossaryTerm',
      ),
    );
    
    if( !empty( $building_id ) ) {
      # Only return equipment installed in the building
      $contain['Technology']['Product'] = array(
        'BuildingProduct' => array(
          'conditions' => array(
            'BuildingProduct.building_id' => $building_id,
            'BuildingProduct.service_out' => null
          ),
        )
      );
    }
    
    # Table join conditions
    $technology_group_conditions = array(
      'Technology2.technology_group_id = TechnologyGroup.id' # the table join
    );
    $technology_conditions = array(
      'TechnologyIncentive.technology_id = Technology2.id' # the table join
    );
    $incentive_type_conditions = array(
      'TechnologyIncentive.incentive_id = Incentive2.id',
    );
    
    # Limit by a particular technology, group or manufacturer, if applicable
    if( !empty( $conditions['technology_group_id'] ) ) {
      $technology_group_conditions['TechnologyGroup.id'] = $conditions['technology_group_id'];
    }
    if( !empty( $conditions['technology_id'] ) ) {
      $technology_conditions['Technology2.id'] = $conditions['technology_id'];
    }
    if( !empty( $conditions['equipment_manufacturer_id'] ) ) {
      # Only pull incentives that are not manufacturer specific or ones
      # that are specific to the specified manufacturer.
      $incentive_type_conditions = array(
        'OR' => array(
          'Incentive2.incentive_type_id <> ' => 'MANU',
          array(
            'Incentive2.incentive_type_id'         => 'MANU',
            'Incentive2.equipment_manufacturer_id' => $conditions['equipment_manufacturer_id']
          )
        )
      );
    }
    
    # Ignore specific technology incentives
    $ignore_list = array();
    if( !empty( $conditions['not'] ) ) {
      if( !is_array( $conditions['not'] ) ) {
        $conditions['not'] = array( $conditions['not'] );
      }
      
      $ignore_list = $conditions['not'];
    }
    
    $incentives = $this->find(
      'all',
      array(
        'contain' => $contain,
        # Because we want the ordering to include a field that is 2
        # levels away (technology_groups.name), we have to join for
        # that table directly.
        'joins' => array(
          array(
            'table'      => 'incentive',
            'alias'      => 'Incentive2',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => $incentive_type_conditions,
          ),
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology2',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => $technology_conditions,
          ),
          array(
            'table'      => 'technology_groups', 
            'alias'      => 'TechnologyGroup', 
            'type'       => 'left', 
            'foreignKey' => false,
            'conditions' => $technology_group_conditions,
          ),
        ),
        'fields' => array(
          'TechnologyIncentive.id',
          'TechnologyIncentive.incentive_id',
          'TechnologyIncentive.technology_id',
          'TechnologyIncentive.amount',
          'TechnologyIncentive.incentive_amount_type_id',
          'TechnologyIncentive.weblink',
          'TechnologyIncentive.rebate_link',
          'TechnologyIncentive.is_active',
          'TechnologyGroup.id',
          'TechnologyGroup.incentive_tech_group_id',
          'TechnologyGroup.title',
        ),
        'conditions' => array(
          'NOT' => array( 'TechnologyIncentive.id' => $ignore_list ),
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
          'OR' => array(
            'Incentive.state' => 'US',  # nationwide incentives
            array(
              # Incentives that apply to the entire state that owns the zip code
              'Incentive.entire_state' => 1,
              'Incentive.state'        => $state,
            ),
            array(
              # Incentive that belong to a given zip in the current state
              'Incentive.id' => $zip_code_incentives,
              'Incentive.state' => $state,
            ),
          ),
        ),
        'order' => array(
          'TechnologyGroup.name',
          'Technology.name',
          'TechnologyIncentive.amount DESC'
        ),
      )
    );
    
    return $incentives;
  }
  */
  
  /**
   * Returns the geographic scope conditions for a given zip code.
   * For example, results being pulled for 21224 should include
   * all incentives specifically tied to that zip code as well as
   * tied to the entire state and nationwide.
   *
   * The resulting array of conditions will have to be OR'd where
   * used. e.g. 'OR' => $this->geo_scope_conditions( $zip_code )
   *
   * @param 	$zip_codes  
   * @return	array       An array ready for use in find conditions
   * @access	public
   */
  static public function geo_scope_conditions( $zip_codes ) {
    if( !is_array( $zip_codes ) ) {
      $zip_codes = array( $zip_codes );
    }
    
    $Incentive = ClassRegistry::init( 'Incentive' );
    
    # Which state owns this zip code?
    $state = $Incentive->ZipCode->field( 'state', array( 'ZipCode.zip' => $zip_codes ) );
    
    # Which incentives are specific to this zip
    $zip_code_incentives = $Incentive->ZipCodeIncentive->find(
      'all',
      array(
        'fields' => array( 'DISTINCT ZipCodeIncentive.incentive_id'),
        'conditions' => array( 'ZipCodeIncentive.zip' => $zip_codes ),
      )
    );
    # Formatted in a nicely indexed array
    $zip_code_incentives = Set::extract( '/ZipCodeIncentive/incentive_id', $zip_code_incentives );
    
    return array(
      'Incentive.state' => 'US',  # nationwide incentives
      array(
        # Incentives that apply to the entire state that owns the zip code
        'Incentive.entire_state' => 1,
        'Incentive.state'        => $state,
      ),
      array(
        # Incentive that belong to a given zip in the current state
        'Incentive.id' => $zip_code_incentives,
        'Incentive.state' => $state,
      ),
    );
  }
}
