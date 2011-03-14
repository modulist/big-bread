<?php

class Utility extends AppModel {
	public $name        = 'Utility';
	public $useTable    = 'utility';
	
  public $hasMany = array( 'ZipCodeUtility' );
}
