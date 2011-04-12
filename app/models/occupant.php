<?php

class Occupant extends AppModel {
	public $name = 'Occupant';
	
	public $belongsTo = array(
		'Building' => array(
			'className' => 'Building',
			'foreignKey' => 'building_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
  
	public $validate = array(
		'age_0_5' => array(
      'integer' => array(
        'rule'       => array( 'integer' ), 
        'message'    => 'Invalid number of occupants age 0-5.',
        'allowEmpty' => true,
        'required'   => false,
      ),
		),
		'age_6_13' => array(
      'integer' => array(
        'rule'       => array( 'integer' ), 
        'message'    => 'Invalid number of occupants age 6-13.',
        'allowEmpty' => true,
        'required'   => false,
      ),
		),
		'age_14_64' => array(
      'integer' => array(
        'rule'       => array( 'integer' ), 
        'message'    => 'Invalid number of occupants age 14-64.',
        'allowEmpty' => true,
        'required'   => false,
      ),
		),
		'age_65' => array(
      'integer' => array(
        'rule'       => array( 'integer' ), 
        'message'    => 'Invalid number of occupants age 65 or older.',
        'allowEmpty' => true,
        'required'   => false,
      ),
		),
	);
}
