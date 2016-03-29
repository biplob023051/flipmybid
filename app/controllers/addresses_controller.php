<?php
class AddressesController extends AppController {

	var $name = 'Addresses';

	function index() {
		$this->Address->UserAddressType->recursive = -1;
		$addresses = $this->Address->UserAddressType->find('all');
		$data = array();
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$data[$address['UserAddressType']['name']] = $this->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
				if(empty($data[$address['UserAddressType']['name']])) {
					$data[$address['UserAddressType']['name']] = array('Address' => array('user_address_type_id' => $address['UserAddressType']['id']));
				}
			}
		}

		$this->set('address', $data);

		$this->set('title_for_layout', __('My Addresses', true));
	}

	function add($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid address type.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Address->UserAddressType->recursive = -1;
		$addressType = $this->Address->UserAddressType->findbyId($id);
		if(empty($addressType)) {
			$this->Session->setFlash(__('Invalid address type.', true));
			$this->redirect(array('action'=>'index'));
		}
		if($this->Address->find('count', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $addressType['UserAddressType']['id']))) > 0) {
			$this->redirect(array('action'=>'edit', $id));
		}
		$this->set('addressType', $addressType);

		if(!empty($this->data)) {
			$this->data['Address']['user_id'] = $this->Auth->user('id');
			$this->data['Address']['user_address_type_id'] = $addressType['UserAddressType']['id'];
			$this->Address->create();
			if($this->Address->save($this->data)) {
				if(!empty($this->data['Address']['update_all'])) {
					$this->Address->updateAll($this->data);
				}
				$this->Session->setFlash(__('The address was successfully added.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		}

		$this->set('countries', $this->Address->Country->find('list', array('order' => array('Country.show_first' => 'desc', 'Country.name' => 'asc'))));

		$this->set('title_for_layout', __('Add an Address', true));
	}

	function edit($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid address type.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Address->UserAddressType->recursive = -1;
		$addressType = $this->Address->UserAddressType->findbyId($id);
		if(empty($addressType)) {
			$this->Session->setFlash(__('Invalid address type.', true));
			$this->redirect(array('action'=>'index'));
		}
		if($this->Address->find('count', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $addressType['UserAddressType']['id']))) == 0) {
			$this->redirect(array('action'=>'add', $id));
		}
		$this->set('addressType', $addressType);

		if(!empty($this->data)) {
			$this->data['Address']['user_id'] = $this->Auth->user('id');
			$this->data['Address']['user_address_type_id'] = $addressType['UserAddressType']['id'];
			if($this->Address->save($this->data)) {
				if(!empty($this->data['Address']['update_all'])) {
					$this->Address->updateAll($this->data);
				}
				$this->Session->setFlash(__('The address has been successfully updated.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		} else {
			$this->data = $this->Address->find('first', array('conditions' => array('user_address_type_id' => $addressType['UserAddressType']['id'], 'user_id' => $this->Auth->user('id'))));
		}

		$this->set('countries', $this->Address->Country->find('list', array('order' => array('Country.show_first' => 'desc', 'Country.name' => 'asc'))));
		$this->set('title_for_layout', __('Edit an Address', true));
	}

	function get($user_type_id = null, $user_id = null) {
		return $this->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $user_type_id), 'contain' => 'Country'));
	}
}
?>