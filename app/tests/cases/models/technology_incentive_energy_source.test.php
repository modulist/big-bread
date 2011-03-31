<?php
/* TechnologyIncentiveEnergySource Test cases generated on: 2011-03-30 17:46:44 : 1301521604*/
App::import('Model', 'TechnologyIncentiveEnergySource');

class TechnologyIncentiveEnergySourceTestCase extends CakeTestCase {
	var $fixtures = array('app.technology_incentive_energy_source', 'app.technology_incentive', 'app.incentive', 'app.zip_code', 'app.address', 'app.state', 'app.building', 'app.user', 'app.user_type', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.utility', 'app.zip_code_utility', 'app.incentive_utility', 'app.building_wall_system', 'app.wall_system', 'app.insulation_level', 'app.occupant', 'app.questionnaire', 'app.building_product', 'app.product', 'app.technology', 'app.technology_group', 'app.energy_source', 'app.incentive_tech_energy', 'app.building_roof_system', 'app.roof_system', 'app.building_window_system', 'app.material', 'app.window_pane_type', 'app.incentive_zip');

	function startTest() {
		$this->TechnologyIncentiveEnergySource =& ClassRegistry::init('TechnologyIncentiveEnergySource');
	}

	function endTest() {
		unset($this->TechnologyIncentiveEnergySource);
		ClassRegistry::flush();
	}

}
?>