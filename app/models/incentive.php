<?php

class Incentive extends AppModel {
	public $name     = 'Incentive';
	public $useTable = 'search_view';
  
  public $hasMany = array(
    # 'ZipCodeIncentive' => array( 'foreignKey' => 'incentive_id' ),
  );
  public $hasAndBelongsToMany = array(
    'ZipCode' => array(
      'className'             => 'ZipCode',
      'joinTable'             => 'incentive_zip',
      'with'                  => 'ZipCodeIncentive',
      'foreignKey'            => 'incentive_id',
      'associationForeignKey' => 'zip',
    ),
  );
}
