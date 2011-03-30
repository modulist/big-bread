<?php
/* Products Test cases generated on: 2011-03-30 07:58:40 : 1301486320*/
App::import('Controller', 'Products');

class TestProductsController extends ProductsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProductsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.product', 'app.technology', 'app.technology_incentive', 'app.incentive', 'app.zip_code', 'app.address', 'app.state', 'app.building', 'app.user', 'app.user_type', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.utility', 'app.zip_code_utility', 'app.incentive_utility', 'app.building_wall_system', 'app.wall_system', 'app.insulation_level', 'app.occupant', 'app.questionnaire', 'app.building_product', 'app.building_roof_system', 'app.roof_system', 'app.building_window_system', 'app.material', 'app.window_pane_type', 'app.incentive_zip', 'app.energy_source', 'app.incentive_tech_energy');

	function startTest() {
		$this->Products =& new TestProductsController();
		$this->Products->constructClasses();
	}

	function endTest() {
		unset($this->Products);
		ClassRegistry::flush();
	}

}
?>