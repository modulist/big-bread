<?php

class ProductsController extends AppController {
	public $name = 'Products';
  
  /**
   * PUBLIC FUNCTIONS
   */
  
  /**
   * Retrieves the energy sources relevant to a given product
   *
   * @param 	$product_id
   * @return	array
   */
  public function energy_sources( $product_id ) {
    $energy_sources = $this->Product->EnergySource->find(
      'all',
      array(
        'contain' => false,
        'fields'  => array( 'EnergySource.incentive_tech_energy_type_id', 'EnergySource.name' ),
        'conditions' => array(
          # 'EnergySource.active' => 1,
          'EnergySource.incentive_tech_id' => $product_id,
        ),
        'order' => array( 'EnergySource.name' ),
      )
    );
    
    $this->set( compact( 'energy_sources' ) );
  }
}
