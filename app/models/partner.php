<?php

class Partner extends AppModel {
	public $name = 'Partner';
	
  public $hasMany = array( 'PartnerDomain' );
  
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule'       => array( 'notempty' ),
				'message'    => 'Partner name cannot be empty.',
				'allowEmpty' => false,
				'required'   => true
			),
		),
	);
}
