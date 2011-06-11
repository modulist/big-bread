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
  
  /**
   * Retrieves US states.
   *
   * @return	array
   * @access	public
   */
  public function states( $county_id ) {
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
}
