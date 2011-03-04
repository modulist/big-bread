<?php

class RoofSystem extends AppModel {
	var $name = 'RoofSystem';

	var $hasMany = array( 'BuildingRoofSystem' );
}
