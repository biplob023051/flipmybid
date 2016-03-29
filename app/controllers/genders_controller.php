<?php
class GendersController extends AppController {

	var $name = 'Genders';

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'));
		$this->set('genders', $this->paginate());
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Gender->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Gender', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Gender']['id'] = $id;
			if ($this->Gender->save($this->data)) {
				$this->Session->setFlash(__('The gender has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem editing the gender please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Gender->recursive = -1;
			$this->data = $this->Gender->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Gender', true));
			$this->redirect(array('action'=>'index'));
		}
		$gender = $this->Gender->find('first', array('conditions' => array('Gender.id' => $id), 'contain' => ''));
		if (empty($gender)) {
			$this->Session->setFlash(__('Invalid id for Gender', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('gender', $gender);
		$this->set('languages', $this->requestAction('/languages/get'));
	}
}
?>