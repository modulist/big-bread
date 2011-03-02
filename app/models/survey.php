<?php

class Survey extends AppModel {
	var $name = 'Survey';

	var $belongsTo = array( 'Building' );
}
