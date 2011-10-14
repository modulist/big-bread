<?php

class ZipCode extends AppModel {
	public $name       = 'ZipCode';
	public $useTable   = 'us_zipcode';
	public $primaryKey = 'zip';

  public $hasMany = array(
		'ZipCodeIncentive' => array(
			'className' => 'ZipCodeIncentive',
			'foreignKey' => 'zip',
		),
    'ZipCodeUtility' => array(
      'className'  => 'ZipCodeUtility',
      'foreignKey' => 'zip',
    ),
  );
	public $hasOne = array(
		'Address' => array( 'foreignKey' => 'zip_code' ),
    'State'   => array( 'foreignKey' => 'state' ),
	);
  public $hasAndBelongsToMany = array(
    'Incentive' => array(
      'className'             => 'Incentive',
      'joinTable'             => 'incentive_zips',
      'foreignKey'            => 'zip',
      'associationForeignKey' => 'incentive_id',
    ),
  );
  
  /**
   * Returns the state that owns a given zip code.
   *
   * @param 	$zip_code
   * @return	string
   * @access	public
   */
  public function state( $zip_code ) {
    return $this->field( 'state', array( 'ZipCode.zip' => $zip_code ) );
  }
  
  /**
   * Returns the locale (city, state) for a given zip code
   *
   * @param 	$zip
   * @return	array
   * @access	public
   */
  public function locale( $zip ) {
    return $this->find(
      'first',
      array(
        'contain'    => false,
        'fields'     => array( 'ZipCode.city', 'ZipCode.state' ),
        'conditions' => array( 'ZipCode.zip' => $zip ),
      )
    );
  }
  
  /**
   * Returns the total savings available for a given zip code. The
   * number returned includes only those incentives measured in USD.
   *
   * @param 	$zip_code
   * @param   $grouped    Whether to itemize the total savings by
   *                      technology group or return just the sum.
   * @param   $group_id   A technology group id if only the savings
   *                      for a single group is desired.
   * @return	mixed
   * @access	public
   */
  public function savings( $zip_code, $grouped = true, $group_code = null ) {
    $savings = ClassRegistry::init( 'TechnologyGroup' )->find(
      'all',
      array(
        'contain' => false,
        'fields'  => array(
          'TechnologyGroup.id',
          'TechnologyGroup.incentive_tech_group_id as code',
          'TechnologyGroup.name',
          'SUM( TechnologyIncentive.amount) savings',
        ),
        'group'   => array(
          'TechnologyGroup.id',
          'TechnologyGroup.incentive_tech_group_id',
          'TechnologyGroup.name',
        ),
        'conditions' => array(
          'IncentiveAmountType.incentive_amount_type_id' => 'USD',
          'TechnologyIncentive.is_active' => 1,
          'Incentive.excluded' => 0,
          'OR' => array(
            'Incentive.expiration_date' => null, 
            'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
          ),
          'OR' => TechnologyIncentive::geo_scope_conditions( $zip_code ),
        ),
        'joins' => array(
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'TechnologyGroup.id = Technology.technology_group_id',
          ),
          array(
            'table'      => 'technology_incentives',
            'alias'      => 'TechnologyIncentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'Technology.id = TechnologyIncentive.technology_id',
          ),
          array(
            'table'      => 'incentive',
            'alias'      => 'Incentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'TechnologyIncentive.incentive_id = Incentive.id',
          ),
          array(
            'table'      => 'incentive_amount_types',
            'alias'      => 'IncentiveAmountType',
            'type'       => 'inner',
            'foreignKey' => 'false',
            'conditions' => 'TechnologyIncentive.incentive_amount_type_id = IncentiveAmountType.id',
          ),
        ),
      )
    );
    
    if( !$grouped && empty( $group_code ) ) { # We just want the big number
      $savings = array_sum( Set::extract( '/TechnologyGroup/savings', $savings ) );
    }
    else if( $grouped ) {
      $savings = Set::combine( $savings, '{n}.TechnologyGroup.code', '{n}.TechnologyGroup' );
      
      if( !empty( $group_code ) ) {
        $savings = $savings[$group_code]['savings'];
      }
    }
    
