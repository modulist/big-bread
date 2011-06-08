<?php

class Technology extends AppModel {
	public $name         = 'Technology';
  
  public $hasOne = array(
    'GlossaryTerm' => array(
      'className'  => 'GlossaryTerm',
      'foreignKey' => 'foreign_key',
      'fields'     => array( 'GlossaryTerm.definition' ),
      'conditions' => array( 'GlossaryTerm.model' => 'Technology' ),
    ),
  );
  public $hasMany = array(
    'EnergySource' => array(
      'className'  => 'EnergySource',
      'foreignKey' => 'technology_id',
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
	public $hasAndBelongsToMany = array(
		'EquipmentManufacturer' => array(
			'className' => 'EquipmentManufacturer',
			'joinTable' => 'equipment_manufacturers_technologies',
			'foreignKey' => 'technology_id',
			'associationForeignKey' => 'equipment_manufacturer_id',
			'unique' => true,
		),
	);
}
