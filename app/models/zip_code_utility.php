<?php

class ZipCodeUtility extends AppModel {
	public $name       = 'ZipCodeUtility';
	public $useTable   = 'utility_zip';
	
  public $belongsTo = array(
		'ZipCode' => array(
			'foreignKey' => 'zip'
		),
    'Utility' => array(
      'foreignKey' => 'utility_id'
    ),
	);
  
  public $types = array(
    'ELE' => 'Electric Provider',
    'GAS' => 'Gas Provider'
  );
}
