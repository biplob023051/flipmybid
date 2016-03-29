<?php
class TranslationsController extends AppController {

	var $name = 'Translations';

	function view($id = null, $search = null) {
		if(!$this->Auth->user('translator')) {
			$this->cakeError('error404'); die;
		}

		if(!$this->Setting->Module->enabled('multi_languages')) {
			//$this->cakeError('error404');
		}

		if(!$id) {
			$this->Session->setFlash(__('Invalid Language', true));
			$this->redirect(array('controller' => 'languages', 'action'=>'index'));
		}

		$language = $this->Translation->Language->find('first', array('conditions' => array('Language.id' => $id), 'contain' => ''));

		if(empty($language)) {
			$this->Session->setFlash(__('Invalid Language', true));
			$this->redirect(array('controller' => 'languages', 'action'=>'index'));
		}

		if(!empty($this->data['Translation']['search'])) {
			$this->redirect(array('action' => 'view', $id, $this->data['Translation']['search']));
		} elseif(!empty($this->data['Translation']['msgstr'])) {
			foreach ($this->data['Translation']['msgstr'] as $key => $translation) {
				$data['Translation']['id'] = $key;
	            $data['Translation']['msgstr'] = $translation;
	            $this->Translation->save($data, false);
			}

			// now lets update the default.po file and clear the cache directories!
			$this->Translation->export($id, $language['Language']['code']);

			$this->Session->setFlash(__('The translations have been updated successfully!', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'view', $id));
		}

		$count = $this->Translation->find('count', array('conditions' => array('Translation.language_id' => $id)));

		if($count == 0) {
			// there are no translations so lets add them!
			$this->Translation->import($id, $language['Language']['code']);
		}

		$this->set('language', $language);
		$this->set('search', $search);

		// now lets list out the translations!
		if(!empty($search)) {
			$this->paginate = array('conditions' => array('Translation.language_id' => $id, "msgid LIKE '%$search%' OR msgstr LIKE '%$search%'"), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Translation.msgstr' => 'asc', 'Translation.msgid' => 'asc'), 'contain' => '');
		} else {
			$this->paginate = array('conditions' => array('Translation.language_id' => $id), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Translation.msgstr' => 'asc', 'Translation.msgid' => 'asc'), 'contain' => '');
		}

		$this->set('translations', $this->paginate());
	}

	function add($language_id = null) {
		if(!$this->Auth->user('translator')) {
			$this->cakeError('error404'); die;
		}

		if(!$this->Setting->Module->enabled('multi_languages')) {
			//$this->cakeError('error404');
		}

		if(!$language_id) {
			$this->Session->setFlash(__('Invalid Translation.', true));
			$this->redirect(array('controllers' => 'languages', 'action' => 'index'));
		}

		$this->Translation->Language->recursive = -1;
		$language = $this->Translation->Language->read(null, $language_id);
		if(empty($language)) {
			$this->Session->setFlash(__('Invalid Translation.', true));
			$this->redirect(array('controllers' => 'languages', 'action' => 'index'));
		}

		if (!empty($this->data)) {
			$this->data['Translation']['language_id'] = $language_id;

			$this->Translation->create();
			if ($this->Translation->save($this->data)) {
				// now lets update the default.po file and clear the cache directories!
				$this->Translation->export($language_id, $language['Language']['code']);

				$this->Session->setFlash(__('The translation has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $language_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the translation please review the errors below and try again.', true));
			}
		}

		$this->set('language', $language);
	}

	function admin_view($id = null, $search = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid Language', true));
			$this->redirect(array('controller' => 'languages', 'action'=>'index'));
		}

		$language = $this->Translation->Language->find('first', array('conditions' => array('Language.id' => $id), 'contain' => ''));

		if(empty($language)) {
			$this->Session->setFlash(__('Invalid Language', true));
			$this->redirect(array('controller' => 'languages', 'action'=>'index'));
		}

		if(!empty($this->data['Translation']['search'])) {
			$this->redirect(array('action' => 'view', $id, $this->data['Translation']['search']));
		} elseif(!empty($this->data['Translation']['msgstr'])) {
			foreach ($this->data['Translation']['msgstr'] as $key => $translation) {
				$data['Translation']['id'] = $key;
	            $data['Translation']['msgstr'] = $translation;
	            $this->Translation->save($data, false);
			}

			// now lets update the default.po file and clear the cache directories!
			$this->Translation->export($id, $language['Language']['code']);

			$this->Session->setFlash(__('The translations have been updated successfully!', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'view', $id));
		}

		$count = $this->Translation->find('count', array('conditions' => array('Translation.language_id' => $id)));

		if($count == 0) {
			// there are no translations so lets add them!
			$this->Translation->import($id, $language['Language']['code']);
		}

		$this->set('language', $language);
		$this->set('search', $search);

		// now lets list out the translations!
		if(!empty($search)) {
			$this->paginate = array('conditions' => array('Translation.language_id' => $id, "msgid LIKE '%$search%' OR msgstr LIKE '%$search%'"), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Translation.msgstr' => 'asc', 'Translation.msgid' => 'asc'), 'contain' => '');
		} else {
			$this->paginate = array('conditions' => array('Translation.language_id' => $id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Translation.msgstr' => 'asc', 'Translation.msgid' => 'asc'), 'contain' => '');
		}

		$this->set('translations', $this->paginate());
	}

	function admin_add($language_id = null) {
		if(!$language_id) {
			$this->Session->setFlash(__('Invalid Translation.', true));
			$this->redirect(array('controllers' => 'languages', 'action' => 'index'));
		}

		$this->Translation->Language->recursive = -1;
		$language = $this->Translation->Language->read(null, $language_id);
		if(empty($language)) {
			$this->Session->setFlash(__('Invalid Translation.', true));
			$this->redirect(array('controllers' => 'languages', 'action' => 'index'));
		}

		if (!empty($this->data)) {
			$this->data['Translation']['language_id'] = $language_id;

			$this->Translation->create();
			if ($this->Translation->save($this->data)) {
				// now lets update the default.po file and clear the cache directories!
				$this->Translation->export($language_id, $language['Language']['code']);

				$this->Session->setFlash(__('The translation has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $language_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the translation please review the errors below and try again.', true));
			}
		}

		$this->set('language', $language);
	}
}
?>