<?php
class ReferralsController extends AppController {

	var $name = 'Referrals';
	var $uses = array('Referral', 'Setting');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('activate', 'show_sources');
		}
	}

	function index() {
		$this->paginate = array('conditions' => array('Referral.referrer_id' => $this->Auth->user('id')), 'limit' => 20, 'order' => array('Referral.modified' => 'desc'));
		$this->set('referrals', $this->paginate());

		$this->set('title_for_layout', __('Referrals', true));
	}

	function activate($username = null) {
		// lets make sure the username exists
		if($this->Referral->User->find('count', array('conditions' => array('User.username' => $username))) > 0) {
			$this->Cookie->write('referral', $username, true, '90 Days');
		}

		$this->redirect($this->referer('/'));
	}

	function show_sources() {
		if($this->Cookie->read('referral') && $this->Setting->get('hide_registration_sources')) {
			return false;
		} else {
			return true;
		}
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Referral.created' => 'desc'));
		$this->set('referrals', $this->paginate());
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Referral->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Referral.referrer_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Referral.created' => 'desc'));
		$this->set('referrals', $this->paginate());
	}
}
?>