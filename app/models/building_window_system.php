<?php

class BuildingWindowSystem extends AppModel {
	public $name = 'BuildingWindowSystem';

	public $belongsTo = array( 'Building', 'WindowSystem' );
}
