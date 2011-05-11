<?php

class Questionnaire extends AppModel {
	public $name = 'Questionnaire';
	public $belongsTo = array( 'Building' );
  
  static public $navigation = array(
    'general'         => 'General Information',
    'demographics'    => 'Demographics & Behavior',
    'equipment'       => 'Equipment Listing',
    'characteristics' => 'Building Characteristics',
    'envelope'        => 'Insulation, Windows, Doors',
  );
}
