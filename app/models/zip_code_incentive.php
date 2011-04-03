<?php

class ZipCodeIncentive extends AppModel {
	public $name = 'ZipCodeIncentive';
	public $useTable = 'incentive_zips';
	
	public $belongsTo = array(
		'Incentive' => array(
			'className'  => 'Incentive',
			'foreignKey' => false,  # actually 'incentive_id', but we need to fool Cake
			'conditions' => array( 'ZipCodeIncentive.incentive_id' => 'Incentive.incentive_id' ),
		),
		'ZipCode' => array(
			'className'  => 'ZipCode',
			'foreignKey' => 'zip',
		)
	);
}
