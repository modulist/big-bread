<?php

class Questionnaire extends AppModel {
	var $name = 'Questionnaire';

	var $belongsTo = array( 'Building' );
}
