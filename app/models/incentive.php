<?php

class Incentive extends AppModel {
	public $name       = 'Incentive';
	public $useTable   = 'incentive';
  public $primarykey = 'incentive_id';
  
  public $hasMany = array(
    /** TODO: Note */
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
