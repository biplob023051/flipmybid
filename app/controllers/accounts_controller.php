<?php
class AccountsController extends AppController {

	var $name = 'Accounts';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('check');
		}
	}

	function index() {
		$this->Account->recursive = 0;
		$this->paginate = array('conditions' => array('Account.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Account.created' => 'desc'));
		$this->set('accounts', $this->paginate());

		$this->set('title_for_layout', __('Transactions', true));
	}

	function check($user_id = null) {
		$count = $this->Account->find('count', array('conditions' => array('Account.user_id' => $user_id), 'contain' => ''));

		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Account.created' => 'desc'), 'contain' => 'User');
		$this->set('accounts', $this->paginate());
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Account->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Account.user_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Account.created' => 'desc'));
		$this->set('accounts', $this->paginate());
	}
}
?>