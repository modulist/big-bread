<?php

class TechnologyIncentive extends AppModel {
	public $name       = 'TechnologyIncentive';
	public $useTable   = 'incentive__incentive_tech';
  
  public $hasMany = array(
    // TODO: TechnologyTerm
    'TechnologyIncentiveEnergySource' => array(
      'className'  => 'TechnologyIncentiveEnergySource',
      'foreignKey' => 'incentive__incentive_tech_id',
    ),
  );
  public $belongsTo = array(
    /** TODO: IncentiveAmountType */
    'Incentive' => array(
      'className'  => 'Incentive',
      'foreignKey' => 'incentive_id',
      'type'       => 'inner',
      'conditions' => array( 'Incentive.excluded' => 0 ),
    ),
    'Technology' => array(
      'className'  => 'Technology',
      'foreignKey' => 'incentive_tech_id',
      'type'       => 'inner',
    ),
  );
  
  public $hasAndBelongsToMany = array(
    'EnergySource' => array(
      'className'             => 'EnergySource',
      'with'                  => 'TechnologyIncentiveEnergySource',
      'joinTable'             => 'incentive_tech_energy',
      'foreignKey'            => 'incentive__incentive_tech_id',
      'associationForeignKey' => 'incentive_tech_energy_type_id',
    ),
  );
  

  /**
   * Retrieves the relevant incentives for a given zip code.
   *
   * @param 	$zip
   * @return	array
   */
  public function by_zip( $zip ) {
    # Which state owns this zip code?
    $state = $this->Incentive->ZipCode->field( 'state', array( 'ZipCode.zip' => $zip ) );
    
    # Pull the incentives
    $incentives = $this->find(
      'all',
      array(
        'contain' => array(
          'TechnologyIncentiveEnergySource',
          # 'EnergySource',
          'Incentive'  => array(
            'fields' => array( 'Incentive.id', 'Incentive.incentive_id', 'Incentive.category', 'Incentive.state', 'Incentive.entire_state', 'Incentive.excluded' ),
            'Utility' => array(
              'fields' => array( 'Utility.name' ),
            ),
            'ZipCode' => array(
              'fields' => array( 'zip' ),
              'conditions' => array( 'ZipCode.zip' => $zip ),
            ),
          ),
          'Technology' => array(
            'fields' => array( 'Technology.incentive_tech_id', 'Technology.incentive_tech_group_id', 'Technology.name' ),
            'TechnologyGroup' => array(
              'fields' => array( 'TechnologyGroup.incentive_tech_group_id', 'TechnologyGroup.name' ),
            ),
          ),
        ),
        'fields' => array(
          # 'Incentive.energy_group', MUST BE JOINED
          'TechnologyIncentive.id',
          'TechnologyIncentive.incentive_tech_id',
          'TechnologyIncentive.incentive_id',
          'TechnologyIncentive.amount',
          'TechnologyIncentive.weblink',
          'TechnologyIncentive.rebate_link',
          'TechnologyIncentive.is_active',
        ),
        'conditions' => array(
          'OR' => array(
            'Incentive.state' => 'US',  # nationwide incentives
            array(
              # Incentives that apply to the entire state that owns the zip code
              'Incentive.entire_state' => 1,
              'Incentive.state'        => $state,
            ),
            # 'ZipCodeIncentive.zip' => $zip
          ),
        ),
        'order' => array( 'TechnologyIncentive.amount DESC' ),
        # 'limit' => 25,
      )
    );
    
    /** use Set to sort stuff better? */
    
    foreach( $incentives as $incentive ) {
      # echo '<p>' .  . '</p>';
    }
    
    new PHPDump( $incentives, 'Incentives (' . count( $incentives ) . ')' );
    
    $log = $this->getDataSource()->getLog(false, false);
    new PHPDump( $log, 'LOG' ); exit;
    
    return $incentives;
  }
}
