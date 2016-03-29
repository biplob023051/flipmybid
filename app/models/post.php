<?php
class Post extends AppModel {

	var $name = 'Post';

	var $actsAs = array('Containable');

	var $belongsTo = array('Auction', 'Topic', 'User');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'topic_id' => array(
				'rule' => array('notEmpty'),
				'message' => __('Topic is required.', true)
			),
			'title' => array(
				'rule' => array('notEmpty'),
				'message' => __('Title is a required field.', true)
			),
			'content' => array(
				'rule' => array('notEmpty'),
				'message' => __('Content is a required field.', true)
			)
		);
	}
}
?>
