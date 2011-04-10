<?php

class ProductsController extends AppController {
	public $name = 'Products';
  
  /**
   * PUBLIC FUNCTIONS
   */
  
  /**
   * Retrieves the energy sources relevant to a given product
   *
   * @param 	$technology_id
   * @return	array
   */
  public function energy_sources( $technology_id ) {
    $energy_sources = $this->Product->Technology->EnergySource->find(
      'all',
      array(
        'contain' => false,
        'fields'  => array( 'EnergySource.incentive_tech_energy_type_id', 'EnergySource.name' ),
        'conditions' => array( 'EnergySource.technology_id' => $technology_id ),
        'order' => array( 'EnergySource.name' ),
      )
    );
    
    # new PHPDump( $energy_sources, 'Energy Sources' ); exit;
    
    $this->set( compact( 'energy_sources' ) );
  }
}
