<?php
class Increment extends AppModel {

	var $name = 'Increment';

	var $belongsTo = 'Auction';

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'bid' => array(
				'comparison' => array(
					'rule'=> array('comparison', '>', 0),
					'message' => __('Bid increment must be greater than zero.', true)
				),
				'numeric' => array(
					'rule'=> 'numeric',
					'message' => __('Bid increment can be a number only.', true)
				),
				'minLength' => array(
					'rule' => array('notEmpty'),
					'message' => __('Bid increment is required.', true)
				)
			),
			'price' => array(
				'comparison' => array(
					'rule'=> array('comparison', '>', 0),
					'message' => __('Price increment must be a positive number.', true)
				),
				'numeric' => array(
					'rule'=> 'numeric',
					'message' => __('Price increment can be a number only.', true)
				),
				'minLength' => array(
					'rule' => array('notEmpty'),
					'message' => __('Price increment is required.', true)
				)
			),
			'time' => array(
				'comparison' => array(
					'rule'=> array('comparison', '>=', 0),
					'message' => __('Time increment cannot be a negative.', true)
				),
				'numeric' => array(
					'rule'=> 'numeric',
					'message' => __('Time increment can be a number only.', true)
				),
				'minLength' => array(
					'rule' => array('notEmpty'),
					'message' => __('Time increment is required.', true)
				)
			),
			'low_price' => array(
				'rule'=> 'numeric',
				'message' => __('Low Price Range can be a number only.', true),
				'allowEmpty' => true
			),
			'high_price' => array(
				'rule'=> 'numeric',
				'message' => __('High Price Range can be a number only.', true),
				'allowEmpty' => true
			)
		);
	}

}
?>
