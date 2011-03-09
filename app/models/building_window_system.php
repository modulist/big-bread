<?php

class BuildingWindowSystem extends AppModel {
	public $name = 'BuildingWindowSystem';

	public $belongsTo = array(
    'Building',
    'WindowPaneType',
    'FrameMaterial' => array(
      'className'  => 'Material',
      'foreignKey' => 'frame_material_id',
    )
  );
}
