<?php
	class Address extends AppModel {

		var $name = 'Address';

		var $actsAs = array('Containable');

		var $belongsTo = array('User', 'UserAddressType', 'Country');

		/**
		 * Constructor, redefine to use __() in validate message
		 */
		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'rule' => array('notEmpty'),
					'message' => __('Name is required.', true)
				),
				'address_1' => array(
					'rule' => array('notEmpty'),
					'message' => __('Address (line 1) is required.', true)
				),
				'city' => array(
					'rule' => array('notEmpty'),
					'message' => __('City / State is required.', true)
				),
				'country_id' => array(
					'rule' => array('notEmpty'),
					'message' => __('Please select a country from the dropdown.', true)
				)
			);
		}

		/**
		 * This function updates all the users addresses to this one
		 */
		function updateAll($data) {
			$this->UserAddressType->recursive = -1;
			$addresses = $this->UserAddressType->find('all', array('conditions' => 'UserAddressType.id != '.$data['Address']['user_address_type_id']));

			if(!empty($addresses)) {
				foreach($addresses as $address) {
					$oldAddress = $this->find('first', array('conditions' => array('Address.user_id' => $data['Address']['user_id'], 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
					if(!empty($oldAddress)) {
						// we need to update an existing record
						$data['Address']['id'] = $oldAddress['Address']['id'];
					} else {
						// we are adding a new record
						$this->create();
					}
					$data['Address']['user_address_type_id'] = $address['UserAddressType']['id'];
					$this->save($data, false);
				}
			}
		}

		function isCompleted($user_id){
			$this->UserAddressType->recursive = -1;
			$types = $this->UserAddressType->find('all');

			$isCompleted = array();

			foreach($types as $type){
				$conditions = array(
					'Address.user_id' => $user_id,
					'Address.user_address_type_id' => $type['UserAddressType']['id']
				);

				$this->contain('Country');
				$address = $this->find('first', array('conditions' => $conditions));
				if(empty($address)){
					$isCompleted = false;
					break;
				}else{
					$address['Address']['country_name'] = $address['Country']['name'];
					$isCompleted[$type['UserAddressType']['name']] = $address['Address'];
					$isCompleted[$type['UserAddressType']['id']] = $address['Address'];
				}
			}

			return $isCompleted;
		}
	}
?>
