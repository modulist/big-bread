<?php
/* Building Fixture generated on: 2011-02-28 21:33:44 : 1298946824 */
class BuildingFixture extends CakeTestFixture {
	var $name = 'Building';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'realtor_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'year_built' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'total_sf' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'finished_sf' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'stories_above_ground' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'basement_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'window_wall_ratio_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'skylight_count' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'window_wall' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'window_wall_sf' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'window_wall_side' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'shading_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'infiltration_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'exposure_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'efficiency_rating' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'warranty_info' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'recall_info' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__buildings__addresses' => array('column' => 'address_id', 'unique' => 0), 'fk__buildings__building_types' => array('column' => 'building_type_id', 'unique' => 0), 'fk__buildings__basement_types' => array('column' => 'basement_type_id', 'unique' => 0), 'fk__buildings__shading_types' => array('column' => 'shading_type_id', 'unique' => 0), 'fk__buildings__infiltration_types' => array('column' => 'infiltration_type_id', 'unique' => 0), 'fk__buildings__exposure_types' => array('column' => 'exposure_type_id', 'unique' => 0), 'fk__buildings__contacts' => array('column' => 'realtor_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d6c5b08-5780-4b21-b0fe-4a536e891b5e',
			'building_type_id' => 'Lorem ipsum dolor sit amet',
			'address_id' => 'Lorem ipsum dolor sit amet',
			'realtor_id' => 'Lorem ipsum dolor sit amet',
			'year_built' => 1,
			'total_sf' => 1,
			'finished_sf' => 1,
			'stories_above_ground' => 1,
			'basement_type_id' => 'Lorem ipsum dolor sit amet',
			'window_wall_ratio_id' => 1,
			'skylight_count' => 1,
			'window_wall' => 1,
			'window_wall_sf' => 1,
			'window_wall_side' => 'Lorem ipsum dolor sit ame',
			'shading_type_id' => 'Lorem ipsum dolor sit amet',
			'infiltration_type_id' => 'Lorem ipsum dolor sit amet',
			'exposure_type_id' => 'Lorem ipsum dolor sit amet',
			'efficiency_rating' => 1,
			'warranty_info' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'recall_info' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'deleted' => 1,
			'created' => '2011-02-28 21:33:44',
			'modified' => '2011-02-28 21:33:44'
		),
	);
}
?>