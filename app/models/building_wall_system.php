<?php

class BuildingWallSystem extends AppModel {
	var $name = 'BuildingWallSystem';
	var $belongsTo = array( 'Building', 'WallSystem', 'InsulationLevel' );
}
