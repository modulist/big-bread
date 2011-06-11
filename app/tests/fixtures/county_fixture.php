<?php
/* County Fixture generated on: 2011-06-11 07:19:58 : 1307791198 */
class CountyFixture extends CakeTestFixture {
	var $name = 'County';
	var $table = 'us_county';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary'),
		'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'county' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'state' => '',
			'county' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>