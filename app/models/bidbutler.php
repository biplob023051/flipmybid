<?php
	class Bidbutler extends AppModel {

		var $name = 'Bidbutler';

		var $belongsTo = array('User', 'Auction');

		var $actsAs = array('Containable');

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);
			$this->validate = array(
				'minimum_price' => array(
					'highLow' => array(
						'rule'=> array('highLow'),
						'message' => __('The minimum price must be higher than the maximum price.', true)
					),
					'comparison' => array(
						'rule'=> array('comparison', '>=', 0),
						'message' => __('The minimum price cannot be a negative number.', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('The minimum price can be a number only.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Minimum price is required.', true)
					)
				),
				'maximum_price' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'not equal', 0),
						'message' => __('The maximum price cannot be zero.', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('The maximum price can be a number only.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Maximum price is required.', true)
					)
				),
				'bids' => array(
					'balanceCheck' => array(
						'rule'=> array('balanceCheck'),
						'message' => __('This number exceeds the number of bids you have in your account.', true)
					),
					'bidRangeStandard' => array(
						'rule'=> array('bidRange', 'standard'),
						'message' => __('The number of bids must be at least 2 and no more than 250', true)
					),
					'bidRangeFeatured' => array(
						'rule'=> array('bidRange', 'featured'),
						'message' => __('The number of bids must be at least 2', true)
					),
					'bidRangeBeginner' => array(
						'rule'=> array('bidRange', 'beginner'),
						'message' => __('The number of bids must be at least 2 and no more than 100', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('The number of bids can be a number only.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Number of bids is required.', true)
					)
				),
				'pending_bids' => array(
					'rule'=> array('bidbutlerCheck'),
					'message' => __('This number exceeds the number of bids you have in your account and your pending bid buddies.', true)
				)
			);
		}

        /**
		 * Function to check that the number of bids is less than what is in their account
		 *
		 * @param array $data User id
		 * @return true if passed, false otherwise
		 */
        function balanceCheck($data) {
        	if(!empty($this->data['Bidbutler']['balance'])) {
	        	if($this->data['Bidbutler']['balance'] < $data['bids']) {
	        		return false;
	        	}
        	}

        	return true;
        }

        function bidbutlerCheck($data) {
			$total = $this->data['Bidbutler']['balance'] - ($this->data['Bidbutler']['pending_bids'] + $this->data['Bidbutler']['bids']);
			if($total >= 0) {
				return true;
			} else {
				return false;
			}
        }

		function bidRange($data, $type = 'standard') {
			if($type == 'standard') {
				if($this->data['Auction']['beginner'] == true || $this->data['Auction']['featured'] == true) {
					return true;
				}

				$limit = 250;
			} elseif($type == 'beginner') {
				if($this->data['Auction']['beginner'] == false) {
					return true;
				}

				$limit = 100;
			} elseif($type == 'featured') {
				if($this->data['Auction']['featured'] == false) {
					return true;
				}

				$limit = $data['bids'] + 1;
			}

			if($data['bids'] >= 2 && $data['bids'] <= $limit) {
				return true;
			} else {
				return false;
			}
        }

        /**
		* Function to check that the min price is less than the max price.
		*
		* @param array $data
		* @return true if passed, false otherwise
		*/
        function highLow($data) {
        	if(!empty($this->data['Bidbutler']['minimum_price']) && !empty($this->data['Bidbutler']['maximum_price'])) {
        		if($this->data['Bidbutler']['minimum_price'] < $this->data['Bidbutler']['maximum_price']) {
        			return true;
        		} else {
        			return false;
        		}
        	} else {
        		return true;
        	}
        }

		function placeAutoButler($auction_id, $featured = false, $beginner = false) {
			$user = $this->Auction->Smartbid->find('first', array('conditions' => array('Smartbid.auction_id' => $auction_id), 'order' => 'rand()', 'contain' => 'User', 'fields' => array('User.id', 'Smartbid.id')));

			//if there is no one lets get a new user!
			if(empty($user)) {
				$user = $this->User->find('first', array('conditions' => array('User.autobidder' => 1, 'User.active' => 1), 'order' => 'rand()', 'contain' => '', 'fields' => 'User.id'));
				$smartbid['Smartbid']['auction_id'] = $auction_id;
				$smartbid['Smartbid']['user_id'] = $user['User']['id'];

				$this->Auction->Smartbid->create();
				$this->Auction->Smartbid->save($smartbid);
			}

			if(!empty($user)) {
				$bidbutler['Bidbutler']['user_id'] = $user['User']['id'];
				$bidbutler['Bidbutler']['auction_id'] = $auction_id;
				// place a random number of bids depending on the type
				if($beginner == true) {
					$limit = 100;
				} elseif($featured == true) {
					$limit = 1000;
				} else {
					$limit = 250;
				}

				$bidbutler['Bidbutler']['bids'] = mt_rand(50, $limit);

				$this->create();
				$this->save($bidbutler, false);

				// update the user so they don't get selected again
				$user['User']['modified'] = date('Y-m-d H:i:s');
				$this->User->save($user, false);
			}
		}

		function removeAll($auction_id, $user_id, $price, $id = 0) {
			$bidbutlers = $this->find('all', array('conditions' => array('Bidbutler.auction_id' => $auction_id, 'Bidbutler.user_id' => $user_id, 'Bidbutler.bids >' => 0, 'Bidbutler.maximum_price >' => $price, 'Bidbutler.id <>' => $id), 'contain' => ''));
			if(!empty($bidbutlers)) {
				foreach ($bidbutlers as $bidbutler) {
					$bidbutler['Bidbutler']['bids'] = 0;
					$this->save($bidbutler, false);
				}
			}
		}

		function totalButlers($user_id = null, $auction_id = null) {
			$totalBids = 0;

			$bidbutlers = $this->find('all', array('conditions' => array('Bidbutler.user_id' => $user_id, 'Bidbutler.bids >' => 0, 'Auction.closed' => false, 'Auction.active' => true, 'Bidbutler.auction_id <>' => $auction_id), 'contain' => array('Auction' => 'Product.fixed')));

			if(!empty($bidbutlers)) {
				foreach ($bidbutlers as $bidbutler) {
					if($bidbutler['Auction']['price'] >= $bidbutler['Bidbutler']['minimum_price'] &&
					   $bidbutler['Auction']['price'] < $bidbutler['Bidbutler']['maximum_price'] ||
					   $bidbutler['Product']['fixed'] == 1) {
						$totalBids = $totalBids + $bidbutler['Bidbutler']['bids'];
					}
				}
			}
			return $totalBids;
		}
	}
?>