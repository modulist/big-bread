<?php

class Proposal extends AppModel {
	public $name = 'Proposal';

	public $belongsTo = array(
    'Incentive',
		'Requestor' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
    'Technology'
	);
}
