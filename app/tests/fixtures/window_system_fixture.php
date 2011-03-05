<?php
/* WindowSystem Fixture generated on: 2011-03-04 17:47:47 : 1299278867 */
class WindowSystemFixture extends CakeTestFixture {
	var $name = 'WindowSystem';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'uix__code' => array('column' => 'code', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d716c13-f4cc-41a4-9b74-497b6e891b5e',
			'code' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>