<?php

class Technology extends AppModel {
	public $name         = 'Technology';
	public $useTable     = 'incentive_tech';
  
  public $hasMany = array(
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
      'foreignKey' => 'incentive_tech_group_id',
    ),
  );
}
