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
   * @return	array
   * @access	public
   */
  public function states() {
    $cache_config = 'week';
    $cache_key    = 'states';
    
    $states = Cache::read( $cache_key, $cache_config );
    
    if( $states === false ) {
      $states = $this->find(
        'all',
        array( 'contain' => false )
      );
      Cache::write( $cache_key, $states, $cache_config );
    }
    
    return $states;
  }

  /**
   * Retrieves a list of counties in a given state.
   *
   * @param 	$state_id   e.g. AL, OH, CA, etc.
   * @return	array
   * @access	public
   */
  public function counties( $state_id ) {
    $cache_config = 'week';
    $cache_key    = 'counties_' . strtolower( $state_id );
    
    $counties = Cache::read( $cache_key, $cache_config );
    
    if( $counties === false ) {
      $counties = $this->County->find(
        'all',
        array(
          'contain'    => false,
          'conditions' => array( 'County.state' => $state_id ),
          'order'      => 'County.county',
        )
      );
      
      Cache::write( $cache_key, $counties, $cache_config );
    }
    
    return $counties;
  }
}
