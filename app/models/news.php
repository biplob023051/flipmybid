<?php
class News extends AppModel {

	var $name = 'News';

	var $hasMany = 'Comment';

	var $actsAs = array(
		'Containable',
		'Translate' => array('title', 'meta_description', 'meta_keywords', 'brief', 'content')
	);

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'title' => array(
				'rule' => array('notEmpty'),
				'message' => __('Title is a required field.', true)
			),
			'brief' => array(
				'rule' => array('notEmpty'),
				'message' => __('Brief is a required field.', true)
			),
			'content' => array(
				'rule' => array('notEmpty'),
				'message' => __('Description is a required field.', true)
			)
		);
	}
}
?>
