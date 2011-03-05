<?php

class WindowSystem extends AppModel {
	public $name = 'WindowSystem';
  
  public $hasMany = array( 'BuildingWindowSystem' );
}
