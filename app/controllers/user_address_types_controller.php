<?php
class UserAddressTypesController extends AppController {

	var $name = 'UserAddressTypes';

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'));
		$this->set('types', $this->paginate());
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->UserAddressType->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Address Type', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['UserAddressType']['id'] = $id;
			if ($this->UserAddressType->save($this->data)) {
				$this->Session->setFlash(__('The address type has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem editing the address type please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->UserAddressType->recursive = -1;
			$this->data = $this->UserAddressType->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Address Type', true));
			$this->redirect(array('action'=>'index'));
		}
		$addressType = $this->UserAddressType->find('first', array('conditions' => array('UserAddressType.id' => $id), 'contain' => ''));
		if (empty($addressType)) {
			$this->Session->setFlash(__('Invalid id for Address Type', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('addressType', $addressType);
		$this->set('languages', $this->requestAction('/languages/get'));
	}
}
?>