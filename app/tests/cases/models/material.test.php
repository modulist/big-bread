<?php
/* Material Test cases generated on: 2011-03-09 16:03:30 : 1299704610*/
App::import('Model', 'Material');

class MaterialTestCase extends CakeTestCase {
	var $fixtures = array('app.material');

	function startTest() {
		$this->Material =& ClassRegistry::init('Material');
	}

	function endTest() {
		unset($this->Material);
		ClassRegistry::flush();
	}

}
?>