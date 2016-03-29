<?php
class RewardsController extends AppController {

	var $name = 'Rewards';
	
	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index', 'view');
		}

		if(!$this->Setting->Module->enabled('reward_points')) {
			$this->cakeError('error404'); die;
		}
	}

	function index() {
		$order = $this->requestAction('/settings/get/products_order');

		$this->paginate = array('contain' => 'Image', 'conditions' => array('Product.reward' => true), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Product.'.$order => 'asc'));
		$this->set('products', $this->paginate('Product'));

		$this->set('title_for_layout', __('Rewards Store', true));
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Reward.', true));
			$this->redirect(array('action' => 'index'));
		}

		$product = $this->Reward->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.reward' => true), 'contain' => 'Image'));

		if (empty($product)) {
			$this->Session->setFlash(__('Invalid Reward.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('product', $product);
	}

	function redeem ($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Reward.', true));
			$this->redirect(array('action' => 'index'));
		}

		$product = $this->Reward->Product->find('first', array('conditions' => array('Product.id' => $id, 'Product.reward' => true), 'contain' => ''));

		if (empty($product)) {
			$this->Session->setFlash(__('Invalid Reward.', true));
			$this->redirect(array('action' => 'index'));
		}

		if (empty($product['Product']['reward_points'])) {
			$this->Session->setFlash(__('This reward cannot be redeemed at the moment.', true));
			$this->redirect(array('action' => 'index'));
		}

		// lets check if they have the balance to do this!
		$balance = $this->Reward->User->Point->balance($this->Auth->user('id'));
		if($balance < $product['Product']['reward_points']) {
			$this->Session->setFlash(__('You do no have enough reward points to redeem this reward.', true));
			$this->redirect(array('action' => 'view', $id));
		}

		// lets see if memberships are enabled and if they can redeem the reward
		if($this->Setting->Module->enabled('memberships')) {
			$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => 'Membership.rewards'));

			if(empty($user['Membership']['rewards'])) {
				$this->Session->setFlash(__('Your membership level does not allow you to redeem rewards.', true));
				$this->redirect(array('action' => 'view', $id));
			}
		}

		if(!empty($this->data)) {
			$data['Reward']['product_id'] 	= $id;
			$data['Reward']['user_id'] 		= $this->Auth->user('id');
			$data['Reward']['status_id'] 	= 1;
			$data['Reward']['points'] 		= $product['Product']['reward_points'];

			$this->Reward->create();
			$this->Reward->save($data, false);

			// lets debit there points!
			$point['Point']['user_id'] 		= $this->Auth->user('id');
			$point['Point']['description'] 	= __(sprintf(__('Points Redeemed on Reward: %s', true), $product['Product']['title']), true);
			$point['Point']['debit'] 		= $product['Product']['reward_points'];

			$this->Reward->User->Point->create();
			$this->Reward->User->Point->save($point, false);

			$reward_id = $this->Reward->getInsertID();

			$data = $this->Reward->find('first', array('conditions' => array('Reward.id' => $reward_id), 'contain' => array('User', 'Product')));

			// send the email to the website owner
			$data['to'] 				   = $this->appConfigurations['email'];
			$data['subject'] 			   = sprintf(__('%s - A user has redeemed a reward', true), $this->appConfigurations['name']);
			$data['template'] 			   = 'rewards/redeemed';
			$data['sendAs']				   = 'text';
			$this->_sendEmail($data);

			$this->Session->setFlash(__('You have redeemed this reward. Please confirm your address details below.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'confirm', $reward_id));
		}

		$this->set('product', $product);
	}

	function redeemed() {
		if($this->Setting->Module->enabled('multi_languages')) {
			$this->paginate = array('conditions' => array('Reward.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Reward.created' => 'desc'), 'contain' => '');
			$rewards = $this->paginate();

			if(!empty($rewards)) {
				foreach ($rewards as $key => $reward) {
					// lets attach on the product and images
					$product = $this->Reward->Product->find('first', array('conditions' => array('Product.id' => $reward['Reward']['product_id']), 'contain' => array('Image' => array('limit' => 1))));
					$reward['Product'] = $product['Product'];
					$reward['Product']['Image'] = $product['Image'];
					$rewards[$key]['Product'] = $reward['Product'];

					$status = $this->Reward->Status->find('first', array('conditions' => array('Status.id' => $reward['Reward']['status_id']), 'contain' => ''));
					$rewards[$key]['Status'] = $status['Status'];
				}
			}
			$this->set('rewards', $rewards);
		} else {
			$this->paginate = array('conditions' => array('Reward.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Reward.created' => 'desc'), 'contain' => array('Product' => array('Image' => array('limit' => 1)), 'Status'));
			$this->set('rewards', $this->paginate());
		}

		$this->set('title_for_layout', __('Rewards Redeemed', true));
	}

	function confirm ($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Reward', true));
			$this->redirect(array('action'=>'index'));
		}

		$reward = $this->Reward->find('first', array('conditions' => array('Reward.id' => $id, 'Reward.user_id' => $this->Auth->user('id')), 'contain' => array('Product', 'User')));
		if(empty($reward)) {
			$this->Session->setFlash(__('Invalid Reward', true));
			$this->redirect(array('action'=>'index'));
		}

		if($reward['Reward']['status_id'] != 1) {
			$this->Session->setFlash(__('You have already confirmed this auction.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('reward', $reward);

		if($reward['User']['active'] == 0) {
			$reward['User']['activate_link'] 	= $this->appConfigurations['url'] . '/users/activate/' . $reward['User']['key'];
			$data['User']						= $reward['User'];
			$data['to'] 				  		= $reward['User']['email'];
			$data['subject'] 					= sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
			$data['template'] 			   		= 'users/activate';
			if($this->_sendEmail($data)) {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods.  We have sent you an activation email, please confirm your email address before attempting to confirm this item.', true));
			} else {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods, however there was a problem sending the email, please contact us.', true));
			}
			$this->redirect(array('action' => 'index'));
		}

		$this->Reward->User->Address->UserAddressType->recursive = -1;
		$addresses 	 	 = $this->Reward->User->Address->UserAddressType->find('all');
		$userAddress 	 = array();
		$addressRequired = 0;

		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Reward->User->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
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
				// did they win bids
				if(!empty($reward['Product']['bids'])) {
					$bid['Bid']['user_id'] 		= $this->Auth->user('id');
					$bid['Bid']['description'] 	= __(sprintf(__('Bids from redeemed reward: %s', true), $reward['Product']['title']), true);
					$bid['Bid']['credit'] 		= $reward['Product']['bids'];

					$this->Reward->User->Bid->create();
					$this->Reward->User->Bid->save($bid);

					// Change exchange status
					$this->data['Reward']['status_id'] = 3;
					$this->Session->setFlash(__('Your details have been confirmed and your bids have been credited to your account.  They are now available for you to use.', true), 'default', array('class' => 'success'));
				} else {
					$this->data['Reward']['status_id'] = 2;

					if(!empty($reward['Product']['cash'])) {
						$this->Session->setFlash(__('Your details have been confirmed.  We will notify you when your cash has been paid.', true), 'default', array('class' => 'success'));
					} else {
						$this->Session->setFlash(__('Your details have been confirmed.  We will notify you when your item has been shipped.', true), 'default', array('class' => 'success'));
					}
				}

				$this->Reward->save($this->data, false);

				$this->redirect(array('action' => 'redeemed'));
			}
		}

		$this->set('title_for_layout', __('Confirm Your Details', true));
	}
	
	/* Change by Andrew Buchan on 2015-03-11: Create function for explained view */
	function explained()
	{
		$this->loadModel('Membership');
		$membership = $this->Membership->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => 'Membership'));
		
		$this->set('membership', $membership);
		
		$bidPoints = $this->User->Auction->Bid->find('count', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0)));
		$this->set('bidPoints', $bidPoints);
		
		$nextMembership = $this->Membership->find('first', array('conditions' => array('Membership.rank <' => $membership['Membership']['rank']), 'contain' => '', 'order' => array('Membership.rank' => 'desc')));
		$this->set('nextMembership', $nextMembership);
	
	/*
		if($this->Setting->Module->enabled('multi_languages')) {
			$this->paginate = array('conditions' => array('Reward.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Reward.created' => 'desc'), 'contain' => '');
			$rewards = $this->paginate();

			if(!empty($rewards)) {
				foreach ($rewards as $key => $reward) {
					// lets attach on the product and images
					$product = $this->Reward->Product->find('first', array('conditions' => array('Product.id' => $reward['Reward']['product_id']), 'contain' => array('Image' => array('limit' => 1))));
					$reward['Product'] = $product['Product'];
					$reward['Product']['Image'] = $product['Image'];
					$rewards[$key]['Product'] = $reward['Product'];

					$status = $this->Reward->Status->find('first', array('conditions' => array('Status.id' => $reward['Reward']['status_id']), 'contain' => ''));
					$rewards[$key]['Status'] = $status['Status'];
				}
			}
			$this->set('rewards', $rewards);
		} else {
			$this->paginate = array('conditions' => array('Reward.user_id' => $this->Auth->user('id')), 'limit' => 50, 'order' => array('Reward.created' => 'desc'), 'contain' => array('Product' => array('Image' => array('limit' => 1)), 'Status'));
			$this->set('rewards', $this->paginate());
		}*/

		$this->set('title_for_layout', __('Membership Levels Explained', true));
	}
	/* End Change */

	function admin_index($status_id = null) {
		if(!empty($status_id)) {
			$conditions = array('Reward.status_id' => $status_id);
		} else {
			$conditions = array();
		}

		$this->paginate = array('conditions' => array($conditions), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Reward.id' => 'desc'), 'contain' => array('User.username', 'Product.title', 'Status.name'));
		$this->set('rewards', $this->paginate());

		$this->set('statuses', $this->Reward->Status->find('list'));
		$this->set('selected', $status_id);

		$this->set('title_for_layout', __('Redeemed Rewards', true));
	}

	function admin_view($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Reward', true));
			$this->redirect(array('action'=>'index'));
		}
		$reward = $this->Reward->find('first', array('conditions' => array('Reward.id' => $id), 'contain' => array('Product', 'Status')));
		if(empty($reward)) {
			$this->Session->setFlash(__('Invalid Reward', true));
			$this->redirect(array('action'=>'index'));
		}

		if(!empty($this->data)) {
    		$this->Reward->save($this->data);

    		if($this->data['Reward']['inform'] == 1) {
    			$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));

    			$data = $this->Reward->find('first', array('conditions' => array('Reward.id' => $id), 'contain' => array('Auction', 'Status', 'User')));

    			if(!empty($data['User']['language_id'])) {
					$language = $this->Language->find('first', array('conditions' => array('Language.id' => $data['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
					Configure::write('Config.language', $language['Language']['code']);

					$this->Reward->Product->locale = $language['Language']['code'];
				}

				$product = $this->Reward->Product->find('first', array('conditions' => array('Product.id' => $reward['Reward']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$data['Product'] 	= $product['Product'];
				} else {
					$data['Product'] 	= $product['Product'];
				}

    			$data['Status']['comment'] 	   = $this->data['Reward']['comment'];
    			$data['to'] 				   = $data['User']['email'];
				$data['subject'] 			   = sprintf(__('%s - Redeemed Reward Status Updated', true), $this->appConfigurations['name']);
				$data['template'] 			   = 'rewards/status';
				$this->_sendEmail($data);

				Configure::write('Config.language', $default['Language']['code']);
    		}

    		$this->Session->setFlash(__('The redeemed reward status was successfully updated.', true), 'default', array('class' => 'success'));
    		$this->redirect(array('action' => 'view', $reward['Reward']['id']));
		}

		$this->set('reward', $reward);

		$this->Reward->User->recursive = -1;
		$user = $this->Reward->User->read(null, $reward['Reward']['user_id']);

		$this->set('user', $user);

		$this->Reward->User->Address->UserAddressType->recursive = -1;
		$addresses = $this->Reward->User->Address->UserAddressType->find('all');
		$userAddress = array();
		$addressRequired = 0;
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Reward->User->Address->find('first', array('conditions' => array('Address.user_id' => $reward['Reward']['user_id'], 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
			}
		}
		$this->set('address', $userAddress);

		$this->set('selectedStatus', $reward['Reward']['status_id']);
		$this->set('statuses', $this->Reward->Status->find('list'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Reward.', true));

		}
		if ($this->Reward->delete($id)) {
			$this->Session->setFlash(__('The redeemed reward was deleted successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this reward.', true));
		}
		$this->redirect(array('action' => 'index'));
	}
}
?>