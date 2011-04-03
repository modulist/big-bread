<?php

class IncentiveAmountType extends AppModel {
	public $name = 'IncentiveAmountType';
	public $useTable = 'incentive_amount_type';
	public $primaryKey = 'incentive_amount_type_id';
	public $displayField = 'name';
	
	public $hasMany = array(
		'TechnologyIncentive' => array(
			'className' => 'TechnologyIncentive',
			'foreignKey' => false,
      'conditions' => array( 'IncentiveAmountType.incentive_amount_type_id = TechnologyIncentive.incentive_amount_type_id' )
		)
	);
}
