<?php

class BuildingProduct extends AppModel {
	public $name = 'BuildingProduct';
	
  public $belongsTo = array( 'Building', 'Product' );
  
	public $validate = array(
		'product_id' => array(
			'notempty' => array(
				'rule'       => 'notEmpty',
				'message'    => 'Product cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'serial_number' => array(
			'unique' => array(
				'rule'       => 'isUnique',
				'message'    => 'This serial number is not unique.',
				'allowEmpty' => true,
				'required'   => false,
        'last'       => true,
			),
		),
  );
}
