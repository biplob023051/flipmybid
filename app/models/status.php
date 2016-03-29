<?php
class Status extends AppModel {

	var $name = 'Status';

	var $hasMany = 'Auction';

	var $actsAs = array(
		'Containable',
		'Translate' => array('name', 'message')
	);

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'name' => array(
				'rule' => array('notEmpty'),
				'message' => __('Name is a required field.', true)
			),
		);
	}
}
?>
