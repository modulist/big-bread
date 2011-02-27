<?php
/* PartnerDomain Test cases generated on: 2011-02-27 11:49:04 : 1298825344*/
App::import('Model', 'PartnerDomain');

class PartnerDomainTestCase extends CakeTestCase {
	var $fixtures = array('app.partner_domain', 'app.partner');

	function startTest() {
		$this->PartnerDomain =& ClassRegistry::init('PartnerDomain');
	}

	function endTest() {
		unset($this->PartnerDomain);
		ClassRegistry::flush();
	}

}
?>