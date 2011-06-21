<?php

class Tip extends AppModel {
	public $name = 'Tip';
	public $displayField = 'tip';
  
  public $actsAs = array(
    'NamedScope.NamedScope' => array(
      'active' => array(
        'conditions' => array(
          'Tip.active' => 1,
        )
      )
    )
  );
}
