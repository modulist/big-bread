<?php

class Fixture extends AppModel {
	public $name = 'Fixture';
	
  public $belongsTo = array( 'Building', 'Technology', 'EnergySource' );
  
  public $actsAs = array(
    'AuditLog.Auditable',
  );
  
	public $validate = array(
    'service_in' => array(
			'year'     => array(
				'rule'       => 'integer',
				'message'    => 'Please enter a valid installation year.',
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
    $this->id = $id;
    return $this->saveField( 'service_out', date( 'Y-m-d H:i:s', time() ) );
  }
}
