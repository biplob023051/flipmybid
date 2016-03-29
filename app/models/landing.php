<?php
class Landing extends AppModel {

	var $name = 'Landing';

	var $actsAs = array('Containable');

	var $belongsTo = 'Product';

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'title' => array(
				'rule' => array('minLength', 1),
				'message' => __('Title is a required field.', true)
			),
			'slug' => array(
				'rule' => array('minLength', 1),
				'message' => __('Slug is a required field.', true)
			),
			'product_id' => array(
				'rule' => array('minLength', 1),
				'message' => __('Product is a required field.', true)
			)
		);
	}
}
?>
