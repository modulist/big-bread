<?php
/* TechnologyIncentive Test cases generated on: 2011-03-26 13:20:44 : 1301160044*/
App::import('Model', 'TechnologyIncentive');

class TechnologyIncentiveTestCase extends CakeTestCase {
	var $fixtures = array('app.technology_incentive');

	function startTest() {
		$this->TechnologyIncentive =& ClassRegistry::init('TechnologyIncentive');
	}

	function endTest() {
		unset($this->TechnologyIncentive);
		ClassRegistry::flush();
	}

}
?>