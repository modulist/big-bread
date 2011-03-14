<?php
/* EnergySource Fixture generated on: 2011-03-14 18:52:28 : 1300143148 */
class EnergySourceFixture extends CakeTestFixture {
	var $name = 'EnergySource';
	var $table = 'incentive_tech_energy_group';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'incentive_tech_energy_group_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'version' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 20),
		'display' => array('type' => 'text', 'null' => false, 'default' => 'b\'1\'', 'length' => 1),
		'parent_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'uix__incentive_tech_energy_group__incentive_tech_energy_group_id' => array('column' => 'incentive_tech_energy_group_id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => '4d7e9c2c-10f0-48f4-971d-c9a86e891b5e',
			'incentive_tech_energy_group_id' => 'Lore',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'version' => 1,
			'display' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'parent_id' => 'Lore'
		),
	);
}
?>