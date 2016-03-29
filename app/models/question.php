<?php
class Question extends AppModel {

	var $name = 'Question';

	var $belongsTo = 'Section';

	var $actsAs = array(
		'Containable',
		'Translate' => array('question', 'answer')
	);

	var $validate = array(
		'question' => array(
			'rule' => array('notEmpty'),
			'message' => 'Question is a required field.'
		),
		'answer' => array(
			'rule' => array('notEmpty'),
			'message' => 'Answer is a required field.'
		)
	);
}
?>
