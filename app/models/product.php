<?php
	class Product extends AppModel {

		var $name = 'Product';

		var $actsAs = array('Containable',
							'Translate' => array('title', 'meta_description', 'meta_keywords', 'brief', 'description', 'delivery_information'),
					  		);

		var $belongsTo = array(
			'Category' => array(
				'className'  => 'Category',
				'foreignKey' => 'category_id'
			), 'Status'
		);

		var $hasMany = array(
			'Auction'  => array(
				'className'  => 'Auction',
				'foreignKey' => 'product_id',
				'dependent'  => true
			),
			'Image' 	 => array(
				'className'  => 'Image',
				'foreignKey' => 'product_id',
				'order' 	 => array('order' => 'asc'),
				'dependent'  => true,
			)
		);

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'title' => array(
					'rule' => array('notEmpty'),
					'message' => __('Product title is a required field.', true)
				),
				'category_id' => array(
					'rule' => array('notEmpty'),
					'message' => __('Please select a category from the dropdown.', true)
				),
				'rrp' => array(
					'rule'=> 'numeric',
					'message' => __('RRP can be a number only.', true),
					'allowEmpty' => true
				),
				'start_price' => array(
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Start price can be a number only.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Start price is required.', true)
					)
				),
				'fixed_price' => array(
					'rule'=> 'numeric',
					'message' => __('Fixed price can be a number only.', true),
					'allowEmpty' => true
				),
				'exchange' => array(
					'rule'=> 'numeric',
					'message' => __('Buy Now can be a number only.', true),
					'allowEmpty' => true
				),
				'reward_points' => array(
					'rule'=> 'numeric',
					'message' => __('Reward Points can be a number only.', true),
					'allowEmpty' => true
				),
				'win_points' => array(
					'rule'=> 'numeric',
					'message' => __('Win Points can be a number only.', true),
					'allowEmpty' => true
				)
			);

		}

		function afterFind($results, $primary = false){
			// Parent method redefined
			$results = parent::afterFind($results, $primary);

			if(!empty($results)){
				// Getting rate for current currency
				$rate = $this->_getRate();

				// This for find('all')
				if(!empty($results[0]['Product'])){
					// Loop over find result and convert the price with rate
					foreach($results as $key => $result){
						if(!empty($results[$key]['Product']['rrp'])){
							$results[$key]['Product']['rrp'] = $result['Product']['rrp'] * $rate;
						}
					}

				// This for find('first')
				}elseif(!empty($results['Product'])){
					if(!empty($results['Product']['rrp'])){
						$results['Product']['rrp'] = $results['Product']['rrp'] * $rate;
					}
				}
			}

			// Return back the results
			return $results;
		}

		function beforeSave(){
			// Price currency rate revert back to application default (USD)
			// Get the rate
			$rate = 1 / $this->_getRate();

			// Convert it back to USD
			if(!empty($this->data['Product']['rrp'])){
				$this->data['Product']['rrp'] = $this->data['Product']['rrp'] * $rate;
			}

			return true;
		}
	}
?>