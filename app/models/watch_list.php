<?php

class WatchList extends AppModel {
	public $name = 'WatchList';

	public $belongsTo = array(
		'User',
		'Technology' => array(
			'className' => 'Technology',
			'foreignKey' => 'foreign_key',
			'conditions' => array( 'WatchList.model' => 'Technology' ),
		)
	);
  
  /**
   * PUBLIC METHODS
   */
  
  public function __construct( $id = false, $table = null, $ds = null ) {
    parent::__construct( $id, $table, $ds );
    
    # Generate a whitelist that doesn't require me to make an update every time
    # I add a property...unless I don't want that property to be batch updated.
    $this->whitelist = array_diff( array_keys( $this->schema() ), array( 'id', 'created', 'modified' ) );
  }
}
