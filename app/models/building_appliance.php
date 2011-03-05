<?php

class BuildingAppliance extends AppModel {
	public $name = 'BuildingAppliance';
	
  public $belongsTo = array( 'Building', 'Appliance' );
}
