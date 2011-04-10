<?php

class IncentiveNote extends AppModel {
	public $name     = 'IncentiveNote';
	public $useTable = 'incentive_note';
	
	public $belongsTo = array(
		'Incentive' => array(
			'className'  => 'Incentive',
			'foreignKey' => 'incentive_id',
      'type'       => 'inner',
		), /**
		'IncentiveNoteType' => array(
			'className'  => 'IncentiveNoteType',
			'foreignKey' => 'incentive_note_type_id',
      'type'       => 'inner',
		) */
	);
}
