<?php

class RoofSystem extends AppModel {
	public $name = 'RoofSystem';

	public $hasMany = array( 'BuildingRoofSystem' );
}
