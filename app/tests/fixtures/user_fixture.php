<?php
/* User Fixture generated on: 2011-08-07 19:08:56 : 1312758536 */
class UserFixture extends CakeTestFixture {
	public $name = 'User';

	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'user_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phone_number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'invite_code' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 32, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'admin' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'show_questionnaire_instructions' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'uix__email' => array('column' => 'email', 'unique' => 1), 'uix__invite_code' => array('column' => 'invite_code', 'unique' => 1), 'fk__users__user_types' => array('column' => 'user_type_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	public $records = array(
		array(
			'id' => '4e3f1b08-dcf8-4dba-ac36-5cee6e891b5e',
			'user_type_id' => '4d6d9699-5088-48db-9f56-47ea6e891b5e',
			'first_name' => 'Inspec',
			'last_name' => 'Tor',
			'email' => 'inspec@tor.com',
			'phone_number' => null,
			'invite_code' => null,
			'password' => 'f305591849ded3f0f3f97b4fdb51ba417ae6e621',
			'admin' => 0,
			'show_questionnaire_instructions' => 1,
			'last_login' => '2011-08-07 19:08:56',
			'deleted' => 0,
			'created' => '2011-08-07 19:08:56',
			'modified' => '2011-08-07 19:08:56'
		),
		array(
			'id' => '4e3f1b08-0d68-4d29-bd14-5cee6e891b5e',
			'user_type_id' => '4d6d9699-a7a4-42a1-855e-4f606e891b5e',
			'first_name' => 'Home',
			'last_name' => 'Buyer',
			'email' => 'home@buyer.com',
			'phone_number' => null,
			'invite_code' => null,
			'password' => 'f305591849ded3f0f3f97b4fdb51ba417ae6e621',
			'admin' => 0,
			'show_questionnaire_instructions' => 1,
			'last_login' => '2011-08-07 19:08:56',
			'deleted' => 0,
			'created' => '2011-08-07 19:08:56',
			'modified' => '2011-08-07 19:08:56'
		),
		array(
			'id' => '4e3f1b08-2b18-4802-aea5-5cee6e891b5e',
			'user_type_id' => '4d6d9699-f19c-41e3-a723-45ae6e891b5e',
			'first_name' => 'Real',
			'last_name' => 'Tor',
			'email' => 'real@tor.com',
			'phone_number' => null,
			'invite_code' => null,
			'password' => 'f305591849ded3f0f3f97b4fdb51ba417ae6e621',
			'admin' => 0,
			'show_questionnaire_instructions' => 1,
			'last_login' => '2011-08-07 19:08:56',
			'deleted' => 0,
			'created' => '2011-08-07 19:08:56',
			'modified' => '2011-08-07 19:08:56'
		),
		array(
			'id' => '4e3f1b08-2b18-4802-aea5-5cee6e891b5e',
			'user_type_id' => '4d71115d-0f74-43c5-93e9-2f8a3b196446',
			'first_name' => 'Home',
			'last_name' => 'Owner',
			'email' => 'home@owner.com',
			'phone_number' => null,
			'invite_code' => null,
			'password' => 'f305591849ded3f0f3f97b4fdb51ba417ae6e621',
			'admin' => 0,
			'show_questionnaire_instructions' => 1,
			'last_login' => '2011-08-07 19:08:56',
			'deleted' => 0,
			'created' => '2011-08-07 19:08:56',
			'modified' => '2011-08-07 19:08:56'
		),
		array(
			'id' => '4e3f1b08-2b18-4802-aea5-5cee6e891b5e',
			'user_type_id' => '6573bca8-945a-11e0-adec-3aadb68782f6',
			'first_name' => 'Con',
			'last_name' => 'Tractor',
			'email' => 'con@tractor.com',
			'phone_number' => null,
			'invite_code' => null,
			'password' => 'f305591849ded3f0f3f97b4fdb51ba417ae6e621',
			'admin' => 0,
			'show_questionnaire_instructions' => 1,
			'last_login' => '2011-08-07 19:08:56',
			'deleted' => 0,
			'created' => '2011-08-07 19:08:56',
			'modified' => '2011-08-07 19:08:56'
		),
	);
}
