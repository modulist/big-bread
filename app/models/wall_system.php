<?php

class WallSystem extends AppModel {
	public $name = 'WallSystem';

	public $hasMany = array( 'BuildingWallSystem' );
}
