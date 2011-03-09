<?php
/* Addresses Test cases generated on: 2011-03-08 17:40:35 : 1299624035*/
App::import('Controller', 'Addresses');

class TestAddressesController extends AddressesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AddressesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.address', 'app.state', 'app.building', 'app.user', 'app.user_type', 'app.basement_type', 'app.building_shape', 'app.building_type', 'app.exposure_type', 'app.maintenance_level', 'app.shading_type', 'app.building_wall_system', 'app.wall_system', 'app.insulation_level', 'app.building_appliance', 'app.appliance', 'app.appliance_type', 'app.energy_source', 'app.building_hot_water_system', 'app.building_hvac_system', 'app.building_roof_system', 'app.roof_system', 'app.building_window_system', 'app.window_system', 'app.occupant', 'app.survey');

	function startTest() {
		$this->Addresses =& new TestAddressesController();
		$this->Addresses->constructClasses();
	}

	function endTest() {
		unset($this->Addresses);
		ClassRegistry::flush();
	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>