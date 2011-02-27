<?php
/* Partner Test cases generated on: 2011-02-27 11:44:49 : 1298825089*/
App::import('Model', 'Partner');

class PartnerTestCase extends CakeTestCase {
	var $fixtures = array('app.partner', 'app.partner_domain');

	function startTest() {
		$this->Partner =& ClassRegistry::init('Partner');
	}

	function endTest() {
		unset($this->Partner);
		ClassRegistry::flush();
	}

}
?>