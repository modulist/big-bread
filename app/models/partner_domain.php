<?php

class PartnerDomain extends AppModel {
	public $name = 'PartnerDomain';
	
	public $belongsTo = array( 'Partner' );
  
	public $validate  = array(
		'top_level_domain' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Top level domain (e.g. partnername.com) cannot be empty.',
				'allowEmpty' => false,
				'required'   => true
			),
		),
	);
}
