<?php
/* Incentive Fixture generated on: 2011-03-22 20:24:25 : 1300839865 */
class IncentiveFixture extends CakeTestFixture {
	var $name = 'Incentive';
	var $table = 'search_view';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8', 'key' => 'primary'),
		'excluded' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'category' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'i_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'i_group' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'entire_state' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'it_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'it_group' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'jt_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 20),
		'tech_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'amount' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'amt_unit' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'weblink' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'rebate_link' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tech_opt' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'opt_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'energy_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'energy_group' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'energy_group_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'term_type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'min_requirement' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'min_value' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'max_requirement' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'max_value' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'comment_label' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'term_comment' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 'Lorem ip',
			'excluded' => 1,
			'code' => 'Lorem ip',
			'category' => 'Lorem ipsum dolor sit amet',
			'i_type' => 'Lorem ipsum dolor sit amet',
			'i_group' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'state' => '',
			'entire_state' => 1,
			'it_name' => 'Lorem ipsum dolor sit amet',
			'it_group' => 'Lorem ipsum dolor sit amet',
			'jt_id' => 1,
			'tech_id' => 'Lore',
			'is_active' => 1,
			'amount' => 1,
			'amt_unit' => 'Lorem ipsum dolor sit amet',
			'weblink' => 'Lorem ipsum dolor sit amet',
			'rebate_link' => 'Lorem ipsum dolor sit amet',
			'tech_opt' => 'Lore',
			'opt_name' => 'Lorem ipsum dolor sit amet',
			'energy_type' => 'Lorem ipsum dolor sit amet',
			'energy_group' => 'Lorem ipsum dolor sit amet',
			'energy_group_id' => 'Lore',
			'term_type' => 'Lorem ipsum dolor sit amet',
			'min_requirement' => 'Lorem ipsum dolor sit amet',
			'min_value' => 'Lorem ipsum dolor sit amet',
			'max_requirement' => 'Lorem ipsum dolor sit amet',
			'max_value' => 'Lorem ipsum dolor sit amet',
			'comment_label' => 'Lorem ipsum dolor sit amet',
			'term_comment' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>