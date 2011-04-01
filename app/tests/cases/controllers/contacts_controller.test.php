<?php
/* Contacts Test cases generated on: 2011-03-31 21:00:00 : 1301619600*/
App::import('Controller', 'Contacts');

class TestContactsController extends ContactsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContactsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.contact');

	function startTest() {
		$this->Contacts =& new TestContactsController();
		$this->Contacts->constructClasses();
	}

	function endTest() {
		unset($this->Contacts);
		ClassRegistry::flush();
	}

}
?>