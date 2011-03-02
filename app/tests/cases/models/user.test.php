<?php
/* Contact Test cases generated on: 2011-02-28 21:27:48 : 1298946468*/
App::import('Model', 'Contact');

class ContactTestCase extends CakeTestCase {
	var $fixtures = array('app.contact');

	function startTest() {
		$this->Contact =& ClassRegistry::init('Contact');
	}

	function endTest() {
		unset($this->Contact);
		ClassRegistry::flush();
	}

}
?>