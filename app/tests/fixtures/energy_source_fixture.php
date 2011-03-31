<?php
/* EnergySource Fixture generated on: 2011-03-28 21:05:22 : 1301360722 */
class EnergySourceFixture extends CakeTestFixture {
	var $name = 'EnergySource';
	var $table = 'incentive_tech_energy_type';

	var $fields = array(
		'incentive_tech_energy_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_tech_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_tech_energy_group_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'default' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Default setting'),
		'display' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'Display or Hide in views'),
		'active' => array('type' => 'text', 'null' => false, 'default' => 'b\'1\'', 'length' => 1, 'comment' => 'Make checkbox changeable or not'),
		'indexes' => array('PRIMARY' => array('column' => 'incentive_tech_energy_type_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'incentive_tech_energy_type_id' => 'Lore',
			'incentive_tech_id' => 'Lore',
			'incentive_tech_energy_group_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'default' => 1,
			'display' => 1,
			'active' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>