<?php

class IncentiveType extends AppModel {
	public $name         = 'IncentiveType';
	public $useTable     = 'incentive_type';
	public $primaryKey   = 'incentive_type_id';
	public $displayField = 'listname';
	
	public $hasMany = array(
		'Incentive' => array(
			'className' => 'Incentive',
			'foreignKey' => 'incentive_type_id',
		),
	);
}
