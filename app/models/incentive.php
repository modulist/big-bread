<?php

class Incentive extends AppModel {
	public $name       = 'Incentive';
	public $useTable   = 'incentive';
  
  public $hasMany = array(
    'IncentiveNote' => array(
      'className'  => 'IncentiveNote',
      'conditions' => array( 'IncentiveNote.incentive_note_type_id' => array( 'PUB', 'AIN' ) )
    ),
    'TechnologyIncentive' => array(
      'className'  => 'TechnologyIncentive',
      'conditions' => array( 'TechnologyIncentive.is_active' => 1 ),
    ),
		'ZipCodeIncentive' => array(
			'className' => 'ZipCodeIncentive',
			'foreignKey' => 'incentive_id',
		)
  );
  
  public $hasAndBelongsToMany = array(
    'ZipCode' => array(
      'className' => 'ZipCode',
      'with'      => 'ZipCodeIncentive',
    ),
    'Utility' => array(
      'className' => 'Utility',
      'with'      => 'ZipCodeUtility',
    ),
  );
}
