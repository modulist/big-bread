<?php

class TechnologyOption extends AppModel {
	public $name         = 'TechnologyOption';
	public $useTable     = 'incentive_tech_option_type';
	public $primaryKey   = 'incentive_tech_option_type_id';
  
  public $hasOne = array(
    'GlossaryTerm' => array(
      'className'  => 'GlossaryTerm',
      'foreignKey' => 'foreign_key',
      'fields'     => array( 'GlossaryTerm.definition' ),
      'conditions' => array( 'GlossaryTerm.model' => 'TechnologyOption' ),
    ),
  );
  public $hasAndBelongsToMany = array(
    'TechnologyIncentive' => array(
      'className'             => 'TechnologyIncentive',
      'joinTable'             => 'incentive_tech_option',
      'foreignKey'            => 'incentive_tech_option_type_id',
      'associationForeignKey' => 'technology_incentive_id',
    ),
  );
}
