<?php

class UserTypeFixture extends CakeTestFixture {
	var $name = 'UserType';
	var $records = array(
		array(
			'id' => '4d6d9699-5088-48db-9f56-47ea6e891b5e',
			'code' => 'INSPCT',
			'name' => 'Inspector',
			'selectable' => '1',
			'deleted' => '0',
		),
		array(
			'id' => '4d6d9699-a7a4-42a1-855e-4f606e891b5e',
			'code' => 'BUYER',
			'name' => 'Buyer',
			'selectable' => '1',
			'deleted' => '0',
		),
		array(
			'id' => '4d6d9699-f19c-41e3-a723-45ae6e891b5e',
			'code' => 'REALTR',
			'name' => 'Realtor',
			'selectable' => '1',
			'deleted' => '0',
		),
		array(
			'id' => '4d71115d-0f74-43c5-93e9-2f8a3b196446',
			'code' => 'OWNER',
			'name' => 'Homeowner',
			'selectable' => '1',
			'deleted' => '0',
		),
		array(
			'id' => '6573bca8-945a-11e0-adec-3aadb68782f6',
			'code' => 'CNTRCT',
			'name' => 'Contractor',
			'selectable' => '0',
			'deleted' => '0',
		),
		array(
			'id' => 'eff7d6ba-9528-11e0-9067-002590289478',
			'code' => 'API',
			'name' => 'API Consumer',
			'selectable' => '0',
			'deleted' => '0',
		),
	);
}

?>