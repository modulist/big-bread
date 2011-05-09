<?php

class TechnologyTerm extends AppModel {
	public $name         = 'TechnologyTerm';
	public $useTable     = 'incentive_tech_term_type';
	public $primaryKey   = 'incentive_tech_term_type_id';
  
  public $hasOne = array(
    'GlossaryTerm' => array(
      'className'  => 'GlossaryTerm',
      'foreignKey' => 'foreign_key',
      'fields'     => array( 'GlossaryTerm.definition' ),
      'conditions' => array( 'GlossaryTerm.model' => 'TechnologyTerm' ),
    ),
  );
  public $hasAndBelongsToMany = array(
    'TechnologyIncentive' => array(
      'className'             => 'TechnologyIncentive',
      'joinTable'             => 'incentive_tech_term',
      'foreignKey'            => 'incentive_tech_term_type_id',
      'associationForeignKey' => 'technology_incentive_id',
    ),
  );
}
