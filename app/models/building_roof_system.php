<?php

class BuildingRoofSystem extends AppModel {
	public $name = 'BuildingRoofSystem';
  
	public $belongsTo = array( 'Building', 'RoofSystem' );
}
