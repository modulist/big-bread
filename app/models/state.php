<?php

class state extends AppModel {
	public $name         = 'state';
	public $useTable     = 'us_states';
	public $primaryKey   = 'code';
	public $displayField = 'state';
	
	public $hasMany = array( 'Address' );
}
