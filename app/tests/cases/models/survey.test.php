<?php
/* Survey Test cases generated on: 2011-02-28 21:17:07 : 1298945827*/
App::import('Model', 'Survey');

class SurveyTestCase extends CakeTestCase {
	var $fixtures = array('app.survey', 'app.contractor', 'app.homeowner', 'app.building');

	function startTest() {
		$this->Survey =& ClassRegistry::init('Survey');
	}

	function endTest() {
		unset($this->Survey);
		ClassRegistry::flush();
	}

}
?>