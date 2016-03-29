<?php
	class Bid extends AppModel {

		var $name = 'Bid';

		var $actsAs = array('Containable');

		var $belongsTo = array('Auction', 'User');

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'description' => array(
					'rule' => array('notEmpty'),
					'message' => __('Description is a required field.', true)
				),
				'total' => array(
					'comparison' => array(
						'rule'=> array('comparison', 'not equal', 0),
						'message' => __('The total cannot be zero.', true)
					),
					'numeric' => array(
						'rule'=> 'numeric',
						'message' => __('The total can be a number only.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Total is required.', true)
					)
				),
				'bids' => array(
					'rule'=> 'numeric',
					'message' => __('Free Bids can be a number only.', true),
					'allowEmpty' => true
				)
			);
		}

		function beforeSave(){
			// double bid fix - if the variable double_bids_check is passed then it will check for this
			if(!empty($this->data['Bid']['double_bids_check'])) {
				$doubleBid = $this->doubleBidsCheck($this->data['Bid']['auction_id'], $this->data['Bid']['user_id']);
				if($doubleBid == false) {
					return false;
				}
			}

			return true;
		}

		public function bought($user_id)
		{
			$lastBuy = $this->find('all', array(
				'conditions' => array(
					'Bid.user_id' => $user_id,
					"description like '%purchased%'",
					' credit > 0'
					),
				'limit' => 1,
				'order' => array('created DESC'),
				'fields' => "credit, created")
			);
			if(!empty($lastBuy[0]['Bid']['credit'])) {
				$toReturn = $lastBuy[0]['Bid']['credit'];
			} else {
				$toReturn = 100;
			}
			return $toReturn;
		}

		/**
		 * Function to get bid balance
		 *
		 * @param int $user_id User id
		 * @return int Balance of user's bid
		 */
		function balance($user_id) {
			$credit = $this->find('all', array('conditions' => array('Bid.user_id' => $user_id), 'fields' => "SUM(Bid.credit) as 'credit'"));
			if(empty($credit[0][0]['credit'])) {
				$credit[0][0]['credit'] = 0;
			}

			$debit  = $this->find('all', array('conditions' => array('Bid.user_id' => $user_id), 'fields' => "SUM(Bid.debit) as 'debit'"));
			if(empty($debit[0][0]['debit'])) {
				$debit[0][0]['debit'] = 0;
			}

			$user = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => '', 'fields' => 'User.bid_balance'));

			return $user['User']['bid_balance'] + $credit[0][0]['credit'] - $debit[0][0]['debit'];
		}

        /**
         * Function to get bid history for an auction
         *
         * @param int $auction_id Id of an auction
         * @param int $limit Number of history which will be retrieved
         * @return array Array of bid histories
         */
        function histories($auction_id = null, $limit = 10, $time_price = 'time', $priceIncrement = 0, $price = 0) {
            if($time_price == 'price') {
				$bids = $this->find('all', array('conditions' => array('Bid.auction_id' => $auction_id, 'Bid.debit >' => 0), 'fields' => array('Bid.id', 'Bid.debit', 'Bid.description', 'Bid.user_id', 'Bid.created'), 'contain' => 'User.username', 'limit' => $limit, 'order' => 'Bid.id DESC'));

	            if(!empty($bids)) {
					$lastPrice = $price;
					foreach ($bids as $key => $bid) {
						$bids[$key]['Bid']['amount'] = $lastPrice;

						// lets update the last price
						$lastPrice -= $priceIncrement;
					}
	            }

	            return $bids;
            } else {
            	return $this->find('all', array('conditions' => array('Bid.auction_id' => $auction_id, 'Bid.debit >' => 0), 'fields' => array('Bid.id', 'Bid.debit', 'Bid.created', 'Bid.description', 'Bid.user_id'), 'contain' => 'User.username', 'limit' => $limit, 'order' => 'Bid.id DESC'));
            }
        }

		/**
         * Function to get the last bidder information
         *
         * @param int $auction_id Id of an auction
         * @return array the lastest bidder
         */
        function lastBid($auction_id = null) {
			// Use contain user only and get bid.auction_id instead of auction.id
			// cause it needs the auction included in result array
			$lastBid = $this->find('first', array('conditions' => array('Bid.auction_id' => $auction_id), 'order' => 'Bid.id DESC', 'contain' => array('User')));
			$bid = array();

			if(!empty($lastBid)) {
				$bid = array(
					'debit'       => $lastBid['Bid']['debit'],
					'created'     => $lastBid['Bid']['created'],
					'username'    => $lastBid['User']['username'],
					'description' => $lastBid['Bid']['description'],
					'user_id'     => $lastBid['User']['id'],
					'autobidder'  => $lastBid['User']['autobidder']
				);
			}
			return $bid;

        }

        function doubleBidsCheck($auction_id, $user_id) {
        	$lastBid = $this->lastBid($auction_id);

        	if(!empty($lastBid)) {
        		if($lastBid['user_id'] == $user_id) {
        			return false;
        		} else {
        			return true;
        		}
        	} else {
        		return true;
        	}
        }

		function refundBidButlers($auction_id, $price = null) {
			if(!empty($price)) {
				$conditions = array('Bidbutler.auction_id' => $auction_id, 'Bidbutler.bids >' => 0, 'Bidbutler.maximum_price <' => $price);
			} else {
				$conditions = array('Bidbutler.auction_id' => $auction_id, 'Bidbutler.bids >' => 0);
			}

			$bidbutlers = $this->Auction->Bidbutler->find('all', array('conditions' => $conditions, 'contain' => ''));
			if(!empty($bidbutlers)) {
				foreach($bidbutlers as $bidbutler) {
					$data['Bid']['user_id'] 	= $bidbutler['Bidbutler']['user_id'];
					$data['Bid']['description'] = __('Bid Buddy Refunded Bids', true);
					$data['Bid']['credit']      = $bidbutler['Bidbutler']['bids'];

					$this->create();
					$this->save($data);

					$bidbutler['Bidbutler']['bids'] = 0;
					$this->Auction->Bidbutler->save($bidbutler);
				}
			}
		}
	}
?>