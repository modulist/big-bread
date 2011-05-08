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
   * Retrieves the relevant incentives for a given zip code.
   *
   * @param 	$zip
   * @return	array
   */
  public function by_zip( $building_id, $zip ) {
    # All kinds of non-standard db fields involved here.
    # $this->Behaviors->attach( 'Containable', array( 'autoFields' => false ) );
    
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
    # BEWARE: Crazy query follows. Lots of shit included.
    #
    
    # Pull the incentive details
    $incentives = $this->find(
      'all',
      array(
        'contain' => array(
          'EnergySource',
          'Incentive' => array(
            'PublicNote',
            'AdditionalIncentiveNote',
          ),
          'IncentiveAmountType',
          'TechnologyOption' => array(
            'GlossaryTerm',
          ),
          'TechnologyTerm',
          'Technology' => array(
            'GlossaryTerm',
            'Product' => array(
              'BuildingProduct' => array(
                'conditions' => array( 'BuildingProduct.building_id' => $building_id ),
              ),
            ),
          ),
        ),
        # Because we want the ordering to include a field that is 2
        # levels away (technology_groups.name), we have to join for
        # that table directly.
        'joins' => array(
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology2',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => array( 'TechnologyIncentive.technology_id = Technology2.id' ),
          ),
          array(
            'table'      => 'technology_groups', 
            'alias'      => 'TechnologyGroup', 
            'type'       => 'left', 
            'foreignKey' => false,
            'conditions' => array( 'Technology2.technology_group_id = TechnologyGroup.id' ),
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
