<?php
/* Tip Test cases generated on: 2011-06-21 07:27:28 : 1308655648*/
App::import('Model', 'Tip');

class TipTestCase extends CakeTestCase {
	var $fixtures = array('app.tip');

	function startTest() {
		$this->Tip =& ClassRegistry::init('Tip');
	}

	function endTest() {
		unset($this->Tip);
		ClassRegistry::flush();
	}

}
?>