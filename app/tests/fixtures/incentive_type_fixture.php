<?php
/* IncentiveType Fixture generated on: 2011-06-08 14:39:27 : 1307558367 */
class IncentiveTypeFixture extends CakeTestFixture {
	var $name = 'IncentiveType';
	var $table = 'incentive_type';

	var $fields = array(
		'incentive_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'listname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_type_group_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'display' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'incentive_type_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'incentive_type_id' => 'Lore',
			'listname' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'foreign_type' => 'Lorem ipsum dolor sit amet',
			'incentive_type_group_id' => 'L',
			'display' => 1
		),
	);
}
?>