<?php
/* TechnologyIncentiveEnergySource Fixture generated on: 2011-03-30 17:46:44 : 1301521604 */
class TechnologyIncentiveEnergySourceFixture extends CakeTestFixture {
	var $name = 'TechnologyIncentiveEnergySource';
	var $table = 'incentive_tech_energy';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'incentive__incentive_tech_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'index'),
		'incentive_tech_energy_type_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'incentive_id' => array('column' => 'incentive__incentive_tech_id', 'unique' => 0), 'incentive_energysource_id' => array('column' => 'incentive_tech_energy_type_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'incentive__incentive_tech_id' => 1,
			'incentive_tech_energy_type_id' => 'Lore',
			'last_updated' => '2011-03-30 17:46:44'
		),
	);
}
?>