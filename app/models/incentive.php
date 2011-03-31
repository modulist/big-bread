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
  );
  
  public $hasAndBelongsToMany = array(
    'ZipCode' => array(
      'className'             => 'ZipCode',
      'joinTable'             => 'incentive_zip',
      'foreignKey'            => 'incentive_id',
      'associationForeignKey' => 'zip',
    ),
    'Utility' => array(
      'className'             => 'Utility',
      'joinTable'             => 'incentive_utility',
      'foreignKey'            => 'incentive_id',
      'associationForeignKey' => 'utility_id',
    ),
  );
}
