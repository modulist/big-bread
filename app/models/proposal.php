<?php

class Proposal extends AppModel {
	public $name = 'Proposal';

  public $hasMany   = array(
    'Message' => array(
      'className'  => 'Message',
      'foreignKey' => 'foreign_key',
      'conditions' => array( 'Message.model' => 'Proposal' ),
    )
  );
	public $belongsTo = array(
    'Building' => array(
      'className'  => 'Building',
      'foreignKey' => 'location_id',
    ),
		'Requestor' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
		),
    'TechnologyIncentive',
	);
}
