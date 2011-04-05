<?php
/* TechnologyOption Test cases generated on: 2011-04-03 16:27:24 : 1301862444*/
App::import('Model', 'TechnologyOption');

class TechnologyOptionTestCase extends CakeTestCase {
	var $fixtures = array('app.technology_option');

	function startTest() {
		$this->TechnologyOption =& ClassRegistry::init('TechnologyOption');
	}

	function endTest() {
		unset($this->TechnologyOption);
		ClassRegistry::flush();
	}

}
?>