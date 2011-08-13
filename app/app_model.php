<?php

class AppModel extends Model {
  public $actsAs = array( 'Nullable', 'Containable' );

  /**
   * OVERRIDES
   */

  /**
   * Override Model::deconstruct() in order to use an integrated date
   * value, but multipart time value. The parent method expects both
   * date and time to be segmented, but, if a date picker is used to
   * select the date, then that component is unified.
   *
   * In order to use what's already in place, we'll deconstruct the date
   * portion here and then pass everything to the parent method for
   * reassimilation.
   *
   * @param   string  $field  The name of the field to be deconstructed
   * @param   mixed   $data   An array or object to be deconstructed into a field
   * @return  mixed           The resulting data that should be assigned to a field
   * @access  protected
   */
  public function deconstruct( $field, $data ) {
    $type = $this->getColumnType( $field );
    
    if( in_array( $type, array( 'datetime', 'timestamp' ) ) ) {
      if( isset( $data['date'] ) && !empty( $data['date'] ) ) {
        $date = date( 'U', strtotime( $data['date'] ) );
        
        if( $date ) {
          $data['month'] = date( 'm', $date );
          $data['day']   = date( 'd', $date );
          $data['year']  = date( 'Y', $date );
        }
      }
    }
    
    return parent::deconstruct( $field, $data );
  }
  
  /**
   * CALLBACK METHODS
   */
  
  /**
   * CakePHP's afterFind callback.
   *
   * @param 	$results
   * @param   $primary
   * @return	mixed
   * @access	public
   */
  public function afterFind( $results, $primary = false ) {
    # Massage aggregated result values so they're less awkward
    if( !empty( $results ) ) {
      foreach( $results as $i => $result ) {
        # Sometimes a find call just returns a string which can be
        # accessed as an array. Ignore such results. In an array of
        # results, aggregated values will be stored in a "0" index.
        # This is what we want to extract and restore as a property
        # of the parent object.
        if( !is_string( $result ) && !empty( $result[0] ) ) {
          foreach( $result[0] as $field => $value ) { # aggregated field alias => aggregate value
            if( !empty( $result[$this->alias][$field] ) ) {
              $field = 'aggregated_' . $field;
            }
            
            $results[$i][$this->alias][$field] = $value;
          }
          
          unset( $results[$i][0] ); # Unset the awkward array element
        }
      }
    }
    
    return parent::afterFind( $results, $primary );
  }
  
  /**
   * VALIDATION METHODS
   */
  
  /**
   * Validates a datetime value by acting as a decorator for native
   * Validation::date() and Validation::time() methods.
   *
   * @param   $check    array   field_name => value
   * @param   $options  array   Options for this rule
   * @return  boolean
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
   * PUBLIC METHODS
   */
  
  /**
   * Returns the current user object/array. Useful in the context of
   * the Auditable behavior.
   *
   * @return    mixed   null if empty,
   *                    an array if no property is specified,
   *                    a scalar if a property is specified
   * @access    public
   */
  public function current_user( $property = null ) {
    return User::get( $property );
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
