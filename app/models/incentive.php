<?php

class Incentive extends AppModel {
	public $name       = 'Incentive';
	public $useTable   = 'incentive';
  
  public $belongsTo = array(
    'IncentiveType',
    'EquipmentManufacturer',
  );
  public $hasMany = array(
    'IncentiveNote' => array(
      'className'  => 'IncentiveNote',
      'conditions' => array( 'IncentiveNote.incentive_note_type_id' => array( 'PUB', 'AIN' ) )
    ),
    'PublicNote' => array(
      'className'  => 'IncentiveNote',
      'conditions' => array( 'PublicNote.incentive_note_type_id' => 'PUB' )
    ),
    'AdditionalIncentiveNote' => array(
      'className'  => 'IncentiveNote',
      'conditions' => array( 'AdditionalIncentiveNote.incentive_note_type_id' => 'AIN' )
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
