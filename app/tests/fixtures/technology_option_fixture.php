<?php
/* TechnologyOption Fixture generated on: 2011-04-03 16:27:24 : 1301862444 */
class TechnologyOptionFixture extends CakeTestFixture {
	var $name = 'TechnologyOption';
	var $table = 'incentive_tech_option_type';

	var $fields = array(
		'incentive_tech_option_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_tech_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'version' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 20),
		'display' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'sort' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'incentive_tech_option_type_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'incentive_tech_option_type_id' => 'Lore',
			'incentive_tech_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'version' => 1,
			'display' => 1,
			'sort' => 1
		),
	);
}
?>