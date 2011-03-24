<?php
/* ZipCodeIncentive Fixture generated on: 2011-03-23 06:57:56 : 1300877876 */
class ZipCodeIncentiveFixture extends CakeTestFixture {
	var $name = 'ZipCodeIncentive';
	var $table = 'incentive_zip';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'incentive_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'incentive_id' => 'Lorem ip',
			'zip' => 1
		),
	);
}
?>