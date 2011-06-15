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
    $cache_key    = 'State_states_' . $type;
    
    $states = Cache::read( $cache_key, $cache_config );
    
    if( $states === false ) {
      $states = $this->find(
        $type,
        array( 'contain' => false )
      );
      Cache::write( $cache_key, $states, $cache_config );
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
    if( !is_array( $state_ids ) ) {
      $state_ids = array( $state_ids );
    }
    
    $cache_config = 'week';
    $cache_key    = 'State_counties_' . join( '_', $state_ids );
    
    $counties = Cache::read( $cache_key, $cache_config );
    
    if( $counties === false ) {
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
    
    return $counties;
  }
}
