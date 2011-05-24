<?php

class ZipCodeUtility extends AppModel {
  public $name       = 'ZipCodeUtility';
  public $useTable   = 'utility_zip';
  
  public $belongsTo = array(
    'ZipCode' => array(
      'foreignKey' => 'zip'
    ),
    'Utility',
  );
  
  public $validate = array(
    'zip' => array(
			'postal' => array(
				'rule'       => array( 'postal', null, 'us' ),
				'message'    => 'Zip code must be a valid US postal code.',
				'allowEmpty' => false,
				'required'   => true,
			),
    ),
    'state' => array(
      'notempty' => array(
        'rule'       => 'notempty',
        'message'    => 'State cannot be empty.',
        'allowEmpty' => false,
        'required'   => true,
      ),
    ),
    'type' => array(
      'enum' => array(
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
  
  static public $type_codes = array(
    'ELE' => 'Electricity',
    'GAS' => 'Gas',
    'WTR' => 'Water',
  );
  static public $type_code_reverse_lookup = null;
  
  public function __construct() {
    parent::__construct();
    
    /** populate the reverse lookup */
    self::$type_code_reverse_lookup = array_flip( self::$type_codes );
  }
}
