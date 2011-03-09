<?php
/* ZipCode Fixture generated on: 2011-03-08 18:07:05 : 1299625625 */
class ZipCodeFixture extends CakeTestFixture {
	var $name = 'ZipCode';
	var $table = 'us_zipcode';

	var $fields = array(
		'zip' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 5, 'key' => 'primary'),
		'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 150, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'population' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'households' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'persons_per_household' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'zip', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'zip' => 1,
			'state' => '',
			'city' => 'Lorem ipsum dolor sit amet',
			'population' => 1,
			'households' => 1,
			'persons_per_household' => 1
		),
	);
}
?>