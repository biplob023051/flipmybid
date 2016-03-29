<?php
	class Auction extends AppModel {

		var $name = 'Auction';

		var $actsAs = array('Containable');

		var $belongsTo = array(
			'Product',
			'Status',
			'Winner' => array(
				'className'  => 'User'
			),
			'Limit',
			'Membership'
		);

		var $hasOne = array(
			'AuctionEmail', 'Testimonial'
		);

		var $hasMany = array(
			'Bidbutler'  => array(
				'limit'      => 10,
				'dependent'  => true
			),

			'Bid' => array(
				'order'      => array('Bid.id' => 'desc'),
				'limit'      => 10,
				'dependent'  => true
			),

			'Autobid' => array(
				'limit'      => 10,
				'dependent'  => true
			),

			'Smartbid' => array(
				'limit'      => 10,
				'dependent'  => true
			),

			'Watchlist' => array(
				'limit' 	 => 10,
				'dependent'  => true
			),
			'Exchange',
			'Increment',
			'BuyItPackage'
		);

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'end_time' => array(
				    'endTimeCheck' => array(
						'rule'=> 'endTimeCheck',
						'message' => __('The end time cannot be in the past.', true),
						'allowEmpty' => true
					),
					'endTimeStartTime' => array(
						'rule'=> 'endTimeStartTime',
						'message' => __('The end time must be greater than the start time.', true),
						'allowEmpty' => true
					)
				),
				'autolist_minutes' => array(
					'rule'=> 'numeric',
					'message' => __('Autolist minutes can be a number only.', true),
					'allowEmpty' => true
				),
				'max_time' => array(
					'rule'=> 'numeric',
					'message' => __('Max Time can be a number only.', true),
					'allowEmpty' => true
				),
				'autobids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Autobids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Autobids can be a number only.', true),
						'allowEmpty' => true
					)
				),
				'min_autobids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Autobids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Autobids can be a number only.', true),
						'allowEmpty' => true
					)
				),
				'max_autobids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Autobids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Autobids can be a number only.', true),
						'allowEmpty' => true
					)
				),
				'realbids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Real bids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Real bids can be a number only.', true),
						'allowEmpty' => true
					)
				),
				'min_realbids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Real bids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Real bids can be a number only.', true),
						'allowEmpty' => true
					)
				),
				'max_realbids' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'greater or equal', 0),
						'message' => __('Real bids cannot be a negative number.', true),
						'allowEmpty' => true
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('Real bids can be a number only.', true),
						'allowEmpty' => true
					)
				)
			);
		}

		/**
		 * Function to get auctions
		 *
		 * @param array $conditions The conditions
		 * @param int $limit How many auction will be retrieved
		 * @param string $order Ordering string
		 * @return array Auctions array
		 */
		function getAuctions($conditions = null, $limit = null, $order = 'Auction.end_time DESC', $exclude = false, $folder = 'thumbs') {
			$excludeId = array();
			if(!empty($exclude)){
				foreach($exclude as $excludeAuction){
					$excludeId[] = $excludeAuction['Auction']['id'];
				}
			}

			if(!empty($conditions) && !empty($excludeId)){
				if(is_array($conditions)){
					$conditions[] = 'Auction.id NOT IN (' . implode(',', $excludeId) .')';
				}
			}

			$auctions = $this->find('all', array('conditions' => $conditions, 'hide' => true, 'order' => $order, 'limit' => $limit, 'recursive' => -1));

			if(empty($auctions)) {
				return false;
			}

			foreach($auctions as $key => $auction) {
				// lets attach on the product and images
				$product = $this->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => array('Image')));
				if(empty($product)) {
					// lets try the default language version!
					$this->Product->locale = 'eng';
					$product = $this->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => array('Image')));
				}

				$auction['Product'] = $product['Product'];
				$auction['Product']['Image'] = $product['Image'];
				$auctions[$key]['Product'] = $auction['Product'];

				// has the auction closed
				if(!empty($auction['Auction']['winner_id']) && !empty($auction['Auction']['closed'])) {
					$winner = $this->Winner->find('first', array('conditions' => array('Winner.id' => $auction['Auction']['winner_id']), 'recursive' => -1));
					if(!empty($winner)) {
						$auctions[$key]['Winner'] = $winner['Winner'];
					}
				}

				// lets see if we need to get the memberships
				if(!empty($auction['Auction']['membership_id'])) {
					// lets get the default membership
					$membership = $this->Membership->find('first', array('conditions' => array('Membership.id' => $auction['Auction']['membership_id']), 'contain' => '', 'fields' => 'Membership.name'));
					if(!empty($membership)) {
						$auctions[$key]['Membership'] = $membership['Membership'];
					}
				}

				// Check if auction already started
				if(strtotime($auction['Auction']['start_time']) > time()) {
					$auctions[$key]['Auction']['isFuture'] = true;
				} elseif(!empty($auction['Auction']['closed'])) {
					$auctions[$key]['Auction']['isClosed'] = $auction['Auction']['closed'];
				}

				// Put it back into the array
				$auctions[$key]['Auction']['end_time'] = strtotime($auction['Auction']['end_time']);

				// Get savings
				// Get savings
                if($auction['Product']['rrp'] > 0) {
                    if(!empty($auction['Product']['fixed'])) {
                        if($auction['Product']['fixed_price'] > 0) {
                            $auctions[$key]['Auction']['savings']['percentage'] = round(100 - ($auction['Product']['fixed_price'] / $auction['Product']['rrp'] * 100), 2);
                        } else {
                            $auctions[$key]['Auction']['savings']['percentage'] = 100;
                        }
                    	$auctions[$key]['Auction']['savings']['price']  = $auction['Product']['rrp'] - $auction['Product']['fixed_price'];
                    } else {
                   		$auctions[$key]['Auction']['savings']['percentage'] = round(100 - ($auction['Auction']['price'] / $auction['Product']['rrp'] * 100), 2);
                    	$auctions[$key]['Auction']['savings']['price']      = $auction['Product']['rrp'] - $auction['Auction']['price'];
                    }
                } else {
                    $auctions[$key]['Auction']['savings']['percentage'] = 0;
                    $auctions[$key]['Auction']['savings']['price']      = 0;
                }

				if(!empty($auction['Product']['Image'])) {
					$auctions[$key]['Auction']['image'] = 'product_images/'.$folder.'/'.$auction['Product']['Image'][0]['image'];
				}

				$lastBid = $this->Bid->lastBid($auction['Auction']['id']);
				if(!empty($lastBid)) {
					$auctions[$key]['LastBid'] = $lastBid;
				} else {
					$auctions[$key]['LastBid']['username'] = __('No bids placed yet', true);
				}

				$auction['Auction']['serverTimestamp'] = time();
			}

			if($limit == 1){
				if(!empty($auctions[0])){
					return $auctions[0];
				}
			}

			return $auctions;
		}

		function beforeSave() {
			if(!empty($this->data['Auction']['autolist_time'])) {
				if($this->data['Auction']['autolist_time']['min'] < 10) {
					$this->data['Auction']['autolist_time']['min'] = '0'.$this->data['Auction']['autolist_time']['min'];
				}

				$this->data['Auction']['autolist_time'] = $this->data['Auction']['autolist_time']['hour'].':'.$this->data['Auction']['autolist_time']['min'];
			}

			$this->clearCache();
			return true;
		}

		function count($type = null) {
			if(!empty($type)){
				switch($type){
					case 'live':
						$count = $this->find('count', array('conditions' => "start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'"));
						break;

					case 'comingsoon':
						$count = $this->find('count', array('conditions' => "start_time > '" . date('Y-m-d H:i:s') . "'"));
						break;

					case 'closed':
						$count = $this->find('count', array('conditions' => array('closed' => 1)));
						break;

					case 'free':
						$count = $this->find('count', array('conditions' => "Product.free = 1 AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'"));
						break;

					default:
						$count = 0;
				}

				return $count;
			} else {
				return false;
			}
		}

		function afterSave($created){
			parent::afterSave($created);

			$this->clearCache();
			return true;
		}

		function afterDelete(){
			parent::afterDelete();

			$this->clearCache();
			return true;
		}

		function clearCache() {
			if(!empty($this->data['Auction']['id'])) {
				Cache::delete('auction_view_'.$this->data['Auction']['id']);
				Cache::delete('auction_'.$this->data['Auction']['id']);
			}
		}

		function randomize() {
			$digit = mt_rand(0, 200);
			return $digit / 100 + 1;
		}

		function checkLimits($user_id = 0, $limit_id = 0, $autobid = false, $auction_id = 0) {
			if(empty($user_id) || empty($limit_id)) {
				return true;
			}

			if($this->SettingsController->enabled('win_limits') == false) {
				return true;
			}

			if($autobid == true) {
				return true;
			}

			$limit = $this->Limit->find('first', array('conditions' => array('Limit.id' => $limit_id), 'contain' => '', 'fields' => array('Limit.limit', 'Limit.days')));

			if(empty($limit)) {
				return true;
			}

			$expiryDate = date('Y-m-d H:i:s', time() - ($limit['Limit']['days'] * 24 * 60 * 60));

			// note how for bid buddy check, we check the auction_id
			$totalWins = $this->find('count', array('conditions' => array('Auction.id <>' => $auction_id, 'Auction.leader_id' => $user_id, 'Auction.end_time >' => $expiryDate), 'recursive' => -1));

			if($totalWins >= $limit['Limit']['limit']) {
				return false;
			} else {
				return true;
			}
		}

		function checkBeginner($user_id = null, $autobid = false, $beginner = false) {
			if($autobid == false && $beginner == true) {
				$totalWins = $this->find('count', array('conditions' => array('Auction.closed' => 1, 'Auction.winner_id' => $user_id)));

				if($totalWins > 0) {
					return false;
				} else {
					return true;
				}
			} else {
				return true;
			}
		}

		function endTimeCheck() {
			if(strtotime($this->data['Auction']['end_time']) < time()) {
				return false;
			}

			return true;
		}

		function endTimeStartTime() {
			if(strtotime($this->data['Auction']['end_time']) < strtotime($this->data['Auction']['start_time'])) {
				return false;
			}

			return true;
		}
	}
?>