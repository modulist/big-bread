<?php

class EnergySource extends AppModel {
	public $name = 'EnergySource';
	public $useTable = 'incentive_tech_energy_group';
	
	public $hasMany = array( 'Product' );
}
