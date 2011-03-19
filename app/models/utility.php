<?php

class Utility extends AppModel {
	public $name        = 'Utility';
	public $useTable    = 'utility';
	
  public $hasMany = array( 'ZipCodeUtility' );
  
  public $validate = array(
    'name' => array(
      'notempty' => array(
        'rule'       => array( 'inList', array( 'ELE', 'GAS', 'WTR' ) ),
        'message'    => 'The utility type code ("ELE", "GAS" or "WTR") must be specified.',
        'allowEmpty' => false,
        'required'   => true,
      ),
    ),
    'coverage' => array(
      'notempty' => array(
        'rule'       => 'notempty',
        'message'    => 'A coverage value must be set. When in doubt, set to 0.',
        'allowEmpty' => false,
        'required'   => true,
      ),
    ),
  );
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Determines whether a utility already exists (is known) based on name
   * and id. There's a chance that the form could produce no id (if a new
   * utility is entered from nothing) or an inconsistent id if the user
   * chooses to autocomplete and then changes the name value.
   *
   * @param 	$name
   * @param   $id
   * @return	mixed   The utility UUID, if known, or false.
   */
  public function known( $name, $id = null ) {
    $utility = $this->find(
      'first',
      array(
        'contain' => false,
        'fields'  => array( $this->alias . '.id' ),
        'conditions' => array(
          $this->alias . '.id'   => trim( $id ),
          $this->alias . '.name' => trim( $name ),
        ),
      )
    );
    
    return !empty( $utility ) ? $utility[$this->alias]['id'] : false;
  }
}
