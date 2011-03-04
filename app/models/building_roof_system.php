<?php

class BuildingRoofSystem extends AppModel {
	var $name = 'BuildingRoofSystem';
	var $belongsTo = array( 'Building', 'RoofSystem', 'InsulationLevel' );
}
