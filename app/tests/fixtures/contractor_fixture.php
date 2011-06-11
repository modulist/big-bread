<?php
/* Contractor Fixture generated on: 2011-06-11 14:06:47 : 1307815607 */
class ContractorFixture extends CakeTestFixture {
	var $name = 'Contractor';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'company_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'billing_address_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'certified_nate' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'certified_bpi' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'certified_resnet' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'certified_other' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__contractors__users' => array('column' => 'user_id', 'unique' => 0), 'fk__contractors__addresses' => array('column' => 'billing_address_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4df3aeb7-a268-4b6b-ac67-173b6e891b5e',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'company_name' => 'Lorem ipsum dolor sit amet',
			'billing_address_id' => 'Lorem ipsum dolor sit amet',
			'certified_nate' => 1,
			'certified_bpi' => 1,
			'certified_resnet' => 1,
			'certified_other' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2011-06-11 14:06:47',
			'modified' => '2011-06-11 14:06:47'
		),
	);
}
?>