<?php
/* BuildingWallSystem Fixture generated on: 2011-03-03 16:06:14 : 1299186374 */
class BuildingWallSystemFixture extends CakeTestFixture {
	var $name = 'BuildingWallSystem';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'building_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'wall_system_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => array('building_id', 'wall_system_id'), 'unique' => 1), 'fk__building_wall_systems__wall_systems' => array('column' => 'wall_system_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d7002c6-a7ec-45ce-b1e3-7ec66e891b5e',
			'building_id' => '4d7002c6-f800-4490-8f6b-7ec66e891b5e',
			'wall_system_id' => '4d7002c6-4364-48a9-8ba3-7ec66e891b5e'
		),
	);
}
?>