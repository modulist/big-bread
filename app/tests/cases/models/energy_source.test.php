<?php
/* EnergySource Test cases generated on: 2011-03-14 18:52:28 : 1300143148*/
App::import('Model', 'EnergySource');

class EnergySourceTestCase extends CakeTestCase {
	var $fixtures = array('app.energy_source', 'app.product', 'app.technology', 'app.building_product', 'app.building', 'app.user', 'app.user_type', 'app.address', 'app.state', 'app.zip_code', 'app.zip_code_utility', 'app.utility', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_wall_system', 'app.wall_system', 'app.insulation_level', 'app.building_roof_system', 'app.roof_system', 'app.building_window_system', 'app.material', 'app.window_pane_type', 'app.occupant', 'app.survey');

	function startTest() {
		$this->EnergySource =& ClassRegistry::init('EnergySource');
	}

	function endTest() {
		unset($this->EnergySource);
		ClassRegistry::flush();
	}

}
?>