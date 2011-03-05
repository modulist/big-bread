<?php
/* WindowSystem Test cases generated on: 2011-03-04 17:47:47 : 1299278867*/
App::import('Model', 'WindowSystem');

class WindowSystemTestCase extends CakeTestCase {
	var $fixtures = array('app.window_system', 'app.building', 'app.user', 'app.user_type', 'app.address', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_appliance', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.insulation_level', 'app.building_wall_system', 'app.wall_system', 'app.building_window_system', 'app.occupant', 'app.survey');

	function startTest() {
		$this->WindowSystem =& ClassRegistry::init('WindowSystem');
	}

	function endTest() {
		unset($this->WindowSystem);
		ClassRegistry::flush();
	}

}
?>