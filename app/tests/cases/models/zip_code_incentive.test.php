<?php
/* ZipCodeIncentive Test cases generated on: 2011-03-23 06:57:56 : 1300877876*/
App::import('Model', 'ZipCodeIncentive');

class ZipCodeIncentiveTestCase extends CakeTestCase {
	var $fixtures = array('app.zip_code_incentive');

	function startTest() {
		$this->ZipCodeIncentive =& ClassRegistry::init('ZipCodeIncentive');
	}

	function endTest() {
		unset($this->ZipCodeIncentive);
		ClassRegistry::flush();
	}

}
?>