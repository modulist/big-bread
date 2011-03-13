<?php

class Utility extends AppModel {
	public $name        = 'Utility';
	public $useTable    = 'utility';
  public $primaryKey  = 'utility_id'; # TODO: Update the data to use the new id value
	
  public $hasMany = array(
		'ZipCodeUtility' => array(
			'foreignKey' => 'utility_id'
		),  
	);
}
