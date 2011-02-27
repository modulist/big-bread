<?php
class PartnerDomain extends AppModel {
	var $name = 'PartnerDomain';
	var $validate = array(
		'partner_id' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'A domain must belong to a partner.',
				'allowEmpty' => false,
				'required'   => true
			),
		),
		'top_level_domain' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Top level domain cannot be empty.',
				'allowEmpty' => false,
				'required'   => true
			),
		),
	);
	
	var $belongsTo = array( 'Partner' );
}
