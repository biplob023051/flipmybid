<?php
class PackagesController extends AppController {

	var $name = 'Packages';
	var $uses = array('Package', 'User', 'Setting', 'Country', 'Coupon');

	function beforeFilter(){
		parent::beforeFilter();

		if(isset($this->Auth)){
			$this->Auth->allow('getlist');
		}

		if($this->Setting->Module->enabled('coupons')) {
			if($coupon = Cache::read('coupon_user_'.$this->Auth->user('id'))){
				$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
				if(empty($coupon)){
					Cache::delete('coupon_user_'.$this->Auth->user('id'));
					$this->Session->setFlash(__('The coupon you applied no longer exists. Please enter another coupon.', true));
					$this->redirect(array('controller' => 'packages', 'action' => 'index'));
				}
			}
		}
	}

	function getlist(){
		return $this->Package->find('all', array('order' => array('price' => 'asc')));
	}

	function index($tracking = false) {
		//do not limit packages - grzegab change
		$this->paginate = array('limit' => 1000, 'order' => array('price' => 'asc'));
		$this->set('packages', $this->paginate());

		$this->set('title_for_layout', __('Purchase Bids', true));

		$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));
		$this->set('user', $user);

		if($user['User']['active'] == 0) {
			$this->redirect(array('controller' => 'users', 'action' => 'resend'));
		}

		$this->set('tracking', $tracking);
	}

	function applycoupon() {
		if(!empty($this->data['Coupon']['code'])){
			$coupon = $this->Coupon->findByCode(strtoupper($this->data['Coupon']['code']));
			if(!empty($coupon)){
				Cache::write('coupon_user_'.$this->Auth->user('id'), $coupon);

				$this->Session->setFlash(__('The coupon has been applied.',true), 'default', array('class' => 'success'));
			}else{
				$this->Session->setFlash(__('Invalid coupon',true));
			}
		}else{
			$this->Session->setFlash(__('Invalid Coupon',true));
		}

		$this->redirect(array('action' => 'index'));
	}

	function removecoupon() {
		if(Cache::read('coupon_user_'.$this->Auth->user('id'))){
			Cache::delete('coupon_user_'.$this->Auth->user('id'));

			$this->Session->setFlash(__('The coupon has been removed successfully.', true), 'default', array('class' => 'success'));
		}else{
			$this->Session->setFlash(__('You have not entered any coupons yet!', true));
		}

		$this->redirect(array('action' => 'index'));
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('price' => 'asc'));
		$this->set('packages', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Package->create();
			if ($this->Package->save($this->data)) {
				$this->Session->setFlash(__('The package has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the package please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Package->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Package', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Package']['id'] = $id;
			if ($this->Package->save($this->data)) {
				$this->Session->setFlash(__('The package has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem updating the package please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Package->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Package', true));
			$this->redirect(array('action'=>'index'));
		}
		$package = $this->Package->find('first', array('conditions' => array('Package.id' => $id), 'contain' => ''));
		if (empty($package)) {
			$this->Session->setFlash(__('Invalid id for Package', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('package', $package);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BidPackage.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Package->delete($id)) {
			$this->Session->setFlash(__('The package was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_mostexpensive() {
		// lets assume the cheapest package is the most expensive per bid
		$package = $this->Package->find('first', array('order' => array('Package.price' => 'asc')));
		if(!empty($package)) {
			return $package['Package']['price'] / $package['Package']['bids'];
		} else {
			return null;
		}
	}
}
?>
