<?php
/* Appliance Test cases generated on: 2011-03-04 18:28:13 : 1299281293*/
App::import('Model', 'Appliance');

class ApplianceTestCase extends CakeTestCase {
	var $fixtures = array('app.appliance', 'app.appliance_type', 'app.energy_source', 'app.building', 'app.user', 'app.user_type', 'app.address', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_appliance', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.insulation_level', 'app.building_wall_system', 'app.wall_system', 'app.building_window_system', 'app.window_system', 'app.occupant', 'app.survey');

	function startTest() {
		$this->Appliance =& ClassRegistry::init('Appliance');
	}

	function endTest() {
		unset($this->Appliance);
		ClassRegistry::flush();
	}

}
?>