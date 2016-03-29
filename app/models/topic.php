<?php
class Topic extends AppModel {

	var $name = 'Topic';

	var $actsAs = array('Containable', 'Translate' => array('name', 'description'));

	var $hasMany = array('Post');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'rule' => array('notEmpty'),
				'message' => __('Topic name is a required field.', true)
			)
		);
	}
}
?>
