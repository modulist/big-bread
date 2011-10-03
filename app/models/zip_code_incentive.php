<?php

class ZipCodeIncentive extends AppModel {
	public $name = 'ZipCodeIncentive';
	public $useTable = 'incentive_zips';
	
	public $belongsTo = array(
		'Incentive' => array(
			'className'  => 'Incentive',
			'foreignKey' => false,
			'conditions' => array( 'ZipCodeIncentive.incentive_id' => 'Incentive.incentive_id' ),
		),
		'ZipCode' => array(
			'className'  => 'ZipCode',
			'foreignKey' => 'zip',
		)
	);
}
