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
    $energy_sources = $this->Product->Technology->TechnologyIncentive->TechnologyIncentiveEnergySource->EnergySource->find(
      'all',
      array(
        'contain' => array( 'TechnologyIncentiveEnergySource' ),
        'fields'  => array( 'EnergySource.incentive_tech_energy_type_id', 'EnergySource.name' ),
        'conditions' => array(
          'TechnologyIncentiveEnergySource.incentive_tech_id' => $technology_id,
        ),
        'order' => array( 'EnergySource.name' ),
      )
    );
    
    # new PHPDump( $energy_sources, 'Energy Sources' ); exit;
    
    $this->set( compact( 'energy_sources' ) );
  }
}
