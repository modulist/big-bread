<?php
/* ZipCode Test cases generated on: 2011-03-08 18:07:05 : 1299625625*/
App::import('Model', 'ZipCode');

class ZipCodeTestCase extends CakeTestCase {
	var $fixtures = array('app.zip_code', 'app.address', 'app.state', 'app.building', 'app.user', 'app.user_type', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_wall_system', 'app.wall_system', 'app.insulation_level', 'app.building_appliance', 'app.appliance', 'app.appliance_type', 'app.energy_source', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.building_window_system', 'app.window_system', 'app.occupant', 'app.survey');

	function startTest() {
		$this->ZipCode =& ClassRegistry::init('ZipCode');
	}

	function endTest() {
		unset($this->ZipCode);
		ClassRegistry::flush();
	}

}
?>