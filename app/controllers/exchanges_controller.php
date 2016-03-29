<?php
class ExchangesController extends AppController {

	var $name = 'Exchanges';

	function index() {
		if($this->Setting->Module->enabled('multi_languages')) {
			$this->paginate = array('conditions' => array('Exchange.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Exchange.created' => 'desc'), 'contain' => 'Auction');
			$exchanges = $this->paginate();

			if(!empty($exchanges)) {
				foreach ($exchanges as $key => $exchange) {
					// lets attach on the product and images
					$product = $this->Exchange->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => array('Image')));
					$exchange['Product'] = $product['Product'];
					$exchange['Product']['Image'] = $product['Image'];
					$exchanges[$key]['Auction']['Product'] = $exchange['Product'];

					$status = $this->Exchange->Auction->Status->find('first', array('conditions' => array('Status.id' => $exchange['Exchange']['status_id']), 'contain' => ''));
					$exchanges[$key]['Status'] = $status['Status'];
				}
			}
			$this->set('exchanges', $exchanges);
		} else {
			$this->paginate = array('conditions' => array('Exchange.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Exchange.created' => 'desc'), 'contain' => array('Auction' => array('Product' => 'Image'), 'Status'));
			$this->set('exchanges', $this->paginate());
		}

		$this->set('title_for_layout', __('Products Purchased', true));
	}

	function add ($auction_id = null) {
		if(empty($auction_id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}

		$auction = $this->Exchange->Auction->getAuctions(array('Auction.id' => $auction_id), 1, null, null, 'max');

		if (empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}

		$exchanged = $this->Exchange->find('count', array('conditions' => array('Exchange.auction_id' => $auction_id, 'Exchange.user_id' => $this->Auth->user('id'))));
		if($exchanged > 0) {
			$this->Session->setFlash(__('You have already exchanged this auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}

		// if the auction is closed, we need to make sure they did bid on the auction and didn't win the auction!
		if(!empty($auction['Auction']['closed'])) {
			$totalBids = $this->requestAction('/bids/total/'.$auction['Auction']['id'].'/'.$this->Auth->user('id'));
			if($totalBids > 0) {
				// lets make sure they are not the winner
				if($this->Auth->user('id') !== $auction['Winner']['id']) {
					// finally lets make sure the auction closed less than 24 hours ago
					if($auction['Auction']['end_time'] > time() - 86400) {
						$canExchange = true;
					}
				}
			}
		} else {
			$canExchange = true;
		}

		if(empty($canExchange)) {
			$this->Session->setFlash(__('You cannot exchange this auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action' => 'index'));
		}

		$this->set('auction', $auction);

		$balance = $this->Exchange->User->Bid->Balance($this->Auth->user('id'));

		$totalBids = $this->requestAction('/bids/total/'.$auction['Auction']['id'].'/'.$this->Auth->user('id'));

		$exchange = $auction['Product']['exchange'] - $totalBids;
		if($exchange < 0) {
			$exchange = 0;
		}

		if(!empty($this->data)) {
			$data['Exchange']['auction_id'] 	= $auction_id;
			$data['Exchange']['user_id'] 		= $this->Auth->user('id');
			$data['Exchange']['status_id'] 		= 1;
			$data['Exchange']['price'] 			= $exchange;

			$this->Exchange->create();
			$this->Exchange->save($data);

			$exchange_id = $this->Exchange->getInsertID();

			$data = $this->Exchange->find('first', array('conditions' => array('Exchange.id' => $exchange_id), 'contain' => array('User', 'Auction' => 'Product')));

			// send the email to the website owner
			$data['to'] 				   = $this->appConfigurations['email'];
			$data['subject'] 			   = sprintf(__('%s - A user has used the buy now', true), $this->appConfigurations['name']);
			$data['template'] 			   = 'auctions/exchanged';
			$data['sendAs']				   = 'text';
			$this->_sendEmail($data);

			$this->Session->setFlash(__('You have purchased this product. Please confirm your address details below.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'confirm', $exchange_id));
		}

		$this->set('balance', $balance);
		$this->set('exchange', $exchange);

	}

	function confirm ($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Exchange', true));
			$this->redirect(array('action'=>'index'));
		}

		$exchange = $this->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $this->Auth->user('id')), 'contain' => array('Auction' => 'Product', 'User')));
		if(empty($exchange)) {
			$this->Session->setFlash(__('Invalid Exchange', true));
			$this->redirect(array('action'=>'index'));
		}

		if($exchange['Exchange']['status_id'] != 1) {
			$this->Session->setFlash(__('You have already confirmed this auction.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('exchange', $exchange);

		if($exchange['User']['active'] == 0) {
			$exchange['User']['activate_link'] 	= $this->appConfigurations['url'] . '/users/activate/' . $exchange['User']['key'];
			$data['User']						= $exchange['User'];
			$data['to'] 				  		= $exchange['User']['email'];
			$data['subject'] 					= sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
			$data['template'] 			   		= 'users/activate';
			if($this->_sendEmail($data)) {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods.  We have sent you an activation email, please confirm your email address before attempting to confirm this item.', true));
			} else {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods, however there was a problem sending the email, please contact us.', true));
			}
			$this->redirect(array('action' => 'index'));
		}

		$this->Exchange->User->Address->UserAddressType->recursive = -1;
		$addresses 	 	 = $this->Exchange->User->Address->UserAddressType->find('all');
		$userAddress 	 = array();
		$addressRequired = 0;

		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Exchange->User->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
				if(empty($userAddress[$address['UserAddressType']['name']])) {
					$addressRequired = 1;
					$userAddress[$address['UserAddressType']['name']] = array('Address' => array('user_address_type_id' => $address['UserAddressType']['id']));
				}
			}
		}

		$this->set('address', $userAddress);
		$this->set('addressRequired', $addressRequired);

		if(empty($addressRequired)) {
			if(!empty($this->data)) {
				// lets check if they want bids instead of the product
				if(!empty($this->data['Exchange']['bids'])) {
					$bid['Bid']['user_id'] = $this->Auth->user('id');
					$bid['Bid']['description'] = 'Bids exchanged for product '.$exchange['Auction']['Product']['title'];
					$bid['Bid']['credit'] = round($exchange['Auction']['Product']['rrp'] / 0.55);

					$this->Exchange->Auction->Bid->create();
					$this->Exchange->Auction->Bid->save($bid);

					// Change exchange status
					$this->data['Exchange']['status_id'] = 3;
					$this->Session->setFlash(__('Your details have been confirmed and your bids have been credited to your account.  They are now available for you to use.', true), 'default', array('class' => 'success'));
				} else {
					$this->data['Exchange']['status_id'] = 2;

					if(!empty($exchange['Auction']['Product']['cash'])) {
						$this->Session->setFlash(__('Your details have been confirmed.  We will notify you when your cash has been paid.', true), 'default', array('class' => 'success'));
					} else {
						$this->Session->setFlash(__('Your details have been confirmed.  We will notify you when your item has been shipped.', true), 'default', array('class' => 'success'));
					}
				}

				$this->Exchange->save($this->data, false);

				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set('title_for_layout', __('Confirm Your Details', true));
	}

	function admin_index($status_id = null) {
		if(!empty($status_id)) {
			$conditions = array('Exchange.status_id' => $status_id);
		} else {
			$conditions = array();
		}

		$this->paginate = array('conditions' => array($conditions), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Exchange.id' => 'desc'), 'contain' => array('User', 'Auction' => 'Product', 'Status'));
		$this->set('exchanges', $this->paginate());

		$this->set('statuses', $this->Exchange->Status->find('list'));
		$this->set('selected', $status_id);

		$this->set('title_for_layout', __('Purchased Products', true));
	}

	function admin_view($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Exchange', true));
			$this->redirect(array('action'=>'index'));
		}
		$exchange = $this->Exchange->find('first', array('conditions' => array('Exchange.id' => $id), 'contain' => array('Auction' => 'Product', 'Status')));
		if(empty($exchange)) {
			$this->Session->setFlash(__('Invalid Exchange', true));
			$this->redirect(array('action'=>'index'));
		}

		if(!empty($this->data)) {
    		$this->Exchange->save($this->data);

    		if($this->data['Exchange']['inform'] == 1) {
    			$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));

    			$data = $this->Exchange->find('first', array('conditions' => array('Exchange.id' => $id), 'contain' => array('Auction', 'Status', 'User')));

    			if(!empty($data['User']['language_id'])) {
					$language = $this->Language->find('first', array('conditions' => array('Language.id' => $data['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
					Configure::write('Config.language', $language['Language']['code']);

					$this->Exchange->Auction->Product->locale = $language['Language']['code'];
				}

				$product = $this->Exchange->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$data['Auction']['Product'] 	= $product['Product'];
				} else {
					$data['Auction']['Product'] 	= $product['Product'];
				}

    			$data['Status']['comment'] 	   = $this->data['Exchange']['comment'];
    			$data['to'] 				   = $data['User']['email'];
				$data['subject'] 			   = sprintf(__('%s - Bid Exchange Status Updated', true), $this->appConfigurations['name']);
				$data['template'] 			   = 'exchanges/status';
				$this->_sendEmail($data);

				Configure::write('Config.language', $default['Language']['code']);
    		}

    		$this->Session->setFlash(__('The bid exchange status was successfully updated.', true), 'default', array('class' => 'success'));
    		$this->redirect(array('action' => 'view', $exchange['Exchange']['id']));
		}

		$this->set('exchange', $exchange);

		$this->Exchange->User->recursive = -1;
		$user = $this->Exchange->User->read(null, $exchange['Exchange']['user_id']);
		$this->set('user', $user);

		$this->Exchange->User->Address->UserAddressType->recursive = -1;
		$addresses = $this->Exchange->User->Address->UserAddressType->find('all');
		$userAddress = array();
		$addressRequired = 0;
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Exchange->User->Address->find('first', array('conditions' => array('Address.user_id' => $exchange['Exchange']['user_id'], 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
			}
		}
		$this->set('address', $userAddress);

		$this->set('selectedStatus', $exchange['Exchange']['status_id']);
		$this->set('statuses', $this->Exchange->Status->find('list'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Exchange.', true));

		}
		if ($this->Exchange->delete($id)) {
			$this->Session->setFlash(__('The bid exchange was deleted successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this bid exchange.', true));
		}
		$this->redirect(array('action' => 'index'));
	}
}
?>