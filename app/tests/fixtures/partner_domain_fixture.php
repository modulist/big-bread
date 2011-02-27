<?php
/* PartnerDomain Fixture generated on: 2011-02-27 11:49:04 : 1298825344 */
class PartnerDomainFixture extends CakeTestFixture {
	var $name = 'PartnerDomain';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'partner_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top_level_domain' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk__partner_domains__partners' => array('column' => 'partner_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d6a8080-8930-4c2a-9222-70126e891b5e',
			'partner_id' => 'Lorem ipsum dolor sit amet',
			'top_level_domain' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-27 11:49:04',
			'modified' => '2011-02-27 11:49:04'
		),
	);
}
?>