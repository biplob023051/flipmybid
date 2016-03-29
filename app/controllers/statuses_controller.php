<?php
class StatusesController extends AppController {

	var $name = 'Statuses';

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('id' => 'asc'));
		$this->set('statuses', $this->paginate());
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Status->locale = $language;
		}
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Status', true));
			$this->redirect(array('action' => 'index'));
		}
		if(!empty($this->data)) {
			$this->data['Status']['id'] = $id;
			if ($this->Status->save($this->data)) {
				$this->Session->setFlash(__('The status has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('The status could not be saved. Please, try again.', true));
			}
		}
		if(empty($this->data)) {
			$this->data = $this->Status->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Status', true));
			$this->redirect(array('action'=>'index'));
		}
		$status = $this->Status->find('first', array('conditions' => array('Status.id' => $id), 'contain' => ''));
		if (empty($status)) {
			$this->Session->setFlash(__('Invalid id for Status', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('status', $status);
		$this->set('languages', $this->requestAction('/languages/get'));
	}
}
?>
