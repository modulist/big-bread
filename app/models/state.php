<?php

class State extends AppModel {
	public $name         = 'State';
	public $useTable     = 'us_states';
	public $primaryKey   = 'code';
	public $displayField = 'state';
	
  public $belongsTo = array(
    'ZipCode' => array(
      'foreignKey' => 'state',
    ),
  );
}
