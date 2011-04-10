<?php
/* IncentiveNote Fixture generated on: 2011-04-09 14:42:54 : 1302374574 */
class IncentiveNoteFixture extends CakeTestFixture {
	var $name = 'IncentiveNote';
	var $table = 'incentive_note';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'incentive_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'note' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 1000, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'date_edited' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'incentive_note_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'incentive_id' => array('column' => 'incentive_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'incentive_id' => 'Lorem ipsum dolor sit amet',
			'note' => 'Lorem ipsum dolor sit amet',
			'date_edited' => '2011-04-09 14:42:54',
			'incentive_note_type_id' => 'L'
		),
	);
}
?>