    return $savings;
  }
  
  /**
   * Returns the top incentives in a given zip code for a given technology
   * group.
   *
   * @param   $zip_code
   * @return  array
   * @access  public
   */
  public function featured_rebates( $zip_code, $technology_group_id = null ) {
    if( empty( $technology_group_id ) ) {
      $technology_group_id = ClassRegistry::init( 'TechnologyGroup' )->field(
        'id',
        array( 'TechnologyGroup.incentive_tech_group_id' => 'HVAC' )
      );
    }
    
    # Find top 2 manufacturer incentives
    $manufacturer_rebates = ClassRegistry::init( 'TechnologyIncentive' )->find(
      'all',
      array(
        'contain' => array( 'Incentive', 'Technology' ),
        'fields'  => array(
          'Incentive.name',
          'TechnologyIncentive.amount',
        ),
        'conditions' => array(
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
          'Technology.technology_group_id' => $technology_group_id,
          'Incentive.incentive_type_id' => 'MANU',
          'OR' => array(
            'Incentive.expiration_date' => null, 
            'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
          ),
          'OR' => TechnologyIncentive::geo_scope_conditions( $zip_code ),
        ),
        'order'      => array( 'TechnologyIncentive.amount DESC' ),
        'limit'      => 20,
      )
    );
    $manufacturer_rebates = array_slice( Set::combine( $manufacturer_rebates, '{n}.Incentive.name', '{n}.TechnologyIncentive.amount' ), 0, 2 );
    
    # Fine top 2 non-manufacturer incentives
    $non_manufacturer_rebates = ClassRegistry::init( 'TechnologyIncentive' )->find(
      'all',
      array(
        'contain' => array( 'Incentive', 'Technology' ),
        'fields'  => array(
          'Incentive.name',
          'TechnologyIncentive.amount',
        ),
        'conditions' => array(
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1,
          'Technology.technology_group_id' => $technology_group_id,
          'Incentive.incentive_type_id <>' => 'MANU',
          'OR' => array(
            'Incentive.expiration_date' => null, 
            'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
          ),
          'OR' => TechnologyIncentive::geo_scope_conditions( $zip_code ),
        ),
        'order'      => array( 'TechnologyIncentive.amount DESC' ),
        'limit'      => 20,
      )
    );
    
    $non_manufacturer_rebates = array_slice( Set::combine( $non_manufacturer_rebates, '{n}.Incentive.name', '{n}.TechnologyIncentive.amount' ), 0, 3 );
  
    return array_merge( $manufacturer_rebates, $non_manufacturer_rebates );
  }
  
  /**
   * Returns the id of each incentive specifically targeting a
   * particular zip code.
   *
   * THIS METHOD DOES NOT RETURN ALL INCENTIVES OR EVEN ALL INCENTIVE
   * DATA. IDs ONLY AND ONLY FOR THOSE INCENTIVES THAT TARGET A
   * SPECIFIC ZIP CODE.
   *
   * @param 	$zip_code
   * @return	array
   * @access	public
   */
  public function incentives( $zip_code ) {
    $cache_config = 'day';
    $cache_key    = strtolower( 'zipcode_incentives_' . $zip_code );
    
    $zip_code_incentives = Cache::read( $cache_key, $cache_config );
    
    if( $zip_code_incentives === false ) {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{ZipCode::incentives} Running query for incentives (cache key: ' . $cache_key . ')', LOG_DEBUG );
      
      $zip_code_incentives = $this->ZipCodeIncentive->find(
        'all',
        array(
          'fields' => array( 'DISTINCT ZipCodeIncentive.incentive_id'),
          'conditions' => array( 'ZipCodeIncentive.zip' => $zip_code ),
        )
      );
      
      $zip_code_incentives = Set::extract( '/ZipCodeIncentive/incentive_id', $zip_code_incentives );
      
      Cache::write( $cache_key, $zip_code_incentives, $cache_config );
    }
    else {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{ZipCode::incentives} Pulling incentives data from cache (cache key: ' . $cache_key . ')', LOG_DEBUG );
    }
    
    return $zip_code_incentives;
  }
  
  /**
   * Retrieves the known utility providers for a given zip code.
   *
   * @param   $zip
   * @param   $type
   * @return  array
   */
  public function utilities( $zip, $type ) {
    $type = ucwords( $type );
    
    if( !in_array( $type, array( 'Electricity', 'Gas', 'Water' ) ) ) {
      return false;
    }
    
    $type_code = ZipCodeUtility::$type_code_reverse_lookup[$type];
    $utilities = $this->ZipCodeUtility->find(
      'all',
      array(
        'recursive'  => 0,
        'fields'     => array( 'Utility.id', 'Utility.name' ),
        'conditions' => array(
          'Utility.reviewed'    => 1,
          'ZipCodeUtility.zip'  => $zip,
          'ZipCodeUtility.type' => $type_code
        ),
      )
    );
    
    $type = array( 'code' => $type_code, 'name' => $type );
    
    return array( 'Type' => $type, 'Utilities' => $utilities );
  }
}

