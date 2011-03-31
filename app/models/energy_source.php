<?php

class EnergySource extends AppModel {
	public $name       = 'EnergySource';
	public $useTable   = 'incentive_tech_energy_type';
	public $primaryKey = 'incentive_tech_energy_type_id';
	
	public $belongsTo = array(
    /** TODO: IncentiveTechEnergyGroup */
	);

	public $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'energy_source_id',
		),/**
    'TechnologyIncentiveEnergySource' => array(
      'className'  => 'TechnologyIncentiveEnergySource',
      'foreignKey' => 'incentive_tech_energy_type_id'
    ), */
	);
  
  public $hasAndBelongsToMany = array(
    'TechnologyIncentive' => array(
      'className' => 'TechnologyIncentive',
      'with'      => 'TechnologyIncentiveEnergySource',
    ),
  );
}
