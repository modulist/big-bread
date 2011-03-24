<?php
/* IncentivesZipCodes Test cases generated on: 2011-03-22 21:21:32 : 1300843292*/
App::import('Model', 'IncentivesZipCodes');

class IncentivesZipCodesTestCase extends CakeTestCase {
	var $fixtures = array('app.incentives_zip_codes');

	function startTest() {
		$this->IncentivesZipCodes =& ClassRegistry::init('IncentivesZipCodes');
	}

	function endTest() {
		unset($this->IncentivesZipCodes);
		ClassRegistry::flush();
	}

}
?>