<?php
/* Survey Fixture generated on: 2011-02-28 21:17:07 : 1298945827 */
class SurveyFixture extends CakeTestFixture {
	var $name = 'Survey';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'contractor_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'homeowner_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__surveys__contractors' => array('column' => 'contractor_id', 'unique' => 0), 'fk__surveys__homeowners' => array('column' => 'homeowner_id', 'unique' => 0), 'fk__surveys__buildings' => array('column' => 'building_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d6c5723-c984-45f5-b727-404a6e891b5e',
			'contractor_id' => 'Lorem ipsum dolor sit amet',
			'homeowner_id' => 'Lorem ipsum dolor sit amet',
			'building_id' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-28 21:17:07',
			'modified' => '2011-02-28 21:17:07',
			'deleted' => 1
		),
	);
}
?>