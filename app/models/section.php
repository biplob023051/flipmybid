<?php
class Section extends AppModel {

	var $name = 'Section';

	var $hasMany = 'Question';

	var $actsAs = array(
		'Containable',
		'Translate' => array('name')
	);

	var $validate = array(
		'name' => array(
			'rule' => array('notEmpty'),
			'message' => 'Name is a required field.'
		)
	);
}
?>
