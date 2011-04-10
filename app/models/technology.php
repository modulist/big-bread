<?php

class Technology extends AppModel {
	public $name         = 'Technology';
  
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
    ),
  );
}
