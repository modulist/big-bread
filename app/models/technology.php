<?php

class Technology extends AppModel {
	public $name         = 'Technology';
	public $useTable     = 'incentive_tech';
  
  public $hasMany = array( 'Product' );
}
