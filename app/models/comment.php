<?php
class Comment extends AppModel {

	var $name = 'Comment';

	var $belongsTo = array('News', 'User');

	var $actsAs = array('Containable');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'comment' => array(
				'rule' => array('notEmpty'),
				'message' => __('Comment is a required field.', true)
			),
			'user_id' => array(
				'rule' => array('notEmpty'),
				'message' => __('Please login to place a comment.', true)
			),
		);
	}
}
?>
