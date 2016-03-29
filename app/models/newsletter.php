<?php
class Newsletter extends AppModel {

	var $name = 'Newsletter';

	var $hasMany = 'User';

	var $actsAs = array('Containable');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'subject' => array(
				'rule' => array('notEmpty'),
				'message' => __('Subject is required', true)
			),

			'body' => array(
				'rule' => array('notEmpty'),
				'message' => __('Body is required', true)
			)
		);
	}
}
?>
