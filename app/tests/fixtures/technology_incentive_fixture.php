<?php
/* TechnologyIncentive Fixture generated on: 2011-03-26 13:20:44 : 1301160044 */
class TechnologyIncentiveFixture extends CakeTestFixture {
	var $name = 'TechnologyIncentive';
	var $table = 'incentive__incentive_tech';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'incentive_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_tech_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'date_created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'version' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 3),
		'last_updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'amount' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'incentive_amount_type_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'weblink' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'rebate_link' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'incentive_id' => array('column' => 'incentive_id', 'unique' => 0), 'incentive_tech_id' => array('column' => 'incentive_tech_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'is_active' => 1,
			'incentive_id' => 'Lorem ip',
			'incentive_tech_id' => 'Lore',
			'date_created' => '2011-03-26 13:20:44',
			'version' => 1,
			'last_updated' => '2011-03-26 13:20:44',
			'amount' => 1,
			'incentive_amount_type_id' => 'Lore',
			'weblink' => 'Lorem ipsum dolor sit amet',
			'rebate_link' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>