<?php

class Product extends AppModel {
	public $name = 'Product';
  
	public $hasMany   = array( 'BuildingProduct' );
	public $belongsTo = array(
    'Technology' => array(
      'fields'     => array( 'id', 'incentive_tech_group_id', 'name', 'description' ),
      'conditions' => array( 'Technology.questionnaire_product' => 1 ),
    ),
    'EnergySource' => array(
      'fields'     => array( 'id', 'incentive_tech_energy_group_id', 'name', 'description' ),
    ),
  );
}
