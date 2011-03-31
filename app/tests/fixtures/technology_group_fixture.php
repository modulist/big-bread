<?php
/* TechnologyGroup Fixture generated on: 2011-03-30 14:10:36 : 1301508636 */
class TechnologyGroupFixture extends CakeTestFixture {
	var $name = 'TechnologyGroup';
	var $table = 'incentive_tech_group';

	var $fields = array(
		'incentive_tech_group_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'parent_group_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'incentive_tech_group_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'incentive_tech_group_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'parent_group_id' => 'Lore'
		),
	);
}
?>