<?php
/* WallSystem Fixture generated on: 2011-03-03 16:12:04 : 1299186724 */
class WallSystemFixture extends CakeTestFixture {
	var $name = 'WallSystem';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'wall_system_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'u_value' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'uix__wall_system_type_id' => array('column' => 'wall_system_type_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d700424-7dd4-4511-9ba0-7f356e891b5e',
			'wall_system_type_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'u_value' => 1,
			'deleted' => 1
		),
	);
}
?>