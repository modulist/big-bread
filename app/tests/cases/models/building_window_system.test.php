<?php
/* BuildingWindowSystem Test cases generated on: 2011-03-04 17:48:01 : 1299278881*/
App::import('Model', 'BuildingWindowSystem');

class BuildingWindowSystemTestCase extends CakeTestCase {
	var $fixtures = array('app.building_window_system', 'app.building', 'app.user', 'app.user_type', 'app.address', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_appliance', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.insulation_level', 'app.building_wall_system', 'app.wall_system', 'app.occupant', 'app.survey', 'app.window_system');

	function startTest() {
		$this->BuildingWindowSystem =& ClassRegistry::init('BuildingWindowSystem');
	}

	function endTest() {
		unset($this->BuildingWindowSystem);
		ClassRegistry::flush();
	}

}
?>