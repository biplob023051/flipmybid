<?php
class LimitsController extends AppController {

	var $name = 'Limits';

	function beforeFilter(){
		parent::beforeFilter();

		if(!$this->Setting->Module->enabled('win_limits')) {
			$this->Session->setFlash(__('Win limits are not enabled.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
	}

	function index() {
		$limits = $this->Limit->find('all', array('order' => array('Limit.name' => 'asc'), 'contain' => ''));

		if(!empty($limits)) {
			foreach ($limits as $key => $limit) {
				$expiryDate = date('Y-m-d H:i:s', time() - ($limit['Limit']['days'] * 24 * 60 * 60));

				if($this->Setting->Module->enabled('multi_languages')) {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $this->Auth->user('id'), 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => '', 'order' => array('Auction.end_time' => 'asc')));
					if(!empty($auctions)) {
						foreach ($auctions as $key => $auction) {
							$product = $this->Limit->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
							$auctions[$key]['Product'] = $product['Product'];
						}
					}
				} else {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $this->Auth->user('id'), 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => 'Product', 'order' => array('Auction.end_time' => 'asc')));
				}
				$limits[$key]['Leading'] = $auctions;
			}
		}

		$this->set('limits', $limits);

		$this->set('title_for_layout', __('Win Limits', true));
	}

	function get() {
		$limits = $this->Limit->find('all', array('order' => array('Limit.name' => 'asc'), 'contain' => ''));

		if(!empty($limits)) {
			foreach ($limits as $key => $limit) {
				$expiryDate = date('Y-m-d H:i:s', time() - ($limit['Limit']['days'] * 24 * 60 * 60));

				if($this->Setting->Module->enabled('multi_languages')) {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $this->Auth->user('id'), 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => '', 'order' => array('Auction.end_time' => 'asc')));
					if(!empty($auctions)) {
						foreach ($auctions as $key => $auction) {
							$product = $this->Limit->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
							$auctions[$key]['Product'] = $product['Product'];
						}
					}
				} else {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $this->Auth->user('id'), 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => 'Product', 'order' => array('Auction.end_time' => 'asc')));
				}
				$limits[$key]['Leading'] = $auctions;
			}
		}

		return $limits;
	}


	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Limit.name' => 'desc'), 'contain' => '');
		$this->set('limits', $this->paginate());

		$this->set('title_for_layout', __('Win Limits', true));
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('controllers' => 'users', 'action'=>'index'));
		}

		$user = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => ''));
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('controllers' => 'users', 'action'=>'index'));
		}

		$this->set('user', $user);

		$limits = $this->Limit->find('all', array('order' => array('Limit.name' => 'asc'), 'contain' => ''));

		if(!empty($limits)) {
			foreach ($limits as $key => $limit) {
				$expiryDate = date('Y-m-d H:i:s', time() - ($limit['Limit']['days'] * 24 * 60 * 60));

				if($this->Setting->Module->enabled('multi_languages')) {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $user_id, 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => '', 'order' => array('Auction.end_time' => 'asc')));
					if(!empty($auctions)) {
						foreach ($auctions as $key => $auction) {
							$product = $this->Limit->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
							$auctions[$key]['Product'] = $product['Product'];
						}
					}
				} else {
					$auctions = $this->Limit->Auction->find('all', array('conditions' => array('Auction.leader_id' => $user_id, 'Auction.end_time >' => $expiryDate, 'Auction.limit_id' => $limit['Limit']['id']), 'contain' => 'Product', 'order' => array('Auction.end_time' => 'asc')));
				}
				$limits[$key]['Leading'] = $auctions;
			}
		}

		$this->set('limits', $limits);

		$this->set('title_for_layout', __('Win Limits', true));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Limit->create();
			if ($this->Limit->save($this->data)) {
				$this->Session->setFlash(__('The limit has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the limit please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Limit->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Limit', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Limit']['id'] = $id;
			if ($this->Limit->save($this->data)) {
				$this->Session->setFlash(__('The limit has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('The limit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Limit->recursive = -1;
			$this->data = $this->Limit->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Limit', true));
			$this->redirect(array('action'=>'index'));
		}
		$limit = $this->Limit->find('first', array('conditions' => array('Limit.id' => $id), 'contain' => ''));
		if (empty($limit)) {
			$this->Session->setFlash(__('Invalid id for Limit', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('limit', $limit);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Limit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Limit->delete($id)) {
			$this->Session->setFlash(__('The limit was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>