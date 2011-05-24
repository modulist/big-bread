<?php

# TODO: Change to ProductCatalog
class Product extends AppModel {
	public $name = 'Product';
  
	public $hasMany   = array( 'BuildingProduct' );
	public $belongsTo = array(
    'Technology' => array(
      'fields'     => array( 'id', 'technology_group_id', 'name', 'description' ),
      'conditions' => array( 'Technology.questionnaire_product' => 1 ),
    ),
    'EnergySource' => array(
      'fields'     => array( 'incentive_tech_energy_type_id', 'incentive_tech_energy_group_id', 'name', 'description' ),
    ),
  );
  
  public $validate = array(
		'make' => array(
			'notempty' => array(
				'rule'       => 'notempty',
				'message'    => 'Make cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'model' => array(
			'notempty' => array(
				'rule'       => 'notempty',
				'message'    => 'Model cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'energy_source_id' => array(
			'notempty' => array(
				'rule'       => 'notempty',
				'message'    => 'Energy source cannot be empty.',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
  );
  
  /**
   * PUBLIC METHODS
   */

  /**
   * Determines whether a product already exists in the catalog based on
   * a make, model, energy source combo.
   *
   * @param 	$make
   * @param   $model
   * @param   $energy_source
   * @return	mixed            The product identifier if the combination
   *                           exists, false otherwise.
   */
  public function known( $make, $model, $energy_source ) {
    $product = $this->find(
      'first',
      array(
        'contain' => false,
        'fields'  => array( $this->alias . '.id' ),
        'conditions' => array(
          $this->alias . '.make'             => $make,
          $this->alias . '.model'            => $model,
          $this->alias . '.energy_source_id' => $energy_source
        ),
      )
    );
    
    return !empty( $product ) ? $product[$this->alias]['id'] : false;
  }
}
