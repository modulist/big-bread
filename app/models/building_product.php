<?php

# TODO: Change to Equipment
class BuildingProduct extends AppModel {
	public $name = 'BuildingProduct';
	
  public $belongsTo = array( 'Building', 'Product' );
  
  public $actsAs = array(
    'AuditLog.Auditable',
  );
  
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
    'purchase_price' => array(
      'cost' => array(
        'rule' => array( 'decimal', 2 ),
				'message'    => 'Invalid amount.',
        'allowEmpty' => true,
        'required'   => false,
      ),
    ),
    'service_in' => array(
			'datetime'     => array(
				'rule'       => 'datetime',
				'message'    => 'This is not a valid date.',
        'allowEmpty' => true,
        'required'   => false,
      ),
    ),
    'service_out' => array(
			'datetime'     => array(
				'rule'       => 'datetime',
				'message'    => 'This is not a valid date.',
        'allowEmpty' => true,
        'required'   => false,
      ),
    ),
  );
}
