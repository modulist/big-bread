<?php

class Technology extends AppModel {
	public $name         = 'Technology';
	public $useTable     = 'incentive_tech';
  public $primaryKey   = 'incentive_tech_id';
  
  public $hasMany = array(
    'EnergySource' => array(
      'className'  => 'EnergySource',
      'foreignKey' => 'incentive_tech_id',
    ),
    'Product',
    'TechnologyIncentive' => array(
      'className'  => 'TechnologyIncentive',
      'foreignKey' => 'incentive_tech_id',
      'conditions' => array( 'TechnologyIncentive.is_active' => 1 ),
    ),
  );
  public $belongsTo = array(
    'TechnologyGroup' => array(
      'className'  => 'TechnologyGroup',
      'foreignKey' => false,
      'conditions' => array( 'Technology.incentive_tech_group_id = TechnologyGroup.incentive_tech_group_id' ),
    ),
  );
}
