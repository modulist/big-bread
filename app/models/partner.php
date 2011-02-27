<?php

class Partner extends AppModel {
	var $name = 'Partner';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Partner name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true
			),
		),
	);
	
  var $hasMany = array( 'PartnerDomain' );
}
