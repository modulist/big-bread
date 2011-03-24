<?php

class ZipCodeIncentive extends AppModel {
	public $name     = 'ZipCodeIncentive';
	public $useTable = 'incentive_zip';
  
	public $belongsTo = array(
		'Incentive' => array( 'foreignKey' => 'incentive_id' ),
		'ZipCode'   => array( 'foreignKey' => 'zip' ),
	);
}
