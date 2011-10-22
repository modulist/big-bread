<?php
/* Message Fixture generated on: 2011-10-21 20:37:25 : 1319243845 */
class MessageFixture extends CakeTestFixture {
	var $name = 'Message';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'transport' => array('type' => 'string', 'null' => false, 'default' => 'email', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sender_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'recipient_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sent' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__messages__senders' => array('column' => 'sender_id', 'unique' => 0), 'fk__messages__recipients' => array('column' => 'recipient_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4ea21045-9a18-4618-b566-4dc66e891b5e',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'transport' => 'Lorem ipsum dolor sit amet',
			'sender_id' => 'Lorem ipsum dolor sit amet',
			'recipient_id' => 'Lorem ipsum dolor sit amet',
			'sent' => '2011-10-21 20:37:25',
			'created' => '2011-10-21 20:37:25',
			'modified' => '2011-10-21 20:37:25'
		),
	);
}
