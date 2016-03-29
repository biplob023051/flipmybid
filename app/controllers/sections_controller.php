<?php
class SectionsController extends AppController {

	var $name = 'Sections';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index', 'getsections');
		}
	}

	function index($id = null, $sectionName = null, $question_id = null, $questionName = null) {
		$this->set('id', $id);
		$this->set('question_id', $question_id);

		if(!empty($question_id)) {
			$question = $this->Section->Question->find('first', array('conditions' => array('Question.id' => $question_id), 'contain' => ''));
			if(empty($question)) {
				$this->Session->setFlash(__('This question does not exist', true));
				$this->redirect(array('action' => 'index', $id, $sectionName));
			}

			$this->set('title_for_layout', $question['Question']['question']);

			$this->set('question', $question);
		}

		if(!empty($id)) {
			$section = $this->Section->find('first', array('conditions' => array('Section.id' => $id), 'contain' => ''));
			if(empty($section)) {
				$this->Session->setFlash(__('This section does not exist'));
				$this->redirect(array('action' => 'index'));
			}
			if(empty($question_id)) {
				$this->set('title_for_layout', $section['Section']['name']);
			}
		}

		$page = $this->requestAction('/pages/getpage/help');
		if(!empty($page)) {
			if(empty($id) && empty($question_id)) {
				$this->set('title_for_layout', $page['Page']['title']);
			}

	        if(!empty($page['Page']['meta_description'])) {
				$this->set('meta_description', $page['Page']['meta_description']);
			}
			if(!empty($page['Page']['meta_keywords'])) {
				$this->set('meta_keywords', $page['Page']['meta_keywords']);
			}

			$this->set('page', $page);
		}
	}

	function getsections() {
		return $this->Section->find('all', array('contain' => '', 'order' => array('Section.order' => 'asc', 'Section.name' => 'asc')));
	}

	function admin_index() {
		$sections = $this->Section->find('all');

		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Section.order' => 'asc', 'Section.name' => 'asc'));
		$this->set('sections', $this->paginate());
	}

	function admin_add() {
		if(!empty($this->data)) {
			$this->Section->create();
			if ($this->Section->save($this->data)) {
				$this->Session->setFlash(__('The section has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the section please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Section->locale = $language;
		}
		if(!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid Section');
			$this->redirect(array('action'=>'index'));
		}
		if(!empty($this->data)) {
			$this->data['Section']['id'] = $id;
			if ($this->Section->save($this->data)) {
				$this->Session->setFlash(__('The section has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem editing the section please review the errors below and try again.', true));
			}
		} else {
			$this->Section->recursive = -1;
			$this->data = $this->Section->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Section', true));
			$this->redirect(array('action'=>'index'));
		}
		$section = $this->Section->find('first', array('conditions' => array('Section.id' => $id), 'contain' => ''));
		if (empty($section)) {
			$this->Session->setFlash(__('Invalid id for Section', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('section', $section);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if(!$id) {
			$this->Session->setFlash('Invalid id for Section');
			$this->redirect(array('action'=>'index'));
		}
		if($this->Section->delete($id)) {
			$this->Session->setFlash(__('The section was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_saveorder() {
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';

		if(!empty($_POST)){
			$data = $_POST;

			foreach($data['section'] as $order => $id){
				$section['Section']['id'] = $id;
				$section['Section']['order'] = $order;

				$this->Section->save($section, false);
			}
			$this->set('message', __('The order has been saved successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->set('message', __('There was a problem updating the order.', true));
		}
	}
}
?>