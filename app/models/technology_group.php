<?php

class TechnologyGroup extends AppModel {
	public $name       = 'TechnologyGroup';
	
	public $hasMany = array(
		'Technology' => array(
			'className'  => 'Technology',
		),
	);
}
