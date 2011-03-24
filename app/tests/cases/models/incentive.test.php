<?php
/* Incentive Test cases generated on: 2011-03-22 20:24:25 : 1300839865*/
App::import('Model', 'Incentive');

class IncentiveTestCase extends CakeTestCase {
	var $fixtures = array('app.incentive');

	function startTest() {
		$this->Incentive =& ClassRegistry::init('Incentive');
	}

	function endTest() {
		unset($this->Incentive);
		ClassRegistry::flush();
	}

}
?>