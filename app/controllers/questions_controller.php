<?php
class QuestionsController extends AppController {

	var $name = 'Questions';

	var $helpers = array('Fck');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('getquestions');
		}
	}

	function getquestions($section_id = null) {
		return $this->Question->find('all', array('conditions' => array('Question.section_id' => $section_id), 'contain' => '', 'order' => array('Question.order' => 'asc', 'Question.question' => 'asc')));
	}

	function admin_view($section_id = null) {
		if(empty($section_id)) {
			$this->Session->setFlash(__('Invalid Section.', true));
			$this->redirect(array('controllers' => 'sections', 'action' => 'index'));
		}
		$section = $this->Question->Section->read(null, $section_id);
		if(empty($section)) {
			$this->Session->setFlash(__('Invalid Section.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('section', $section);

		$this->paginate = array('conditions' => array('Question.section_id' => $section_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Question.order' => 'asc', 'Question.question' => 'asc'));
		$this->set('questions', $this->paginate());
	}

	function admin_add($section_id = null) {
		if(empty($section_id)) {
			$this->Session->setFlash(__('Invalid Section.', true));
			$this->redirect(array('controllers' => 'sections', 'action' => 'index'));
		}
		$section = $this->Question->Section->read(null, $section_id);
		if(empty($section)) {
			$this->Session->setFlash(__('Invalid Section.', true));
			$this->redirect(array('controllers' => 'sections', 'action' => 'index'));
		}
		$this->set('section', $section);

		if(!empty($this->data)) {
			$this->data['Question']['section_id'] = $section_id;
			$this->Question->create();
			if ($this->Question->save($this->data)) {
				$this->Session->setFlash(__('The question has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $section_id));
			} else {
				$this->Session->setFlash('There was a problem adding the question please review the errors below and try again.');
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Question->locale = $language;
		}
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Question', true));
			$this->redirect(array('controller' => 'sections', 'action' => 'index'));
		}
		$section = $this->Question->read(null, $id);
		$this->set('section', $section);

		if(!empty($this->data)) {
			$this->data['Question']['id'] = $id;
			if ($this->Question->save($this->data)) {
				$this->Session->setFlash(__('The question has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $section['Question']['section_id']));
				} else {
					$this->redirect(array('action'=>'view', $section['Question']['section_id']));
				}
			} else {
				$this->Session->setFlash(__('There was a problem editing the question please review the errors below and try again.', true));
			}
		} else {
			$this->data = $section;
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Question', true));
			$this->redirect(array('action'=>'index'));
		}
		$question = $this->Question->find('first', array('conditions' => array('Question.id' => $id), 'contain' => 'Section'));
		if (empty($question)) {
			$this->Session->setFlash(__('Invalid id for Question', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('question', $question);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if(!$id) {
			$this->Session->setFlash('Invalid id for Question');
			$this->redirect(array('controllers' => 'sections', 'action' => 'index'));
		}
		$section = $this->Question->read(null, $id);
		if(empty($section)) {
			$this->Session->setFlash('Invalid id for Question');
			$this->redirect(array('controllers' => 'sections', 'action' => 'index'));
		}
		if($this->Question->delete($id)) {
			$this->Session->setFlash(__('The question was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'view', $section['Section']['id']));
		}
	}

	function admin_saveorder() {
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';

		if(!empty($_POST)){
			$data = $_POST;

			foreach($data['question'] as $order => $id){
				$section['Question']['id'] = $id;
				$section['Question']['order'] = $order;

				$this->Question->save($section, false);
			}
			$this->set('message', __('The order has been saved successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->set('message', __('There was a problem updating the order.', true));
		}
	}
}
?>