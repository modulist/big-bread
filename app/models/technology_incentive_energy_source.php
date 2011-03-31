<?php

class TechnologyIncentiveEnergySource extends AppModel {
	public $name     = 'TechnologyIncentiveEnergySource';
	public $useTable = 'incentive_tech_energy';
	
	public $belongsTo = array(
		'TechnologyIncentive' => array(
			'className' => 'TechnologyIncentive',
			'foreignKey' => 'incentive__incentive_tech_id',
		),
		'EnergySource' => array(
			'className' => 'EnergySource',
			'foreignKey' => 'incentive_tech_energy_type_id',
		),
	);
}
