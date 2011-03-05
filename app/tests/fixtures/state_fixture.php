<?php
/* state Fixture generated on: 2011-03-05 06:35:30 : 1299324930 */
class stateFixture extends CakeTestFixture {
	var $name = 'state';
	var $table = 'us_states';

	var $fields = array(
		'code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 2, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'code', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'code' => '',
			'state' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>