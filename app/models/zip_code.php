<?php

class ZipCode extends AppModel {
	public $name       = 'ZipCode';
	public $useTable   = 'us_zipcode';
	public $primaryKey = 'zip';
	
  public $hasMany = array(
    'ZipCodeUtility'   => array( 'foreignKey' => 'zip' ),
    # 'ZipCodeIncentive' => array( 'foreignKey' => 'zip' ),
  );
	public $hasOne = array(
		'Address' => array( 'foreignKey' => 'zip_code' ),
    'State'   => array( 'foreignKey' => 'state' ),
	);
  public $hasAndBelongsToMany = array(
    'Incentive' => array(
      'className'             => 'Incentive',
      'joinTable'             => 'incentive_zip',
      'with'                  => 'ZipCodeIncentive',
      'foreignKey'            => 'zip',
      'associationForeignKey' => 'incentive_id',
    ),
  );
  
  /**
   * Retrieves the relevant incentives (rebates) for a given zip code.
   *
   * @param 	$zip_code
   * @return	array
   */
  public function incentives( $zip ) {
    # Which state owns this zip code?
    $state = $this->field( 'state', array( 'ZipCode.zip' => $zip ) );
    
    # Pull the incentives
    $incentives = $this->Incentive->find(
      'all',
      array(
        'contain'    => array(
          'ZipCode'=> array(
            'fields'     => 'ZipCode.zip',
            'conditions' => array( 'ZipCode.zip' => $zip )
          ),
        ),
        'fields' => array( 'Incentive.id', 'Incentive.name', 'Incentive.it_name', 'Incentive.amount', 'Incentive.state', 'Incentive.entire_state', 'Incentive.excluded', 'Incentive.is_active' ),
        'conditions' => array(
          'Incentive.excluded'  => 0,
          'Incentive.is_active' => 1,
          'OR' => array(
            'Incentive.state' => 'US',  # nationwide incentives
            array(
              # Incentives that apply to the entire state that owns the zip code
              'Incentive.entire_state' => 1,
              'Incentive.state'        => $state,
            ),
          )
        ),
        'order' => array( 'Incentive.amount DESC' ),
      )
    );
    
    return $incentives;
  }
}

