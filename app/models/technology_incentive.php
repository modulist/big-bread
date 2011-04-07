<?php

/** Uses the search_view */
class TechnologyIncentive extends AppModel {
	public $name     = 'TechnologyIncentive';
	public $useTable = 'incentive__incentive_tech';
  
  public $hasMany = array(
    // TODO: TechnologyTerm
  );
  public $belongsTo = array(
    'Incentive' => array(
      'className'  => 'Incentive',
      'type'       => 'inner',
      'foreignKey' => false, # actually 'incentive_id', but we need to fool Cake
			'conditions' => array(
        'TechnologyIncentive.incentive_id = Incentive.incentive_id',
      ),
    ),
    'IncentiveAmountType' => array(
      'className'  => 'IncentiveAmountType',
      'foreignKey' => false,
      'conditions' => array( 'TechnologyIncentive.incentive_amount_type_id = IncentiveAmountType.incentive_amount_type_id' ),
    ),
    'Technology' => array(
      'className'  => 'Technology',
      'type'       => 'inner',
      'foreignKey' => false, # actually 'incentive_tech_id', but we need to fool Cake
      'conditions' => array(
        'TechnologyIncentive.incentive_tech_id = Technology.incentive_tech_id',
      )
    ),
  );
  
  public $hasAndBelongsToMany = array(
    'EnergySource' => array(
      'className'             => 'EnergySource',
      'joinTable'             => 'incentive_tech_energy',
      'foreignKey'            => 'incentive__incentive_tech_id',
      'associationForeignKey' => 'incentive_tech_energy_type_id',
    ),
    'TechnologyOption' => array(
      'className'             => 'TechnologyOption',
      'joinTable'             => 'incentive_tech_option',
      'foreignKey'            => 'incentive__incentive_tech_id',
      'associationForeignKey' => 'incentive_tech_option_type_id',
    )
  );
  

  /**
   * Retrieves the relevant incentives for a given zip code.
   *
   * @param 	$zip
   * @return	array
   */
  public function by_zip( $zip ) {
    /** 
    $es = $this->find( 'all', array(
      'conditions' => array( 'TechnologyIncentive.id' => 11703 ),
    ) ); */
    
    # All kinds of non-standard db fields involved here.
    $this->Behaviors->attach( 'Containable', array( 'autoFields' => false ) );
    
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

    # Pull the incentive details
    $incentives = $this->find(
      'all',
      array(
        'contain' => array(
          'Incentive',
          'IncentiveAmountType',
        ),
        # Containable botched things, so this is a workaround
        # @see http://stackoverflow.com/questions/5529793/containable-behavior-issue-with-non-standard-keys
        'joins' => array(
          array(
            'table'      => 'incentive_tech', 
            'alias'      => 'Technology', 
            'type'       => 'inner', 
            'foreignKey' => false, 
            'conditions' => array(
              'TechnologyIncentive.incentive_tech_id = Technology.incentive_tech_id',
            ),
          ),
          array(
            'table'      => 'incentive_tech_group', 
            'alias'      => 'TechnologyGroup', 
            'type'       => 'left', 
            'foreignKey' => false, 
            'conditions' => array(
              'Technology.incentive_tech_group_id = TechnologyGroup.incentive_tech_group_id',
            ),
          ),
        ),
        'fields' => array(
          'Incentive.incentive_id',
          'Incentive.name',
          'Incentive.category',
          'Incentive.expiration_date',
          'IncentiveAmountType.incentive_amount_type_id',
          'IncentiveAmountType.name',
          'IncentiveAmountType.description',
          'Technology.incentive_tech_id',
          'Technology.name',
          'Technology.description',
          'TechnologyIncentive.id',
          'TechnologyIncentive.incentive_id',
          'TechnologyIncentive.incentive_tech_id',
          'TechnologyIncentive.amount',
          'TechnologyIncentive.incentive_amount_type_id',
          'TechnologyIncentive.weblink',
          'TechnologyIncentive.rebate_link',
          'TechnologyGroup.name',
          # 'TechnologyOption.name',
          # Filter fields included for validation purposes
          'Incentive.state',
          'Incentive.entire_state',
          'Incentive.excluded',
          'TechnologyIncentive.is_active',
        ),
        'conditions' => array(
          'Incentive.excluded' => 0,
          'OR' => array(
            'Incentive.state' => 'US',  # nationwide incentives
            array(
              # Incentives that apply to the entire state that owns the zip code
              'Incentive.entire_state' => 1,
              'Incentive.state'        => $state,
            ),
            'Incentive.incentive_id' => $zip_code_incentives
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
    
    new PHPDump( $incentives, 'Full Incentives (' . count( $incentives ) . ')' );
    
    $log = $this->getDataSource()->getLog(false, false);
    new PHPDump( $log, 'LOG' ); exit;
    
    return $incentives;
  }
}
