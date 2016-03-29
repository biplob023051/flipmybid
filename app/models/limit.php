<?php
	class Limit extends AppModel {

		var $name = 'Limit';

		var $actsAs = array('Translate' => array('name'));

		var $hasMany = array('Auction');

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'rule' => array('notEmpty'),
					'message' => __('Name is a required field.', true)
				),
				'limit' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'is greater', 0),
						'message' => __('Limit cannot be zero or a negative number.', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Limit can be a number only.', true)
					),
					'notEmpty' => array(
						'rule' => array('notEmpty'),
						'message' => __('Limit is a required field.', true)
					)
				),
				'days' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'is greater', 0),
						'message' => __('Days cannot be zero or a negative number.', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Days can be a number only.', true)
					),
					'notEmpty' => array(
						'rule' => array('notEmpty'),
						'message' => __('Days is a required field.', true)
					)
				)
			);
		}
	}
?>