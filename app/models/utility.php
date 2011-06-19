<?php

/**
 * Defines a utility provider.
 *
 * This model has a non-standard primary key, so use $this->primaryKey
 * when accessing field names or data.
 */
class Utility extends AppModel {
	public $name        = 'Utility';
	public $useTable    = 'utility';
  
  public $hasMany = array(
    'ZipCodeUtility' => array(
      'className'  => 'ZipCodeUtility',
      'foreignKey' => 'utility_id',
    ),
  );
  public $hasAndBelongsToMany = array(
    'Contractor' => array(
      'joinTable' => 'contractors_utilities', 
    ),
    'Incentive' => array(
      'className'             => 'Incentive',
      'joinTable'             => 'incentive_utility',
      'foreignKey'            => 'utility_id',
      'associationForeignKey' => 'incentive_id',
    ),
  );
  
  public $validate = array(
    'name' => array(
      'notempty' => array(
        'rule'       => 'notEmpty',
        'message'    => 'Name cannot be empty.',
        'allowEmpty' => false,
        'required'   => true,
        'last'       => true,
      ),
    ),
  );
  
  public $actsAs = array(
    'NamedScope.NamedScope' => array(
      'active' => array(
        'conditions' => array(
          'Utility.reviewed' => 1,
        )
      )
    )
  );
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Retrieves the utilities operating in a given zip code or set of zip
   * codes.
   *
   * @param 	$zip_codes  Mixed. A single zip code or an indexed array
   *                      of zip codes.
   * @return	array
   * @access	public
   */
  public function by_zip_code( $zip_codes ) {
    if( !is_array( $zip_codes ) ) {
      $zip_codes = array( $zip_codes );
    }
    
    $utilities = $this->ZipCodeUtility->find(
      'all',
      array(
        'contain'    => array( 'Utility' ),
        'conditions' => array(
          'Utility.reviewed'   => 1,
          'ZipCodeUtility.zip' => $zip_codes
        ),
        'order'      => 'Utility.name',
      )
    );
    
    # Utility companies operate across zip codes, so this result set
    # needs to be deduped. Also strip unreviewed, user-entered utilities.
    $deduped = array();
    foreach( $utilities as $i => $utility ) {
      if( in_array( $utility['Utility']['id'], $deduped ) || !$utility['Utility']['reviewed'] ) {
        unset( $utilities[$i] );
      }
      else {
        array_push( $deduped, $utility['Utility']['id'] );
      }
    }
    
    $utilities = array_values( $utilities ); # Reindex the final array
    
    return $utilities;
  }
  
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
        'fields'  => array( $this->alias . '.' . $this->primaryKey ),
        'conditions' => array(
          'OR' => array(
            $this->alias . '.' . $this->primaryKey => trim( $id ),
            $this->alias . '.name' => trim( $name ),
          ),
        ),
      )
    );
    
    return !empty( $utility ) ? $utility[$this->alias][$this->primaryKey] : false;
  }
}
