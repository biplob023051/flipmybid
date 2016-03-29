<?php
class BidbutlersController extends AppController {

	var $name = 'Bidbutlers';

	function index() {
		if($this->Setting->Module->enabled('multi_languages')) {
			$this->paginate = array('conditions' => array('Auction.closed' => 0, 'Bidbutler.user_id' => $this->Auth->user('id')), 'limit' => 20, 'order' => array('Bidbutler.created' => 'desc'), 'contain' => 'Auction');
			$bidbutlers = $this->paginate();

			if(!empty($bidbutlers)) {
				foreach ($bidbutlers as $key => $bidbutler) {
					// lets attach on the product and images
					$product = $this->Bidbutler->Auction->Product->find('first', array('conditions' => array('Product.id' => $bidbutler['Auction']['product_id']), 'contain' => array('Image')));
					$bidbutler['Product'] = $product['Product'];
					$bidbutler['Product']['Image'] = $product['Image'];
					$bidbutlers[$key]['Auction']['Product'] = $bidbutler['Product'];
				}
			}
			$this->set('bidbutlers', $bidbutlers);
		} else {
			$this->paginate = array('conditions' => array('Auction.closed' => 0, 'Bidbutler.user_id' => $this->Auth->user('id')), 'limit' => 20, 'order' => array('Bidbutler.created' => 'desc'), 'contain' => array('Auction' => array('Product' => 'Image')));
			$this->set('bidbutlers', $this->paginate());
		}

		$this->set('title_for_layout', __('My Bid Buddy', true));
	}

	function add($auction_id = null) {
		if (!$auction_id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		$auction = $this->Bidbutler->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => ''));
		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid auction', true));
			$this->redirect(array('action'=>'index'));
		}

		if(!empty($auction['Auction']['product_id'])) {
			$product = $this->Bidbutler->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
			$auction['Product'] = $product['Product'];
		}

		if(!empty($auction['Auction']['nail_biter'])) {
			$this->Session->setFlash(__('This is a nail biter auction, a bid buddy cannot be added.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
		}

		// lets check if it is a beginner auction
		if($this->Bidbutler->Auction->checkBeginner($this->Auth->user('id'), false, $auction['Auction']['beginner']) == false) {
			$this->Session->setFlash(__('You cannot place a bid buddy on this auction as it is a beginner auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
		}

		// lets check that the users limits haven't been exceeded
		if($this->Bidbutler->Auction->checkLimits($this->Auth->user('id'), $auction['Auction']['limit_id'], false, $auction['Auction']['id']) == false) {
			$this->Session->setFlash(__('You cannot place a bid buddy on this auction as it will exceed your win limits.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction_id));
		}

		$this->set('auction', $auction);
		if (!empty($this->data)) {

			$this->data['Bidbutler']['user_id'] = $this->Auth->user('id');
			$this->data['Bidbutler']['auction_id'] = $auction_id;
			$this->data['Bidbutler']['balance'] = $this->Bidbutler->Auction->Bid->balance($this->Auth->user('id'));
			$this->data['Auction']['featured'] = $auction['Auction']['featured'];
			$this->data['Auction']['beginner'] = $auction['Auction']['beginner'];

			if($this->Setting->get('bid_butler_strict')) {
				$this->data['Bidbutler']['pending_bids'] = $this->Bidbutler->totalButlers($this->Auth->user('id'), $auction_id);
			}

			$this->Bidbutler->create();
			if ($this->Bidbutler->save($this->data)) {
				// lets remove any existing bid buddies
				$this->Bidbutler->removeAll($auction_id, $this->Auth->user('id'), $auction['Auction']['price'], $this->Bidbutler->getInsertID());

				$this->Session->setFlash(__('The bid buddy has been successfully added.', true), 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		}

		$this->set('title_for_layout', __('Add a Bid Buddy', true));
	}

	function delete($id = null, $auctionView = false) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		$bidbutler = $this->Bidbutler->read(null, $id);
		if(empty($bidbutler)) {
			$this->Session->setFlash(__('Invalid bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
		if($bidbutler['Bidbutler']['user_id'] == $this->Auth->user('id')) {
			if ($this->Bidbutler->delete($id)) {
				$this->Session->setFlash(__('Your bid biddy was successfully deleted.', true), 'default', array('class' => 'success'));
				if($auctionView == true) {
					$this->redirect(array('controller' => 'auctions', 'action' => 'view', $bidbutler['Auction']['id']));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
				$this->redirect(array('action'=>'index'));
			}
		} else {
			$this->Session->setFlash(__('Invalid Bid buddy', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function check($auction_id = null, $user_id = null) {
		$auction = $this->Bidbutler->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => '', 'fields' => 'Auction.price'));

		return $this->Bidbutler->find('first', array('conditions' => array('Bidbutler.auction_id' => $auction_id, 'Bidbutler.user_id' => $user_id, 'Bidbutler.bids >' => 0, 'Bidbutler.maximum_price >' => $auction['Auction']['price']), 'contain' => ''));
	}

	function admin_auction($auction_id = null) {
		if(empty($auction_id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}
		$auction = $this->Bidbutler->Auction->read(null, $auction_id);
		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}
		$this->set('auction', $auction);

		$this->paginate = array('conditions' => array('Bidbutler.auction_id' => $auction_id), 'contain' => array('User', 'Auction' => 'Product'), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bidbutler.created' => 'desc'));
		$this->set('bidbutlers', $this->paginate());
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Bidbutler->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Bidbutler.user_id' => $user_id), 'contain' => array('User', 'Auction' => 'Product'), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Bidbutler.created' => 'desc'));
		$this->set('bidbutlers', $this->paginate());
	}

	function admin_delete($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid id for bid buddy', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$bidbutler = $this->Bidbutler->read(null, $id);
		if(empty($bidbutler)) {
			$this->Session->setFlash(__('Invalid id for bid buddy', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		if ($this->Bidbutler->delete($id)) {
			$this->Session->setFlash(__('The bid buddy was successfully deleted.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this bid buddy.', true));
		}
		$this->redirect(array('action'=>'user', $bidbutler['Bidbutler']['user_id']));
	}
}
?>