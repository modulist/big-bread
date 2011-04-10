<?php

class TechnologyOption extends AppModel {
	public $name         = 'TechnologyOption';
	public $useTable     = 'incentive_tech_option_type';
	public $primaryKey   = 'incentive_tech_option_type_id';
  
  public $hasAndBelongsToMany = array(
    'TechnologyIncentive' => array(
      'className'             => 'TechnologyIncentive',
      'joinTable'             => 'incentive_tech_option',
      'foreignKey'            => 'incentive_tech_option_type_id',
      'associationForeignKey' => 'technology_incentive_id',
    ),
  );
}
