<?php

class WallSystem extends AppModel {
	var $name = 'WallSystem';

	var $hasMany = array( 'BuildingWallSystem' );
}
