<?php
/* state Test cases generated on: 2011-03-05 06:35:30 : 1299324930*/
App::import('Model', 'state');

class stateTestCase extends CakeTestCase {
	var $fixtures = array('app.state', 'app.address');

	function startTest() {
		$this->state =& ClassRegistry::init('state');
	}

	function endTest() {
		unset($this->state);
		ClassRegistry::flush();
	}

}
?>