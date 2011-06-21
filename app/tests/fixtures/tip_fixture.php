<?php
/* Tip Fixture generated on: 2011-06-21 07:27:28 : 1308655648 */
class TipFixture extends CakeTestFixture {
	var $name = 'Tip';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4e008020-90a4-4ace-9e39-05e06e891b5e',
			'tip' => 'Lorem ipsum dolor sit amet',
			'active' => 1,
			'created' => '2011-06-21 07:27:28',
			'modified' => '2011-06-21 07:27:28'
		),
	);
}
?>