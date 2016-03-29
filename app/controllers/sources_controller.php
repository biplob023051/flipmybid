<?php
class SourcesController extends AppController {

	var $name = 'Sources';
	var $helpers = array('Html', 'Form');

	function admin_index() {
		$this->Source->recursive = 0;
		$this->paginate = array('order' => 'Source.order ASC');
		$this->set('sources', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Source->create();
			if ($this->Source->save($this->data)) {
				$this->Session->setFlash(__('The Source has been saved', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Source could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Source->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Source', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Source']['id'] = $id;
			if ($this->Source->save($this->data)) {
				$this->Session->setFlash(__('The Source has been updated.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('The Source could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Source->recursive = -1;
			$this->data = $this->Source->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Source', true));
			$this->redirect(array('action'=>'index'));
		}
		$source = $this->Source->find('first', array('conditions' => array('Source.id' => $id), 'contain' => ''));
		if (empty($source)) {
			$this->Session->setFlash(__('Invalid id for Source', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('source', $source);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_saveorder() {
		Configure::write('debug', 1);
		$this->layout = 'js/ajax';
		if(!empty($_POST)){
			$data = $_POST;

			foreach($data['source'] as $order => $id){
				$source['Source']['id'] = $id;
				$source['Source']['order'] = $order;

				// Turn off the validation since the upload image behavior
				// block the saving
				$this->Source->save($source, false);
			}
		}
		$this->set('message', __('The source order has been saved successfully.', true));

	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Source', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Source->delete($id)) {
			$this->Session->setFlash(__('Source deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>