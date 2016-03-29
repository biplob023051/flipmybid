<?php
class NewslettersController extends AppController {

	var $name = 'Newsletters';
	var $helpers = array('Fck');
	var $uses = array('Newsletter', 'User');

	function beforeFilter(){
		parent::beforeFilter();

		if(isset($this->Auth)){
			$this->Auth->allow('unsubscribe');
		}
	}

	function unsubscribe($email){
		$this->User->recursive = -1;
		$user = $this->User->findByEmail($email);
		if(!empty($user)){
			$user['User']['newsletter'] = 0;
			if($this->User->save($user)){
				$this->Session->setFlash(__('You have been unsubscribed from our newsletter.', true), 'default', array('class' => 'success'));
			}else{
				$this->Session->setFlash(__('There was a problem while updating your preferences. Please try again.', true));
			}
		}else{
			$this->Session->setFlash(__('Invalid email.', true));
		}

		$this->redirect('/');
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Newsletter.created' => 'desc'));
		$this->set('newsletters', $this->paginate());

		$this->set('newsletterRunning', $this->Newsletter->User->find('count', array('conditions' => array('User.newsletter_id >' => 0, 'User.newsletter' => 1, 'User.deleted' => 0), 'contain' => '')));
	}

	function admin_send($id = null, $purchasedBefore = false) {
		$data = array();

		$newsletter = $this->Newsletter->read(null, $id);
		if(empty($newsletter)) {
			$this->Session->setFlash(__('Invalid Newsletter.', true));
			$this->redirect(array('action'=>'index'));
		}

		$newsletter['Newsletter']['sent'] = 1;
		$newsletter['Newsletter']['modified'] = date('Y-m-d H:i:s');

		$this->Newsletter->save($newsletter);

		if($purchasedBefore == true) {
			$users = $this->User->Account->find('all', array('conditions' => array('User.newsletter' => 1, 'User.deleted' => 0), 'fields' => 'DISTINCT User.id', 'contain' => 'User'));

			if(!empty($users)) {
				foreach ($users as $user) {
					$user['User']['newsletter_id'] = $id;
					$this->User->save($user, false);
				}
			}
		} else {
			$this->User->updateAll(array('User.newsletter_id' => $id), array('User.newsletter' => 1, 'User.deleted' => 0));
		}

		$this->Session->setFlash(__('The newsletter has been qued for sending.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'index'));
	}

	function admin_test($id = null) {
		$newsletter = $this->Newsletter->read(null, $id);
		if(empty($newsletter)) {
			$this->Session->setFlash(__('Invalid Newsletter.', true));
			$this->redirect(array('action'=>'index'));
		}

		$data['template'] 	= 'newsletters/send';
		$data['layout'] 	= 'newsletter';
		$data['to'] 		= $this->appConfigurations['email'];
		$data['from'] 		= $this->appConfigurations['name'].' Newsletter <'.$this->appConfigurations['email'].'>';

		$body 		= $newsletter['Newsletter']['body'];
		$subject 	= $newsletter['Newsletter']['subject'];

		$user = $this->User->find('first', array('conditions' => array('email like \''.$data['to'].'\'')));

		// lets add in our pre defined variables
		$body = str_replace('{first_name}', $user['User']['first_name'], $body);
		$subject = str_replace('{first_name}', $user['User']['first_name'], $subject);

		$body = str_replace('{last_name}', $user['User']['last_name'], $body);
		$subject = str_replace('{last_name}', $user['User']['last_name'], $subject);

		$body = str_replace('{email}', $user['User']['email'], $body);
		$subject = str_replace('{email}', $user['User']['email'], $subject);

		$body = str_replace('{username}', $user['User']['username'], $body);
		$subject = str_replace('{username}', $user['User']['username'], $subject);

		$this->set('body', $body);
		$this->set('data', $data);

		$data['subject'] = $subject;

		$this->_sendEmail($data);

		$this->Session->setFlash(__('The newsletter has been sent as a test.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'index'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Newsletter.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('newsletter', $this->Newsletter->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Newsletter->create();
			if ($this->Newsletter->save($this->data)) {
				$this->Session->setFlash(__('The Newsletter has been added and can be sent by pressing the \'send\' button next to the newsletter below.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Newsletter could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Newsletter', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Newsletter->save($this->data)) {
				$this->Session->setFlash(__('The Newsletter has been updated.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Newsletter could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Newsletter->read(null, $id);
		}
	}

	function admin_exportsubscribers(){
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$users = $this->User->find('all', array('conditions' => array('User.newsletter' => 1), 'order' => 'User.id ASC', 'contain' => ''));
		if(!empty($users)){
			$this->set('users', $users);
		}else{
			$this->Session->setFlash(__('There are no users subscribed to newsletter', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Newsletter', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Newsletter->delete($id)) {
			$this->Session->setFlash(__('The newsletter has been deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_stop() {
		$this->User->updateAll(array('User.newsletter_id' => 0), array('User.newsletter' => 1));

		$this->Session->setFlash(__('The newsletter has been stopped.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'index'));
	}
}
?>