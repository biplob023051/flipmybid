<?php
class Language extends AppModel {

	var $name = 'Language';

	var $actsAs = array('Containable');

	var $hasMany = array('Translation', 'User');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'rule' => array('notEmpty'),
				'message' => __('Language name is a required field.', true)
			),
			'code' => array(
				'rule' => array('notEmpty'),
				'message' => __('Code is a required field.', true)
			)
		);
	}
}
?>