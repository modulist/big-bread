<?php

class EnergySource extends AppModel {
	public $name       = 'EnergySource';
	public $useTable   = 'incentive_tech_energy_type';
	public $primaryKey = 'incentive_tech_energy_type_id';
	
	public $belongsTo = array(
    /** TODO: IncentiveTechEnergyGroup */
    'Technology' => array(
      'className'  => 'Technology',
      'foreignKey' => 'incentive_tech_id',
    )
	);

	public $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'energy_source_id',
		),
	);
  
  public $hasAndBelongsToMany = array(
    'TechnologyIncentive' => array(
      'className'             => 'TechnologyIncentive',
      'joinTable'             => 'incentive_tech_energy',
      'foreignKey'            => 'incentive_tech_energy_type_id',
      'associationForeignKey' => 'technology_incentive_id',
    ),
  );
}
