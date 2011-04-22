<?php

class IncentiveAmountType extends AppModel {
	public $name = 'IncentiveAmountType';
	public $displayField = 'name';
	
	public $hasMany = array(
		'TechnologyIncentive',
	);
}
