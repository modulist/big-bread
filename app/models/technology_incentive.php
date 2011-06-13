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
          'TechnologyOption' => array(
            'GlossaryTerm',
          ),
          'TechnologyTerm' => array(
            'GlossaryTerm',
          ),
          'Technology' => array(
            'GlossaryTerm',
          ),
        ),
        'conditions' => array(
          'TechnologyIncentive.id' => $id,
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
        ),
      )
    );
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
   */
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
}
