<?php
class CurrenciesController extends AppController {

	var $name = 'Currencies';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('get');
		}
	}

	function get() {
		$rate     = Cache::read('currency_'.Configure::read('App.currency').'_rate');

		if(empty($rate)){
			$currencyRate = $this->Currency->find('first', array('fields' => 'rate', 'conditions' => array('Currency.currency' => Configure::read('App.currency'))));
			if(!empty($currencyRate)){
				Cache::write('currency_'.Configure::read('App.currency').'_rate', $currencyRate['Currency']['rate']);
				$rate = $currencyRate['Currency']['rate'];
			} else {
				$rate = 1;
			}
		}

		return $rate;
	}

	function count() {
		return $this->Currency->find('count');
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('currency' => 'asc'));
		$this->set('currencies', $this->paginate());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid News', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Currency->save($this->data)) {
				$this->Session->setFlash(__('The currency has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem editing the currency please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Currency->read(null, $id);
		}
	}
}
?>