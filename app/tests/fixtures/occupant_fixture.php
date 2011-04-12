<?php
/* Occupant Fixture generated on: 2011-04-11 18:56:37 : 1302562597 */
class OccupantFixture extends CakeTestFixture {
	var $name = 'Occupant';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'age_0_5' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'age_6_13' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'age_14_64' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'age_65' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'daytime_occupancy' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'heating_override' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'cooling_override' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__occupants__buildings' => array('column' => 'building_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4da38725-2220-4ed9-986f-4d766e891b5e',
			'building_id' => 'Lorem ipsum dolor sit amet',
			'age_0_5' => 1,
			'age_6_13' => 1,
			'age_14_64' => 1,
			'age_65' => 1,
			'daytime_occupancy' => 1,
			'heating_override' => 1,
			'cooling_override' => 1
		),
	);
}
?>