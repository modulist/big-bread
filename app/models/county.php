<?php

class County extends AppModel {
	public $name         = 'County';
	public $useTable     = 'us_county';
	public $displayField = 'county';
	
	public $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state',
		),
	);

	public $hasAndBelongsToMany = array(
		'ZipCode' => array(
			'className' => 'ZipCode',
			'joinTable' => 'us_county__us_zipcode',
			'foreignKey' => 'us_county_id',
			'associationForeignKey' => 'us_zipcode_zip',
			'unique' => true,
		),
	);
  
  /**
   * Retrieves the zip codes in a given county.
   *
   * @param 	$county_id
   * @return	array
   * @access	public
   */
  public function zip_codes( $county_id ) {
    $cache_config = 'week';
    $cache_key    = strtolower( 'county_zipcodes_' . $county_id );
    
    $zip_codes = Cache::read( $cache_key, $cache_config );
    
    if( $zip_codes === false ) {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{County::zip_codes} Running query for zip codes (cache key: ' . $cache_key . ')', LOG_DEBUG );
      
      $zip_codes = $this->find(
        'first',
        array(
          'contains'   => array( 'ZipCode' ),
          'conditions' => array( 'County.id' => $county_id ),
        )
      );
      Cache::write( $cache_key, $zip_codes, $cache_config );
    }
    else {
      if( Configure::read( 'Env.code' ) != 'PRD' ) $this->log( '{County::zip_codes} Pulling zip code data from cache (cache key: ' . $cache_key . ')', LOG_DEBUG );
    }
    
    return $zip_codes;
  }
}
