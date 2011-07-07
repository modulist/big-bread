<?php

class State extends AppModel {
	public $name         = 'State';
	public $useTable     = 'us_states';
	public $primaryKey   = 'code';
	public $displayField = 'state';
	
  public $belongsTo = array(
    'ZipCode' => array(
      'foreignKey' => 'state',
    ),
  );
  
  public $hasMany = array(
    'County' => array(
      'foreignKey' => 'state',
    ),
  );
  
  /**
   * Retrieves US states.
   *
   * @param   $type   Find type (all|list)
   * @return	array
   * @access	public
   */
  public function states( $type = 'all' ) {
    $cache_config = 'week';
    $cache_key    = strtolower( 'state_states_' . $type );
    
    $states = Cache::read( $cache_key, $cache_config );
    
    if( $states === false ) {
      if( Configure::read( 'debug' ) > 0 ) $this->log( '{State::states} Running query for states (' . $type . ')', LOG_DEBUG );
      $states = $this->find(
        $type,
        array( 'contain' => false )
      );
      Cache::write( $cache_key, $states, $cache_config );
    }
    else {
      if( Configure::read( 'debug' ) > 0 ) $this->log( '{State::states} Pulled state data (' . $type . ') from cache.', LOG_DEBUG );
    }
    
    return $states;
  }

  /**
   * Retrieves a list of counties in a given state.
   *
   * @param 	$state_ids   e.g. AL, OH, CA, etc.
   * @return	array
   * @access	public
   */
  public function counties( $state_ids ) {
    if( empty( $state_ids ) ) {
      return array();
    }
    
    if( !is_array( $state_ids ) ) {
      $state_ids = array( $state_ids );
    }
    
    $cache_config = 'week';
    $cache_key    = strtolower( 'state_counties_' . join( '_', $state_ids ) );
    
    $counties = Cache::read( $cache_key, $cache_config );
    
    if( $counties === false ) {
      if( Configure::read( 'debug' ) > 0 ) $this->log( '{State::counties} Running query for ' . join( ', ', $state_ids ), LOG_DEBUG );
      $counties = $this->County->find(
        'all',
        array(
          'contain'    => array( 'State' ),
          'conditions' => array( 'County.state' => $state_ids ),
          'order'      => array( 'State.state', 'County.county' ),
        )
      );
      
      Cache::write( $cache_key, $counties, $cache_config );
    }
    else {
      if( Configure::read( 'debug' ) > 0 ) $this->log( '{States::counties} Pulling counties (' . join( ', ', $state_ids ) . ') from cache.', LOG_DEBUG );
    }
    
    return $counties;
  }
}
