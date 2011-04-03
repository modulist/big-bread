<?php

class TechnologyGroup extends AppModel {
	public $name       = 'TechnologyGroup';
	public $useTable   = 'incentive_tech_group';
	public $primaryKey = 'incentive_tech_group_id';
	
	public $hasMany = array(
		'Technology' => array(
			'className'  => 'Technology',
			'foreignKey' => false,
      'conditions' => array( 'TechnologyGroup.incentive_tech_group_id' => 'Technology.incentive_tech_group_id' ),
		),
	);
}
