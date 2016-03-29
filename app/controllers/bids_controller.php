<?php
class BidsController extends AppController {

	var $name = 'Bids';

	function beforeFilter(){
		parent::beforeFilter();

		if(isset($this->Auth)){
			$this->Auth->allow('histories', 'balance', 'total');
		}
	}

	function histories($auction_id = null){
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';

		if(!empty($auction_id)){
			$histories = $this->Bid->histories($auction_id, $this->Setting->get('bid_history_limit'));
			$this->set('histories', $histories);
		}
	}

	function balance($user_id = null){
		if(!empty($user_id)){
			return $this->Bid->balance($user_id);
		}
	}

	function total($auction_id = null, $user_id = null, $countOnly = false){
		if(!empty($user_id) && !empty($auction_id)){
			$totalbids = $this->Bid->find('count', array('conditions' => array('Bid.auction_id' => $auction_id, 'Bid.user_id' => $user_id), 'contain' => ''));

			if($countOnly == true) {
				return $totalbids;
			}

			if($totalbids > 0) {
				$currency = $this->Currency->findbyCurrency(Configure::read('App.currency'));
				if(!empty($currency['Currency']['bid_price'])) {
					return $totalbids * $currency['Currency']['bid_price'];
				} else {
					return $totalbids * 0.50;
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	function count($auction_id = null, $user_id = null) {
		if(!empty($user_id) && !empty($auction_id)){
			return $this->Bid->find('count', array('conditions' => array('Bid.auction_id' => $auction_id, 'Bid.user_id' => $user_id)));
		} else {
			return 0;
		}
	}

	function index($purchaseMade = false) {
		$credits = $this->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.credit >' => 0), 'order' => array('Bid.id' => 'desc'), 'contain' => ''));
		$this->set('credits', $credits);

		if($this->Setting->Module->enabled('multi_languages')) {
			$bids = $this->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.debit >' => 0), 'order' => array('Bid.id' => 'desc'), 'contain' => '', 'fields' => 'DISTINCT Bid.auction_id'));
			if(!empty($bids)) {
				foreach ($bids as $key => $bid) {
					$auction = $this->Bid->Auction->find('first', array('conditions' => array('Auction.id' => $bid['Bid']['auction_id']), 'contain' => ''));
					if(!empty($auction)) {
						$bid['Auction'] = $auction['Auction'];
						$product = $this->Bid->Auction->Product->find('first', array('conditions' => array('Product.id' => $bid['Auction']['product_id']), 'contain' => array('Image')));
						if(!empty($product)) {
							$bid['Auction']['Product'] 			= $product['Product'];
							$bid['Auction']['Product']['Image'] = $product['Image'];
						}
					}
					$bids[$key]['Auction'] = $bid['Auction'];
				}
			}
		} else {
			$bids = $this->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.debit >' => 0), 'order' => array('Bid.id' => 'desc'), 'contain' => array('Auction' => array('Product' => 'Image')), 'fields' => 'DISTINCT Bid.auction_id'));
		}

		$this->set('bids', $bids);

		$this->set('bidBalance', $this->User->Bid->balance($this->Auth->user('id')));

		if($purchaseMade == true) {
			// lets get the last purchase details
			$purchase = $this->Bid->User->Account->find('first', array('conditions' => array('Account.user_id' => $this->Auth->user('id')), 'order' => array('Account.created' => 'desc'), 'contain' => 'User.username'));
			if(!empty($purchase)) {
				$this->set('purchase', $purchase);
			}
		}

		$this->set('purchaseMade', $purchaseMade);

		$this->set('title_for_layout', __('My Bids', true));
	}

	function admin_index() {
		$this->paginate = array('conditions' => array('Bid.auction_id > ' => 0, 'Bid.debit >' => 0, 'Bid.credit' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bid.id' => 'desc'), 'contain' => array('User', 'Auction' => 'Product'));
		$this->set('bids', $this->paginate());
	}

	function admin_auction($auction_id = null, $realBidsOnly = false) {
		if(empty($auction_id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}
		$auction = $this->Bid->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => 'Product'));

		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}
		$this->set('auction', $auction);

		if(!empty($realBidsOnly)) {
			$conditions = array('Bid.auction_id' => $auction_id, 'Bid.debit >' => 0, 'Bid.credit' => 0, 'User.autobidder' => 0);
			$this->set('realBidsOnly', $realBidsOnly);
		} else {
			$conditions = array('Bid.auction_id' => $auction_id, 'Bid.debit >' => 0, 'Bid.credit' => 0);
		}

		$this->paginate = array('conditions' => $conditions, 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bid.id' => 'desc'), 'contain' => array('User', 'Auction' => 'Product'));
		$this->set('bids', $this->paginate());
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Bid->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Bid.user_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bid.created' => 'desc'), 'contain' => array('Auction' => array('Product')));
		$this->set('bids', $this->paginate());

		$this->set('bidBalance', $this->User->Bid->balance($user_id));
	}

	function admin_add($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Bid->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		if(!empty($this->data)) {
			$this->data['Bid']['user_id'] = $user_id;
			if(!empty($this->data['Bid']['total'])) {
				if($this->data['Bid']['total'] > 0) {
					$this->data['Bid']['credit'] = $this->data['Bid']['total'];
				} else {
					$this->data['Bid']['debit'] = $this->data['Bid']['total'] * -1;
				}
			}

			$this->Bid->create();
			if($this->Bid->save($this->data)) {
				$this->Session->setFlash(__('The bid transaction has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'user', $user_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the bid transaction please review the errors below and try again.', true));
			}
		}

		$this->set('user', $user);
	}

	function admin_delete($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid id for bid', true));
			$this->redirect(array('controller' => 'users', 'action'=>'index'));
		}
		$bid = $this->Bid->read(null, $id);
		if(empty($bid)) {
			$this->Session->setFlash(__('Invalid id for bid', true));
			$this->redirect(array('controller' => 'users', 'action'=>'index'));
		}

		if ($this->Bid->delete($id)) {
			$this->Session->setFlash(__('The bid transaction was successfully deleted.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this bid transation', true));
		}
		$this->redirect(array('action'=>'user', $bid['Bid']['user_id']));
	}
}
?>