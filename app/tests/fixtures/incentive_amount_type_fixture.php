<?php
/* IncentiveAmountType Fixture generated on: 2011-04-03 08:31:51 : 1301833911 */
class IncentiveAmountTypeFixture extends CakeTestFixture {
	var $name = 'IncentiveAmountType';
	var $table = 'incentive_amount_type';

	var $fields = array(
		'incentive_amount_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'version' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'display' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'incentive_amount_type_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'incentive_amount_type_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'version' => 1,
			'display' => 1
		),
	);
}
?>