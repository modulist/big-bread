<?php
class Message extends AppModel {
	public $name = 'Message';

	public $belongsTo = array(
		'Proposal' => array(
			'foreignKey' => 'foreign_key',
			'conditions' => array( 'Message.model' => 'Proposal' ),
		),
		'Sender' => array(
			'className' => 'User',
			'foreignKey' => 'sender_id',
		),
		'Recipient' => array(
			'className' => 'User',
			'foreignKey' => 'recipient_id',
		),
	);
}
