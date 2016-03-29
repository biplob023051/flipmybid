<?php
class DaemonsController extends AppController {

	var $name = 'Daemons';

	var $uses = array('Auction', 'Setting', 'Newsletter', 'Coupon');

	var $layout = 'js/ajax';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('*');
		}
	}

	function cleaner() {
		if(Cache::read('cleaner.pid')) {
			return false;
		}

		if(!$this->Setting->get('bids_archive') || !$this->Setting->Module->enabled('database_cleaner')) {
			return false;
		}

		ini_set('max_execution_time', 0);

		$expiry_date = date('Y-m-d H:i:s', time() - ($this->Setting->get('bids_archive') * 24 * 60 * 60));

		$bids = $this->Auction->Bid->find('all', array('conditions' => array('Bid.created <' => $expiry_date), 'contain' => 'User', 'order' => array('Bid.id' => 'asc'), 'limit' => 1000));

		if(!empty($bids)) {
			Cache::write('cleaner.pid', microtime(), 'short');
			foreach ($bids as $bid) {
				if(!empty($bid['Bid']['user_id']) && empty($user['User']['autobidder'])) {
					$user = $this->User->find('first', array('conditions' => array('User.id' => $bid['Bid']['user_id']), 'contain' => '', 'fields' => array('id', 'bid_balance')));
					if(!empty($user)) {
						$user['User']['bid_balance'] = $user['User']['bid_balance'] + $bid['Bid']['credit'] - $bid['Bid']['debit'];
						$this->User->save($user, false);
					}
				}
					$this->Auction->Bid->delete($bid['Bid']['id']);
			}
		} else {
			Cache::write('cleaner.pid', microtime());
		}

		// now delete old bid buddies - lets just remove 100 at a time
		$bidbutlers = $this->Auction->Bidbutler->find('all', array('conditions' => array('Auction.end_time <' => $expiry_date), 'contain' => 'Auction', 'order' => array('Bidbutler.id' => 'asc'), 'limit' => 1000, 'fields' => 'Bidbutler.id'));
		if(!empty($bidbutlers)) {
			foreach ($bidbutlers as $bidbutler) {
				$this->Auction->Bidbutler->delete($bidbutler['Bidbutler']['id']);
			}
		}

		Cache::delete('cleaner.pid');
	}

	/**
	 * The function sends the email off to the winner of an auction
	 *
	 * @return n/a
	 */
	function winner() {
		$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));

		$auctions = $this->Auction->AuctionEmail->find('all', array('contain' => array('Auction' => 'Winner')));

		if(!empty($auctions)) {
			foreach ($auctions as $auction) {
				$data['Auction'] 			   = $auction['Auction'];
				$data['User'] 				   = $auction['Auction']['Winner'];

				if($this->Setting->get('email_winner')) {
					if(!empty($data['User']['language_id'])) {
						$language = $this->Language->find('first', array('conditions' => array('Language.id' => $data['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
						Configure::write('Config.language', $language['Language']['code']);

						$this->Auction->Product->locale = $language['Language']['code'];
					} else {
						$this->Auction->Product->locale = $default['Language']['code'];
					}

					$product 			= $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
					if(!empty($product)) {
						$this->Auction->Product->locale = $default['Language']['code'];
						$product 			= $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
					}
					$data['Product'] 	= $product['Product'];

					// send the email to the winner
					$data['to'] 				   = $auction['Auction']['Winner']['email'];
					$data['subject'] 			   = sprintf(__('%s - You have won an auction', true), $this->appConfigurations['name']);
					$data['template'] 			   = 'auctions/won_auction';
					$this->_sendEmail($data);
				}

				Configure::write('Config.language', $default['Language']['code']);

				$this->Auction->Product->locale 	= $default['Language']['code'];
				$product 				= $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				$data['Product'] 		= $product['Product'];

				// send the email to the website owner
				$data['to'] 				   = $this->appConfigurations['email'];
				$data['subject'] 			   = sprintf(__('%s - You have sold an auction', true), $this->appConfigurations['name']);
				$data['template'] 			   = 'auctions/sold_auction';
				$data['sendAs']				   = 'text';

				$this->_sendEmail($data);

				$this->Auction->AuctionEmail->delete($auction['AuctionEmail']['id']);
			}
		}
	}

	function newsletter() {
		if(Cache::read('newsletter.pid')) {
			return false;
		} else {
			Cache::write('newsletter.pid', microtime(), 'short');
		}

		$check = $this->User->find('first', array('conditions' => array('User.newsletter_id >' => 0), 'contain' => ''));
		if(empty($check)) {
			Cache::delete('newsletter.pid');
			return false;
		}

		$newsletter = $this->Newsletter->find('first', array('conditions' => array('Newsletter.id' => $check['User']['newsletter_id']), 'contain' => ''));
		if(empty($newsletter)) {
			Cache::delete('newsletter.pid');
			return false;
		}

		$newsletterUsers = $this->User->find('all', array('conditions' => array('User.newsletter' => 1, 'User.deleted' => 0, 'User.newsletter_id' => $newsletter['Newsletter']['id']), 'contain' => '', 'limit' => 100, 'fields' => 'User.id'));

		if(!empty($newsletterUsers)) {
			$count = 0;
			foreach($newsletterUsers as $data) {
				$user = $this->User->find('first', array('conditions' => array('User.id' => $data['User']['id'], 'User.newsletter' => 1, 'User.newsletter_id' => $newsletter['Newsletter']['id']), 'contain' => ''));

				// will need to add translations for the newsletter here


				$data['User']['newsletter_id'] = 0;
				$this->User->save($data, false);

				if(empty($user)) {
					continue;
				}

				$data['to'] 	= trim($user['User']['email']);
				$data['from']	= $this->appConfigurations['name'].' Newsletter <'.$this->appConfigurations['email'].'>';

				$body 		= $newsletter['Newsletter']['body'];
				$subject 	= $newsletter['Newsletter']['subject'];

				// lets add in our pre defined variables
				$body = str_replace('{first_name}', $user['User']['first_name'], $body);
				$subject = str_replace('{first_name}', $user['User']['first_name'], $subject);

				$body = str_replace('{last_name}', $user['User']['last_name'], $body);
				$subject = str_replace('{last_name}', $user['User']['last_name'], $subject);

				$body = str_replace('{email}', $user['User']['email'], $body);
				$subject = str_replace('{email}', $user['User']['email'], $subject);

				$body = str_replace('{username}', $user['User']['username'], $body);
				$subject = str_replace('{username}', $user['User']['username'], $subject);

				$this->set('body', $body);
				$this->set('data', $data);

				$data['subject'] = $subject;
				$data['template'] = 'newsletters/send';
				$data['layout'] = 'newsletter';

				$this->_sendEmail($data);
			}
		}
		Cache::delete('newsletter.pid');
	}

	function autobutlers() {
		// this will be phased out soon
		if($this->Setting->Module->enabled('testing_mode') == false) {
			return false;
		}

		if($this->Setting->Module->enabled('bid_butler') == false) {
			return false;
		}

		if(Cache::read('autobutlers.pid')) {
			return false;
		} else {
			Cache::write('autobutlers.pid', microtime(), 'minute');
		}

		$expireTime = $this->Setting->get('bid_butler_time') * 2;
		$expiryDate = date('Y-m-d H:i:s', time() + $expireTime);

		$auctions = $this->Auction->find('all', array('contain' => '', 'fields' => array('Auction.id', 'Auction.price'), 'conditions' => array('Auction.end_time <= ' => $expiryDate, 'Auction.closed' => 0, 'Auction.nail_biter' => 0, 'Auction.active' => 1, 'Auction.price >' => 0, 'Auction.autobid' => 1)));

		if(!empty($auctions)) {
			foreach ($auctions as $auction) {
				// for each auction we will generate a random number, depending on the number will depend on the action we take!
				$random = mt_rand(1, 100);

				if($random < 50) {
					// lets see if there are any autobutlers on this auction already
					$autobidderCount = $this->Auction->Bidbutler->find('count', array('conditions' => array('Bidbutler.auction_id' => $auction['Auction']['id'], 'Bidbutler.bids >' => 0, 'User.autobidder' => 1)));

					if($autobidderCount == 0) {
						// lets see if there are any bid buddies in the price range at the moment
						$userCount = $this->Auction->Bidbutler->find('count', array('conditions' => array('Bidbutler.auction_id' => $auction['Auction']['id'], 'Bidbutler.maximum_price >' => $auction['Auction']['price'], 'Bidbutler.minimum_price <=' => $auction['Auction']['price'], 'Bidbutler.bids >' => 0, 'User.autobidder' => 0)));
						if($userCount == 0) {
							$this->Auction->Bidbutler->placeAutoButler($auction['Auction']['id']);
						}
					}
				}
			}
		}
	}
}
?>