<?php
class LanguagesController extends AppController {

	var $name = 'Languages';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('get', 'select');
		}
	}

	function get() {
		return $this->Language->find('all', array('order' => array('Language.default' => 'desc', 'Language.name' => 'asc'), 'contain' => ''));
	}

	function select($language = null) {
		$this->Cookie->write('language', $language, false, '30 Days');
		$this->Cookie->delete('theme');

		$lang = $this->Language->find('first', array('conditions' => array('Language.code' => $language), 'recursive' => -1, 'fields' => 'theme'));
		if(!empty($lang['Language']['theme'])) {
			$this->Cookie->write('theme', $lang['Language']['theme'], true, '30 Days');
		}

		if($this->Auth->user('id')) {
			$lang = Cache::read('lang_'.$language);

			if(empty($lang)) {
				$this->Language->recursive = -1;
				$lang = $this->Language->findbyCode($language);
			}

			$user['User']['id'] = $this->Auth->user('id');
			if(!empty($lang['Language']['default'])) {
				$user['User']['language_id'] = 0;
			} else {
				$user['User']['language_id'] = $lang['Language']['id'];
			}

			$this->Language->User->save($user, false);
		}

		$this->redirect($this->referer('/'));
	}

	function index() {
		if(!$this->Auth->user('translator')) {
			$this->cakeError('error404'); die;
		}

		if(!$this->Setting->Module->enabled('multi_languages')) {
			$this->cakeError('error404'); die;
		}

		$this->paginate = array('limit' => $this->appConfigurations['pageLimit'], 'order' => array('Language.default' => 'desc', 'Language.name' => 'asc'));
		$this->set('languages', $this->paginate());
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Language.default' => 'desc', 'Language.name' => 'asc'));
		$this->set('languages', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Language->create();
			if ($this->Language->save($this->data)) {
				$this->Session->setFlash(__('The language has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the language please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Language', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Language']['id'] = $id;
			if ($this->Language->save($this->data)) {
				$this->Session->setFlash(__('The language has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The language could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Language->recursive = -1;
			$this->data = $this->Language->read(null, $id);
		}

		$this->set('id', $id);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Language', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Language->delete($id)) {
			$this->Session->setFlash(__('The language was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>