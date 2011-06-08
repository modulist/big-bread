<?php

class EquipmentManufacturer extends AppModel {
	public $name         = 'EquipmentManufacturer';
	public $displayField = 'name';
	
	public $hasMany = array(
		'Incentive',
	);
	public $hasAndBelongsToMany = array(
		'Technology' => array(
			'className' => 'Technology',
			'joinTable' => 'equipment_manufacturers_technologies',
			'foreignKey' => 'equipment_manufacturer_id',
			'associationForeignKey' => 'technology_id',
			'unique' => true,
		),
	);
}
