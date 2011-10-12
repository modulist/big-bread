<?php

class Fixture extends AppModel {
	public $name = 'Fixture';
	
  public $belongsTo = array( 'Building', 'Technology', 'EnergySource' );
  
  public $actsAs = array(
    'AuditLog.Auditable',
  );
  
	public $validate = array(
    'serial_number' => array(
			'unique' => array(
				'rule'       => 'isUnique',
				'message'    => 'This serial number is not unique.',
				'allowEmpty' => true,
				'required'   => false,
        'last'       => true,
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
  
  /**
   * Retire a piece of equpment.
   *
   * @param 	$id
   * @access	public
   */
  public function retire( $id ) {
    $this->Fixture->id = $id;
    return $this->Fixture->saveField( 'service_out', date( 'Y-m-d H:i:s', time() ) );
  }
}