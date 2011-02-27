<?php
/* Partner Fixture generated on: 2011-02-27 11:44:49 : 1298825089 */
class PartnerFixture extends CakeTestFixture {
	var $name = 'Partner';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d6a7f81-7c0c-44cb-9cc4-6fb46e891b5e',
			'name' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-27 11:44:49',
			'modified' => '2011-02-27 11:44:49'
		),
	);
}
?>