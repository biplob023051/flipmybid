<?php
class TopicsController extends AppController {

	var $name = 'Topics';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('index', 'view');
		}
	}

	function index() {
 		$this->paginate = array('order' => array('Topic.name' => 'asc'));
		$this->set('topics', $this->paginate());

		$this->set('title_for_layout', __('Forum', true));
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Topic.', true));
			$this->redirect(array('action' => 'index'));
		}

		$topic = $this->Topic->find('first', array('conditions' => array('Topic.id' => $id)));

		if (empty($topic)) {
			$this->Session->setFlash(__('Invalid Topic.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('topic', $topic);

		// get the threads
		$this->paginate = array('conditions' => array('Post.post_id' => 0, 'Post.topic_id' => $id), 'order' => array('Post.modified' => 'desc'), 'limit' => 25, 'contain' => 'User');
		$this->set('threads', $this->paginate('Post'));

		$this->set('title_for_layout', $topic['Topic']['name']);
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'));
		$this->set('topics', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Topic->create();
			if ($this->Topic->save($this->data)) {
				$this->Session->setFlash(__('The topic has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the topic please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Topic->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Topic', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Topic']['id'] = $id;
			if ($this->Topic->save($this->data)) {
				$this->Session->setFlash(__('The topic has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('The topic could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Topic->recursive = -1;
			$this->data = $this->Topic->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Topic', true));
			$this->redirect(array('action'=>'index'));
		}
		$topic = $this->Topic->find('first', array('conditions' => array('Topic.id' => $id), 'contain' => ''));
		if (empty($topic)) {
			$this->Session->setFlash(__('Invalid id for Topic', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('topic', $topic);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Topic', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Topic->delete($id)) {
			$this->Session->setFlash(__('The topic was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>