<?php
class PagesController extends AppController {

	var $name = 'Pages';

	var $helpers = array('Fck');

	var $uses = array('Page', 'Department');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('view', 'getpages', 'contact', 'getpage');
		}
	}

	function view($slug = null) {
		if (!$slug) {
			$this->Session->setFlash(__('Invalid Page.', true));
			$this->redirect(array('action'=>'index'));
		}

		$page = $this->Page->findBySlug($slug);
		if(!empty($page)){
			$this->set('page', $page);
		}else{
			$this->Session->setFlash(__('Invalid Page.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('title_for_layout', $page['Page']['title']);
        if(!empty($page['Page']['meta_description'])) {
			$this->set('meta_description', $page['Page']['meta_description']);
		}
		if(!empty($page['Page']['meta_keywords'])) {
			$this->set('meta_keywords', $page['Page']['meta_keywords']);
		}
	}

	function contact() {
		if(!empty($this->data)) {
	    	$this->Page->set($this->data);
    		if($this->Page->validates()) {
				$data['Page'] 	 			= $this->data['Page'];

				$data['from'] 	 		= $this->data['Page']['name'].' <'.$this->data['Page']['email'].'>';

				if(!empty($data['Page']['department_id'])) {
					$department = $this->Department->read(null, $data['Page']['department_id']);
					$data['Department'] = $department['Department'];
				}

				if(!empty($data['Department']['email'])) {
					$data['to'] 			= $data['Department']['email'];
				} else {
					$data['to'] 			= $this->appConfigurations['email'];
				}

				if(empty($this->data['Page']['subject'])) {
					$this->data['Page']['subject'] = 'n/a';
				}
				$data['subject'] 		= 'Enquiry - '.$this->data['Page']['subject'];
				$data['template'] 		= 'pages/contact';
				$data['sendAs']			= 'text';
				if(Configure::read('debug') == 0) {
					$data['delivery']		= 'mail';
				}

				if($this->Auth->user('username')) {
					$data['Page']['username']		= $this->Auth->user('username');
					$data['Page']['purchased'] 		= $this->User->Account->find('count', array('conditions' => array('Account.user_id' => $this->Auth->user('id')), 'contain' => ''));
					$data['Page']['balance']		= $this->User->Bid->balance($this->Auth->user('id'));
				}

				$this->_sendEmail($data);

				if(!empty($this->data['Page']['redirect'])) {
					$this->Session->setFlash(__('You have been signed up to the newsletter.', true), 'default', array('class' => 'success'));
					$this->redirect($this->data['Page']['redirect']);
				} else {
					$this->Session->setFlash(__('The contact form was successfully submitted.', true), 'default', array('class' => 'success'));
					$this->redirect('/contact');
				}
	    	} else {
	    		$this->Session->setFlash(__('There was a problem submitting the contact form please review the errors below and try again.', true));
	    	}
    	} elseif($this->Auth->user('id')) {
    		$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));
			$this->data['Page']['name'] = $user['User']['first_name'].' '.$user['User']['last_name'];
			$this->data['Page']['email'] = $user['User']['email'];
    	}

    	$this->set('title_for_layout', __('Contact Us', true));

    	if($this->Setting->get('departments')) {
    		$this->set('departments', $this->Department->find('list', array('order' => array('name' => 'asc'))));
    	}
	}

	function getpages($position = 'top') {
		return $this->Page->find('all', array('conditions' => 'Page.'.$position.'_show > 0', 'order' => 'Page.'.$position.'_order ASC'));
	}

	function getpage($slug = null) {
		return $this->Page->find('first', array('conditions' => array('Page.slug' => $slug)));
	}

	function admin_index() {
		$this->set('topPages', $this->Page->find('all', array('conditions' => array('top_show' => 1), 'order' => array('top_order' => 'asc'))));
		$this->set('bottomPages', $this->Page->find('all', array('conditions' => array('bottom_show' => 1), 'order' => array('bottom_order' => 'asc'))));
		$this->set('staticPages', $this->Page->find('all', array('conditions' => array('top_show' => 0, 'bottom_show' => 0), 'order' => array('name' => 'asc'))));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Page->create();
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the page please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Page->locale = $language;
		}

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Page', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Page']['id'] = $id;
			if ($this->Page->save($this->data)) {
				$this->Session->setFlash(__('The page has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem saving the page please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Page->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Page', true));
			$this->redirect(array('action'=>'index'));
		}
		$page = $this->Page->find('first', array('conditions' => array('Page.id' => $id), 'contain' => ''));
		if (empty($page)) {
			$this->Session->setFlash(__('Invalid id for Page', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('page', $page);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_saveorder($position = 'top') {
		$this->layout = 'js/ajax';
		$message = '';

		if(!empty($_POST)){
			$data = $_POST;

			foreach($data['page'] as $order => $id){
				$page['Page']['id'] = $id;
				$page['Page'][$position.'_show']  = 1;
				$page['Page'][$position.'_order'] = $order;

				$this->Page->save($page);
			}

			$message = __('Page order has been saved', true);
		}

		$this->set('message', $message);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Page', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Page->delete($id)) {
			$this->Session->setFlash(__('The page was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
	}

}
?>