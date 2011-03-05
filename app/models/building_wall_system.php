<?php

class BuildingWallSystem extends AppModel {
	public $name = 'BuildingWallSystem';
  
	public $belongsTo = array( 'Building', 'WallSystem', 'InsulationLevel' );
}
