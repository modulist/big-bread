<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
  public $actsAs = array( 'Nullable', 'Containable' );
  
	/**
	 * Validates the model data. This function can be called independently
	 * on any model for validation independent of a save operation. It
	 * can also be overridden by any given model to also validate associated
	 * models.
	 *
	 * @param 	$data
	 * @return	array
	 * @access  public
	 */
	public function validate( $data = array() ) {
		$this->set( $data );

		return !$this->validates() ? $this->invalidFields() : array();
	}

	/**
	 * Returns the current user object/array. Useful in the context of
	 * the Auditable behavior.
	 *
	 * @return		array     Returns null if no
	 * @access    protected
	 * @todo      Detect Auth user model automatically?
	 */
	public function current_user() {
		$user = isset( $this->data['User'] )
      ? $this->data['User']
      : null;
      
    return $user;
	}
  
	/**
	 * Validates a datetime value by acting as a decorator for native
	 * Validation::date() and Validation::time() methods.
	 *
	 * @param		$check		array		field_name => value
	 * @param		$options	array		Options for this rule
	 * @return	boolean
	 * @access  public
	 */
	public function datetime( $check, $options ) {
		$check    = array_shift( array_values( $check ) );
		$datetime = strtotime( $check );
		
		if( $datetime !== false ) {
			return Validation::date( date( 'Y-m-d', $datetime ), 'ymd' ) && Validation::time( date( 'H:i', $datetime ) );
		}
		
		return false;
	}
  
  /**
   * Custom validation method specific to integers.
   *
   * @param   $field
   * @access  public
   */
  public function integer( $field = array() ) {
    foreach( $field as $key => $value ) { 
      if( !preg_match( '/^\d+$/', $value ) ) {
        return false; 
      }
      else { 
        continue; 
      } 
    }
    
    return true; 
  }
  
  /**
   * Returns the generated SQL executed during the request.
   *
   * @return array
   * @access public
   */
  public function sql() {
    return $this->getDataSource()->getLog( false, false );
  }
}
