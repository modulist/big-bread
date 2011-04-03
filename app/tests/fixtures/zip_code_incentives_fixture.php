<?php
/* ZipCodeIncentives Fixture generated on: 2011-04-02 07:32:07 : 1301743927 */
class ZipCodeIncentivesFixture extends CakeTestFixture {
	var $name = 'ZipCodeIncentives';
	var $table = 'incentive_zips';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'incentive_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'zip' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 5, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'incentive_id' => 'Lorem ip',
			'zip' => 'Lor'
		),
	);
}
?>