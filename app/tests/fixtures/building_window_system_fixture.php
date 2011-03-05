<?php
/* BuildingWindowSystem Fixture generated on: 2011-03-04 17:48:01 : 1299278881 */
class BuildingWindowSystemFixture extends CakeTestFixture {
	var $name = 'BuildingWindowSystem';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'window_system_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__building_window_systems__buildings' => array('column' => 'building_id', 'unique' => 0), 'fk__building_window_systems__window_systems' => array('column' => 'window_system_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d716c21-3010-45e7-b444-49846e891b5e',
			'building_id' => 'Lorem ipsum dolor sit amet',
			'window_system_id' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>