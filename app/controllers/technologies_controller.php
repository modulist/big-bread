<?php

class TechnologiesController extends AppController {
	public $name = 'Technologies';
  
  /**
   * PUBLIC METHODS
   */
  
  public function beforeFilter() {
    parent::beforeFilter();

    $this->Auth->allow( '*' );
  }
  
  /**
   * Retrieves manufacturers of a given technology.
   *
   * @param 	$technology_id
   * @access	public
   */
  public function manufacturers( $technology_id ) {
    $manufacturers = $this->Technology->EquipmentManufacturer->find(
      'all',
      array(
        'contain' => false,
        'joins' => array(
          array(
            'table'      => 'equipment_manufacturers_technologies', 
            'alias'      => 'EquipmentManufacturerTechnology', 
            'type'       => 'inner', 
            'foreignKey' => false, 
            'conditions' => array(
              'EquipmentManufacturerTechnology.equipment_manufacturer_id = EquipmentManufacturer.id',
              'EquipmentManufacturerTechnology.technology_id' => $technology_id
            ),
          ),
        ),
        'order' => 'EquipmentManufacturer.name',
      )
    );
    
    
    $this->set( compact( 'manufacturers' ) );
  }
}
