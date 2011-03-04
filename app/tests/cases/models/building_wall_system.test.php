<?php
/* BuildingWallSystem Test cases generated on: 2011-03-03 16:06:14 : 1299186374*/
App::import('Model', 'BuildingWallSystem');

class BuildingWallSystemTestCase extends CakeTestCase {
	var $fixtures = array('app.building_wall_system', 'app.building', 'app.user', 'app.address', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.infiltration_type', 'app.maintenance_level', 'app.shading_type', 'app.building_appliance', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.building_window_system', 'app.occupant', 'app.survey', 'app.wall_system');

	function startTest() {
		$this->BuildingWallSystem =& ClassRegistry::init('BuildingWallSystem');
	}

	function endTest() {
		unset($this->BuildingWallSystem);
		ClassRegistry::flush();
	}

}
?>