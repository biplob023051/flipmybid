<?php
class CouponsController extends AppController {

	var $name = 'Coupons';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('write', 'delete');
		}
	}

	function write($code = null, $user_id = null) {
		$coupon = $this->Coupon->findByCode(strtoupper($code));
		if(empty($coupon)) {
			return false;
		}
		if(empty($user_id)) {
			return false;
		}

		Cache::write('coupon_user_'.$user_id, $coupon);
	}

	function delete($user_id = null) {
		if(empty($user_id)) {
			return false;
		}

		Cache::delete('coupon_user_'.$user_id);
	}

	function admin_index() {
		$this->Coupon->recursive = 0;
		$this->set('coupons', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Coupon->create();
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The coupon has been successfully created', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Coupon could not be saved. Please, try again.', true));
			}
		}
		$couponTypes = $this->Coupon->CouponType->find('list');

		// Show the option for FREE REWARDS only if reward points is on
		if(!Configure::read('App.rewardsPoint')) {
			unset($couponTypes[5]);
		}
		$this->set(compact('couponTypes'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The coupon has been successfully updated.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The coupon could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Coupon->read(null, $id);
		}
		$couponTypes = $this->Coupon->CouponType->find('list');

		// Show the option for FREE REWARDS only if reward points is on
		if(!Configure::read('App.rewardsPoint')) {
			unset($couponTypes[5]);
		}

		$this->set(compact('couponTypes'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Coupon->delete($id)) {
			$this->Session->setFlash(__('The coupon has been successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>