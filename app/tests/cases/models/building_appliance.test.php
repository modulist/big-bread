<?php
/* BuildingAppliance Test cases generated on: 2011-03-04 18:26:21 : 1299281181*/
App::import('Model', 'BuildingAppliance');

class BuildingApplianceTestCase extends CakeTestCase {
	var $fixtures = array('app.building_appliance', 'app.building', 'app.user', 'app.user_type', 'app.address', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.insulation_level', 'app.building_wall_system', 'app.wall_system', 'app.building_window_system', 'app.window_system', 'app.occupant', 'app.survey', 'app.appliance');

	function startTest() {
		$this->BuildingAppliance =& ClassRegistry::init('BuildingAppliance');
	}

	function endTest() {
		unset($this->BuildingAppliance);
		ClassRegistry::flush();
	}

}
?>