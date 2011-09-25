<?php
/* WatchList Fixture generated on: 2011-09-24 21:01:30 : 1316912490 */
class WatchListFixture extends CakeTestFixture {
	var $name = 'WatchList';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__watch_lists__users' => array('column' => 'user_id', 'unique' => 0), 'fk__watch_lists__technologies' => array('column' => 'foreign_key', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4e7e7d6a-44f8-4276-a2b0-747b6e891b5e',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'model' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-09-24 21:01:30',
			'modified' => '2011-09-24 21:01:30'
		),
	);
}
?>