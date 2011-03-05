<?php
/* Appliance Fixture generated on: 2011-03-04 18:28:13 : 1299281293 */
class ApplianceFixture extends CakeTestFixture {
	var $name = 'Appliance';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'appliance_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'energy_source_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'make' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'uix__code' => array('column' => 'code', 'unique' => 1), 'fk__appliances__appliance_types' => array('column' => 'appliance_type_id', 'unique' => 0), 'fk__appliances__energy_sources' => array('column' => 'energy_source_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d71758d-0574-4a4d-a7b0-4c916e891b5e',
			'appliance_type_id' => 'Lorem ipsum dolor sit amet',
			'code' => 'Lore',
			'energy_source_id' => 'Lorem ipsum dolor sit amet',
			'make' => 'Lorem ipsum dolor sit amet',
			'model' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>