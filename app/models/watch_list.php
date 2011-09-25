<?php

class WatchList extends AppModel {
	public $name = 'WatchList';

	public $belongsTo = array(
		'User',
		'Technology' => array(
			'className' => 'Technology',
			'foreignKey' => 'foreign_key',
			'conditions' => array( 'WatchList.model' => 'Technology' ),
		)
	);
}
