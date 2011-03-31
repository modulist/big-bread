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
        'fields'  => array( $this->alias . '.' . $this->primaryKey ),
        'conditions' => array(
          $this->alias . '.' . $this->primaryKey => trim( $id ),
          $this->alias . '.name' => trim( $name ),
        ),
      )
    );
    
    return !empty( $utility ) ? $utility[$this->alias][$this->primaryKey] : false;
  }
}
