<?php

class BuildingProduct extends AppModel {
	public $name = 'BuildingProduct';
	
  public $belongsTo = array( 'Building', 'Product' );
}
