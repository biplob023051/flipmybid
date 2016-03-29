<?php
class AuctionsController extends AppController {

	var $name = 'Auctions';
	var $uses = array('Auction', 'Setting', 'Country', 'BuyItPackage');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index', 'view', 'live', 'home', 'future', 'closed', 'winners', 'featured', 'getcount', 'getstatus', 'latestwinner', 'endingsoon', 'getfutureauctions', 'getauctions', 'getwinners', 'getendedlist', 'free', 'product', 'serverload', 'search', 'timeout', 'getbeginners', 'getended', 'popup', 'getrecent', 'getlatest', 'easyview', 'frame', 'latest', 'captcha', 'upcoming_session_set');
		}
	}
        
        
	function getcount($type = null)	{
		$count = 0;

		if($type == 'live') {
			$count = $this->Auction->find('count', array('conditions' => "start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'"));
		} elseif($type == 'future') {
			$count = $this->Auction->find('count', array('conditions' => "start_time > '" . date('Y-m-d H:i:s') . "'"));
		} elseif($type == 'closed') {
			$count = $this->Auction->find('count', array('conditions' => array('closed' => 1)));
		} elseif($type == 'beginner') {
			$count = $this->Auction->find('count', array('conditions' => "Auction.beginner = 1 AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'"));
		} elseif($type == 'featured') {
			$count = $this->Auction->find('count', array('conditions' => "Auction.featured = 1 AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'"));
		}

		return $count;
	}

	function latestwinner($folder = 'thumbs') {
		return $this->Auction->getAuctions(array('Auction.winner_id >' => 0, 'Auction.closed' => 1), 1, 'Auction.end_time DESC', false, $folder);
	}

	function home() {
		$this->paginate = array('contain' => '', 'conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('title_for_layout', __('Live Auctions', true));
//		$featuredLimit 		= $this->Setting->get('home_featured_limit');
//		$endingLimit 		= $this->Setting->get('home_ending_limit');
//		$comingSoonLimit 	= $this->Setting->get('home_coming_soon_limit');
//
//		if(!empty($featuredLimit)) {
//			$featured  = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0, 'Auction.featured' => 1), $featuredLimit, 'Auction.end_time ASC', null, $this->Setting->get('home_featured_image_size'));
//
//			if(empty($featured) && $this->Setting->get('home_featured_auto_fill')) {
//				$featured  = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), $featuredLimit, 'Auction.end_time ASC', null, $this->Setting->get('home_featured_image_size'));
//			}
//
//			if(!empty($featured)) {
//				$this->set('featured', $featured);
//			}
//		}
//
//		if(!empty($endingLimit)) {
//			// lets see if there are any auctions to ingore
//			$excludeFeatured = array();
//			if(!empty($featured[0])) {
//				$excludeFeatured = $featured;
//			} elseif(!empty($featured)) {
//				$excludeFeatured[]['Auction']['id'] = $featured['Auction']['id'];
//			}
//
//			$endSoon  = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), $endingLimit, 'Auction.end_time ASC');
//			$this->set('auctions_end_soon', $endSoon);
//		}
//
//		if(!empty($comingSoonLimit)) {
//			// lets see if there are any auctions to ingore
//			$exclude = array();
//			if(!empty($endSoon[0])) {
//				$exclude = $endSoon;
//			} elseif(!empty($endSoon)) {
//				$exclude[]['Auction']['id'] = $endSoon['Auction']['id'];
//			}
//
//			$excludeAll = array_merge($excludeFeatured, $exclude);
//
//			$comingSoon  = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), $comingSoonLimit, 'Auction.end_time ASC', $excludeAll);
//			$this->set('auctions_coming_soon', $comingSoon);
//		}
	}

	function getendedlist() {
		$auctions = array();

		$endingSoon  = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), $this->Setting->get('home_ending_limit'), 'Auction.end_time ASC');
		if(!empty($endingSoon)) {
			foreach($endingSoon as $endSoon) {
				$auctions[] = $endSoon['Auction']['id'];
			}
		}

		return $auctions;
	}

	function getended($limit = 10) {
		return $this->Auction->getAuctions(array('Auction.active' => 1, 'Auction.closed' => 1, 'Auction.winner_id >' => 0), $limit, 'Auction.end_time DESC');
	}

	function getauctions($limit = null, $start_hour = null, $end_hour = null, $order = 'asc', $exclude = array()) {
		if(!empty($exclude)) {
			$exclude = explode(',', $exclude);
		}

		if(!empty($start_hour) && !empty($end_hour)) {
			$conditions = array('closed' => 0, 'Auction.active' => 1, 'Auction.end_time >=' => date('Y-m-d H:i:s', time() + $start_hour * 3600), 'Auction.end_time <=' => date('Y-m-d H:i:s', time() + $end_hour * 3600));
		} elseif(!empty($start_hour)) {
			$conditions = array('closed' => 0, 'Auction.active' => 1, 'Auction.end_time >=' => date('Y-m-d H:i:s', time() + $start_hour * 3600));
		} elseif(!empty($end_hour)) {
			$conditions = array('closed' => 0, 'Auction.active' => 1, 'Auction.end_time <=' => date('Y-m-d H:i:s', time() + $end_hour * 3600));
		} else {
			$conditions = array('closed' => 0, 'Auction.active' => 1);
		}

		$auctions = $this->Auction->find('all', array('conditions' => $conditions, 'contain' => '', 'fields' => array('Auction.id', 'Auction.closed', 'Auction.active', 'Auction.end_time'), 'limit' => $limit, 'order' => array('Auction.end_time' => $order)));

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				if(!in_array($auction['Auction']['id'], $exclude)) {
					$auctions[$key] = $auction;
				} else {
					unset($auctions[$key]);
				}
			}
		}

		return $auctions;
	}

	function getfutureauctions($limit = 4) {
		return $this->Auction->getAuctions(array("Auction.start_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), $limit, 'Auction.end_time ASC');
	}

	function getwinners($limit = 10) {
		return $this->Auction->getAuctions(array('Auction.winner_id >' => 0, 'Auction.closed' => 1), $limit, 'Auction.end_time DESC');
	}

	function getbeginners($limit = 5) {
		return $this->Auction->getAuctions(array("beginner = 1 AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), $limit, 'Auction.end_time ASC');
	}

	function getrecent($product_id = null) {
		$auction = $this->Auction->find('first', array('conditions' => array('Auction.product_id' => $product_id, 'Auction.closed' => true), 'contain' => '', 'fields' => 'price', 'order' => array('Auction.end_time' => 'desc')));
		if(!empty($auction)) {
			return $auction['Auction']['price'];
		} else {
			return false;
		}
	}

	function getlatest($limit = 10) {
		return $this->Auction->find('all', array('conditions' => array('Auction.closed' => false, "start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), 'contain' => 'Product.title', 'fields' => 'id', 'order' => array('Auction.start_time' => 'desc'), 'limit' => $limit));
	}

	function index() {
		$this->paginate = array('contain' => '', 'conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$futures = $this->Auction->find('all', array('contain' => '', 'conditions' => array("start_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'order' => array('Auction.end_time' => 'asc')));

		if(!empty($futures)) {
			foreach($futures as $key => $future) {
				$future = $this->Auction->getAuctions(array('Auction.id' => $future['Auction']['id']), 1);
				$futures[$key] = $future;
			}
		}
		$this->set('future', $futures);
		$this->set('title_for_layout', __('Live Auctions', true));
	}

	function easyview() {
		$this->paginate = array('contain' => '', 'conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);

		$this->set('title_for_layout', __('Easy View', true));
	}

	function beginner() {
		$this->paginate = array('contain' => '', 'conditions' => array("beginner = 1 AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->set('title_for_layout', __('Beginner Auctions', true));
	}

	function future() {
		$this->paginate = array('contain' => '', 'conditions' => array("start_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$auctionsAll = $this->Auction->find('all', array('contain' => '', 'conditions' => array("start_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'order' => array('Auction.end_time' => 'asc')));

		if(!empty($auctionsAll)) {
			foreach($auctionsAll as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctionsAll[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->set('auctionsAll', $auctionsAll);

		$this->set('future', 1);
		$this->set('title_for_layout', __('Coming Soon Auctions', true));
	}

	function closed() {
		if($this->Setting->get('closed_ended_auctions')) {
			$this->paginate = array('contain' => '', 'conditions' => array('closed' => 1, 'Auction.active' => 1), 'limit' => $this->Setting->get('closed_ended_auctions'), 'order' => array('Auction.end_time' => 'desc'));
			$auctions = $this->paginate();
		} else {
			$this->paginate = array('contain' => '', 'conditions' => array('closed' => 1, 'Auction.active' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'desc'));
			$auctions = $this->paginate();
		}

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		$this->set('title_for_layout', __('Closed Auctions', true));
	}

	function winners() {
		$this->paginate = array('contain' => '', 'conditions' => array('winner_id >' => 0, 'Auction.closed' => 1, 'Auction.active' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'desc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->set('title_for_layout', __('Winners', true));
	}

	function free() {
		$this->paginate = array('contain' => 'Product', 'conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Product.free' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);
		$this->set('title_for_layout', __('Free Auctions', true));
	}

	function featured() {
		$this->paginate = array('contain' => '', 'conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0, 'Auction.featured' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key] = $auction;
			}
		}

		$this->set('auctions', $auctions);

		$this->set('title_for_layout', __('Featured Auctions', true));
	}

	function search($search = null) {
		if(!empty($this->data['Auction']['search'])) {
			$this->redirect('/auctions/search/'.$this->data['Auction']['search']);
		}

		if(!empty($search)) {
			$this->paginate = array('contain' => 'Product', 'conditions' => array("(Product.title LIKE '%$search%' OR Product.description LIKE '%$search%') AND start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
			$auctions = $this->paginate();

			if(!empty($auctions)) {
				foreach($auctions as $key => $auction) {
					$auction = $this->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
					$auctions[$key] = $auction;
				}
			}

			$this->set('auctions', $auctions);
			$this->pageTitle = __('Search for:', true).' '.$search;

			$this->set('search', $search);
		} else {
			$this->Session->setFlash(__('You did not enter anything to search for.', true));
			$this->redirect($this->referer('/'));
		}
	}

	function user() {
		$auctions = $this->User->Auction->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0, 'Auction.closed' => 0), 'fields' => 'DISTINCT Bid.auction_id', 'contain' => 'Auction', 'order' => array('Auction.end_time' => 'asc')));
		$closed = $this->User->Auction->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0, 'Auction.closed' => 1), 'fields' => 'DISTINCT Bid.auction_id', 'contain' => 'Auction', 'order' => array('Auction.end_time' => 'desc')));

		$auctions = array_merge($auctions, $closed);

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auctions[$key] = $this->User->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
			}
		}

		$this->set('auctions', $auctions);

		$this->set('title_for_layout', __('My Auctions', true));
	}

	function product($product_id = null) {
		$auction = $this->Auction->find('first', array('contain' => 'Product', 'conditions' => array('Auction.closed' => 1, 'Auction.active' => 1, 'Auction.product_id' => $product_id), 'order' => array('Auction.end_time' => 'desc')));

		if(empty($auction)) {
			$auction = $this->Auction->find('first', array('contain' => 'Product', 'conditions' => array('Auction.closed' => 0, 'Auction.active' => 1, 'Auction.product_id' => $product_id), 'order' => array('Auction.end_time' => 'asc')));
		}

		if(!empty($auction)) {
			$this->redirect(array('action' => 'view', $auction['Auction']['id']));
		} else {
			$this->redirect('/');
		}
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action' => 'index'));
		}

		$auction = $this->Auction->getAuctions(array('Auction.id' => $id), 1, null, null, 'max');

		if (empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('auction', $auction);
		
		/* Change by Andrew Buchan */
		$bidCount = $this->Auction->Bid->find('all', array('contain' => '', 'conditions' => array('auction_id' => $id, 'user_id' => $this->Auth->user('id')), 'fields' => array('SUM(debit) as sumofbids'), 'group' => 'auction_id'));
		
		$this->set('sumofbids', $bidCount);
		/* End Change */
		
		/* Change by Andrew Buchan: Get buy it packages row based on user id and auction id */
		$exists = $this->BuyItPackage->find('first', array('contain' => '', 'conditions' => array('auction_id' => $id, 'user_id' => $this->Auth->user('id')), 'fields' => array('id'), 'order' => array('id DESC')));
		$this->set('exists', $exists);
		/* End Change */

		$this->set('watchlist', $this->Auction->Watchlist->find('first', array('contain' => '', 'conditions' => array('auction_id' => $id, 'user_id' => $this->Auth->user('id')))));

		$this->set('bidHistories', $this->Auction->Bid->histories($auction['Auction']['id'], $this->Setting->get('bid_history_limit'), $this->Setting->get('time_price'), $this->Setting->get('price_increment'), $auction['Auction']['price']));

		if(!empty($auction['Auction']['limit_id']) && $this->Setting->Module->enabled('win_limits')) {
			$this->set('limit', $this->Auction->Limit->find('first', array('conditions' => array('Limit.id' => $auction['Auction']['limit_id']), 'contain' => '')));
		}

		$this->set('title_for_layout', $auction['Product']['title']);
		if(!empty($auction['Product']['meta_description'])) {
			$this->set('meta_description', $auction['Product']['meta_description']);
		}
		if(!empty($auction['Product']['meta_keywords'])) {
			$this->set('meta_keywords', $auction['Product']['meta_keywords']);
		}

		if($this->Auth->user('id')) {
			// lets check to see if they have already exchanged this product
			$this->set('exchanged', $this->Auction->Exchange->find('count', array('conditions' => array('Exchange.auction_id' => $id, 'Exchange.user_id' => $this->Auth->user('id')))));

			// lets see if the auction has closed and they can still exchange it
			if(!empty($auction['Auction']['closed'])) {
				$totalBids = $this->requestAction('/bids/total/'.$auction['Auction']['id'].'/'.$this->Auth->user('id'));
				if($totalBids > 0) {
					// lets make sure they are not the winner
					if(empty($auction['Winner']['id'])) {
						$auction['Winner']['id'] = 0;
					}

					if($this->Auth->user('id') !== $auction['Winner']['id']) {
						// finally lets make sure the auction closed less than 24 hours ago
						if($auction['Auction']['end_time'] > time() - 86400) {
							$this->set('canExchange', true);
						}
					}
				}
			}
		} else {
			$this->set('exchanged', 0);
		}

		if($this->Setting->Module->enabled('auction_increments')) {
			$increments = $this->Auction->Increment->find('all', array('conditions' => array('Increment.auction_id' => $id), 'order' => array('low_price' => 'asc'), 'contain' => ''));
			$this->set('increments', $increments);
		}
	}

	function popup($id = null) {
		$this->layout = false;

		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action' => 'index'));
		}

		$auction = $this->Auction->getAuctions(array('Auction.id' => $id), 1, null, null, 'max');

		if (empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('auction', $auction);

		$this->set('watchlist', $this->Auction->Watchlist->find('first', array('contain' => '', 'conditions' => array('auction_id' => $id, 'user_id' => $this->Auth->user('id')))));

		$this->set('bidHistories', $this->Auction->Bid->histories($auction['Auction']['id'], $this->Setting->get('bid_history_limit')));

		if(!empty($auction['Auction']['limit_id']) && $this->Setting->Module->enabled('win_limits')) {
			$this->set('limit', $this->Auction->Limit->find('first', array('conditions' => array('Limit.id' => $auction['Auction']['limit_id']), 'contain' => '')));
		}

		$this->set('title_for_layout', $auction['Product']['title']);
		if(!empty($auction['Product']['meta_description'])) {
			$this->set('meta_description', $auction['Product']['meta_description']);
		}
		if(!empty($auction['Product']['meta_keywords'])) {
			$this->set('meta_keywords', $auction['Product']['meta_keywords']);
		}

		if($this->Auth->user('id')) {
			// lets check to see if they have already exchanged this product
			$this->set('exchanged', $this->Auction->Exchange->find('count', array('conditions' => array('Exchange.auction_id' => $id, 'Exchange.user_id' => $this->Auth->user('id')))));

			// lets see if the auction has closed and they can still exchange it
			if(!empty($auction['Auction']['closed'])) {
				$totalBids = $this->requestAction('/bids/total/'.$auction['Auction']['id'].'/'.$this->Auth->user('id'));
				if($totalBids > 0) {
					// lets make sure they are not the winner
					if($this->Auth->user('id') !== $auction['Winner']['id']) {
						// finally lets make sure the auction closed less than 24 hours ago
						if($auction['Auction']['end_time'] > time() - 86400) {
							$this->set('canExchange', true);
						}
					}
				}
			}
		} else {
			$this->set('exchanged', 0);
		}

		if($this->Setting->Module->enabled('auction_increments')) {
			$increments = $this->Auction->Increment->find('all', array('conditions' => array('Increment.auction_id' => $id), 'order' => array('low_price' => 'asc'), 'contain' => ''));
			$this->set('increments', $increments);
		}
	}

	function endingsoon($id = null, $product_id = null, $similiar = false, $limit = 4, $featuredOnly = false) {
		if($similiar == true) {
			if($featuredOnly == true) {
				$conditions = array('Auction.id <> '.$id, 'Auction.product_id = '.$product_id, 'Auction.featured' => true, 'Auction.closed' => 0, "Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'");
			} else {
				$conditions = array('Auction.id <> '.$id, 'Auction.product_id = '.$product_id, 'Auction.closed' => 0, "Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'");
			}

			$otherLimit = $limit;
			$limit = 1;
		} else {
			if($featuredOnly == true) {
				$conditions = array('Auction.id <> '.$id, 'Auction.featured' => true, 'Auction.closed' => 0, "Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'");
			} else {
				$conditions = array('Auction.id <> '.$id, 'Auction.closed' => 0, "Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'");
			}
		}

		$auctions = $this->Auction->getAuctions($conditions, $limit, array('Auction.end_time ASC'));

		if(!empty($otherLimit) && $otherLimit == 1 && !empty($auctions)) {
			return $auctions;
		}

		if($similiar == true) {
			if(empty($auctions)) {
				$auctions = $this->Auction->getAuctions($conditions, $otherLimit, array('Auction.end_time ASC'));
			} else {
				$otherLimit = $otherLimit - 1;
				$conditions = array('Auction.id <> '.$id, 'Auction.product_id <> '.$product_id, "Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'");
				$otherAuctions = $this->Auction->getAuctions($conditions, $otherLimit, array('Auction.end_time ASC'));
				$similar[] = $auctions;
				$auctions = array_merge($similar, $otherAuctions);
			}
		}

		return $auctions;
	}

	function won() {
		if($this->Setting->Module->enabled('multi_languages')) {
			$this->paginate = array('conditions' => array('Auction.winner_id' => $this->Auth->user('id'), 'Auction.closed' => 1), 'limit' => 50, 'order' => array('Auction.end_time' => 'desc'), 'contain' => array('Testimonial'));
			$auctions = $this->paginate();

			if(!empty($auctions)) {
				foreach ($auctions as $key => $auction) {
					// lets attach on the product and images
					$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => array('Image')));
					$auction['Product'] = $product['Product'];
					$auction['Product']['Image'] = $product['Image'];
					$auctions[$key]['Product'] = $auction['Product'];

					$status = $this->Auction->Status->find('first', array('conditions' => array('Status.id' => $auction['Auction']['status_id']), 'contain' => ''));
					$auctions[$key]['Status'] = $status['Status'];
				}
			}

			$this->set('auctions', $auctions);
		} else {
			$this->paginate = array('conditions' => array('Auction.winner_id' => $this->Auth->user('id'), 'Auction.closed' => 1), 'limit' => 50, 'order' => array('Auction.end_time' => 'desc'), 'contain' => array('Product' => 'Image', 'Status', 'Testimonial'));
			$this->set('auctions', $this->paginate());
		}

		$this->set('title_for_layout', __('Won Auctions', true));
	}

	function pay($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if($this->Setting->Module->enabled('multi_languages')) {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Winner')));
			if(!empty($auction)) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
				$auction['Product'] = $product['Product'];
			}
		} else {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Product', 'Winner')));
		}

		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if($auction['Auction']['status_id'] != 1) {
			$this->Session->setFlash(__('You have already paid for this auction.', true));
			$this->redirect(array('action'=>'won'));
		}

		$this->set('auction', $auction);

		$this->Auction->Winner->recursive = -1;
		$user = $this->Auction->Winner->read(null, $this->Auth->user('id'));
		if($user['Winner']['active'] == 0) {
			$user['Winner']['activate_link'] 	= $this->appConfigurations['url'] . '/users/activate/' . $user['Winner']['key'];
			$data['User']						= $user['Winner'];
			$data['to'] 				  		= $user['Winner']['email'];
			$data['subject'] 					= sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
			$data['template'] 			   		= 'users/activate';
			if($this->_sendEmail($data)) {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods.  We have sent you an activation email, please confirm your email address before attempting to pay for an auction.', true));
			} else {
				$this->Session->setFlash(__('You need to validate your account before we can send you your goods, however there was a problem sending the email, please contact us.', true));
			}
			$this->redirect(array('action' => 'won'));
		}
		$this->set('user', $user);

		$this->Auction->Winner->Address->UserAddressType->recursive = -1;
		$addresses 	 	 = $this->Auction->Winner->Address->UserAddressType->find('all');
		$userAddress 	 = array();
		$addressRequired = 0;

		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Auction->Winner->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
				if(empty($userAddress[$address['UserAddressType']['name']])) {
					$addressRequired = 1;
					$userAddress[$address['UserAddressType']['name']] = array('Address' => array('user_address_type_id' => $address['UserAddressType']['id']));
				}
			}
		}

		$this->set('address', $userAddress);
		$this->set('addressRequired', $addressRequired);

		$total = 0;
        if(!empty($auction['Auction']['free'])) {
			$total = $auction['Product']['delivery_cost'];
        } elseif(!empty($auction['Product']['fixed'])) {
        	$total = $auction['Product']['fixed_price'] + $auction['Product']['delivery_cost'];
        } else {
        	$total = $auction['Auction']['price'] + $auction['Product']['delivery_cost'];
        }

		// lets work out the total due!
		if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('redeemable_won_auctions')) {
			$credits = $this->Auction->Winner->Point->balance($this->Auth->user('id'));
			$this->set('credits', $credits);

			if($credits > 0) {
				$total = $auction['Product']['delivery_cost'];
			}
		}

		$this->set('total', $total);

		$this->set('title_for_layout', __('Pay for an Auction', true));
	}

	function payment($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if($this->Setting->Module->enabled('multi_languages')) {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Winner')));
			if(!empty($auction)) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
				$auction['Product'] = $product['Product'];
			}
		} else {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Product', 'Winner')));
		}

		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if(empty($auction['Auction']['payment']) && (!empty($auction['Product']['cash']) || (!empty($auction['Auction']['reverse']) && !empty($auction['Auction']['price_past_zero']) && $auction['Auction']['price'] < 0))) {
			// a bit lazy
		} else {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action'=>'pay', $id));
		}

		if(empty($this->data['Auction']['payment_method'])) {
			$this->Session->setFlash(__('Please select a payment method.', true));
			$this->redirect(array('action'=>'pay', $id));
		}

		$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));

		if(!empty($this->data['User'])) {
			$this->data['User']['id'] = $user['User']['id'];
			if($this->User->save($this->data)) {
				$data['Auction']['id'] = $id;
				$data['Auction']['payment'] = $this->data['Auction']['payment_method'];

				$this->Auction->save($data);

				$this->Session->setFlash(__('Your payment details have been updated successfully. Now please confirm your details below.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'pay', $id));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		}

		$this->data['User'] = $user['User'];

		if(empty($this->data['User']['amazon'])) {
			$this->data['User']['amazon'] = $this->data['User']['email'];
		}

		$this->set('auction', $auction);

		$total = 0;
        if(!empty($auction['Auction']['free'])) {
			$total = $auction['Product']['delivery_cost'];
        } elseif(!empty($auction['Product']['fixed'])) {
        	$total = $auction['Product']['fixed_price'] + $auction['Product']['delivery_cost'];
        } else {
        	$total = $auction['Auction']['price'] + $auction['Product']['delivery_cost'];
        }

		// lets work out the total due!
		if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('redeemable_won_auctions')) {
			$credits = $this->Auction->Winner->Point->balance($this->Auth->user('id'));
			$this->set('credits', $credits);

			if($credits > 0) {
				$total = $auction['Product']['delivery_cost'];
			}
		}

		$this->set('total', $total);

		$this->set('title_for_layout', __('Confirm Payment Method for an Auction', true));
	}

	function cancel_payment($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if($this->Setting->Module->enabled('multi_languages')) {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Winner')));
			if(!empty($auction)) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id'])));
				$auction['Product'] = $product['Product'];
			}
		} else {
			$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Product', 'Winner')));
		}

		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'won'));
		}

		if(empty($auction['Auction']['payment'])) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('action'=>'pay', $id));
		}

		$data['Auction']['id'] 		= $id;
		$data['Auction']['payment'] = '';

		$this->Auction->save($data);

		$this->Session->setFlash(__('Your payment method has been cancelled.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'pay', $id));
	}

	function timeout($url = null) {
		$url = base64_decode($url);
		if($url == '/') {
			$url = null;
		}

		$this->set('url', $url);

		$this->set('title_for_layout', __('Your Session has Timed Out', true));
	}

	function frame() {
		$this->layout = false;
	}

	function latest($product_id = 0) {
		$auction = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.product_id' => $product_id), 1, 'Auction.end_time', null, 'max');
		if(empty($auction)) {
			$auction = $this->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), 1, 'Auction.end_time', null, 'max');
		}

		return $auction;
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Auction.end_time DESC', 'Auction.closed ASC'), 'contain' => array('Product' => array('Category'), 'Status', 'Winner'));
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);



		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_live() {
		$this->paginate = array('conditions' => "start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('closed' => 'asc', 'end_time' => 'asc'), 'contain' => 'Status');
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);

		$this->set('extraCrumb', array('title' => 'Live Auctions', 'url' => 'live'));

		$this->render('admin_index');
		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_comingsoon(){
		$this->paginate = array('conditions' => "start_time > '" . date('Y-m-d H:i:s') . "'", 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('end_time' => 'asc'), 'contain' =>'Status');
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);

		$this->set('extraCrumb', array('title' => 'Coming Soon', 'url' => 'comingsoon'));

		$this->render('admin_index');
		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_closed(){
		$this->paginate = array('conditions' => array('closed' => 1), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('end_time' => 'desc'), 'contain' => array('Status', 'Winner'));
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);

		$this->set('extraCrumb', array('title' => 'Closed Auctions', 'url' => 'closed'));

		$this->render('admin_index');
		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_charity(){
		$this->paginate = array('conditions' => array('closed' => true, 'charity' => true), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('end_time' => 'desc'), 'contain' => array('Status', 'Winner'));
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);

		$this->set('extraCrumb', array('title' => 'Charity Auctions', 'url' => 'charity'));

		$this->render('admin_index');
		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_won($status_id = null) {
		if(!empty($status_id)) {
			$conditions = array('winner_id >' => 0, 'Winner.autobidder' => 0, 'Auction.status_id' => $status_id);
		} else {
			$conditions = array('winner_id >' => 0, 'Winner.autobidder' => 0);
		}

		$this->paginate = array('conditions' => $conditions, 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('end_time' => 'asc'), 'contain' => array('Status', 'Winner'));

		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);
		$this->set('statuses', $this->Auction->Status->find('list'));
		$this->set('selected', $status_id);
		$this->set('extraCrumb', array('title' => 'Won Auctions', 'url' => 'won'));
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Auction->Winner->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Auction.winner_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Auction.end_time' => 'asc'), 'contain' => 'Status');
		$auctions = $this->paginate('Auction');
		if(!empty($auctions)) {
			foreach ($auctions as $key => $auction) {
				$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$auction['Product'] = $product['Product'];

					$category = $this->Auction->Product->Category->find('first', array('conditions' => array('Category.id' => $product['Product']['category_id']), 'contain' => ''));
					if(!empty($category)) {
						$auction['Product']['Category'] = $category['Category'];
					}

					$auctions[$key]['Product'] = $auction['Product'];
				}
			}
		}

		$this->set('auctions', $auctions);
	}

	function admin_winner($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'index'));
		}

		$auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id), 'contain' => array('Winner', 'Status')));

		if(empty($auction)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'index'));
		}

		$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
		if(!empty($product)) {
			$auction['Product'] = $product['Product'];
		}

		if(!empty($this->data)) {
    		if(!empty($this->data['Auction']['resolved_charity'])) {
				$this->data['Auction']['charity'] = 0;
    		}

    		$this->Auction->save($this->data);

    		if($this->data['Auction']['inform'] == 1) {
    			$data = $this->Auction->find('first', array('conditions' => array('Auction.id' => $id), 'contain' => array('Winner', 'Status')));
    			$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($product)) {
					$data['Product'] = $product['Product'];
				}

				if(!empty($data['Winner']['language_id'])) {
					$language = $this->Language->find('first', array('conditions' => array('Language.id' => $data['Winner']['language_id']), 'recursive' => -1, 'fields' => 'code'));
					Configure::write('Config.language', $language['Language']['code']);

					$this->Auction->Product->locale = $language['Language']['code'];
				}

				$productTranslation 		= $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
				if(!empty($productTranslation)) {
					$auction['Product'] 	= $productTranslation['Product'];
				} else {
					$auction['Product'] 	= $product['Product'];
				}

    			$data['Status']['comment'] 	   = $this->data['Auction']['comment'];
    			$data['to'] 				   = $auction['Winner']['email'];
				$data['subject'] 			   = sprintf(__('%s - Auction Status Updated', true), $this->appConfigurations['name']);
				$data['template'] 			   = 'auctions/status';
				$this->_sendEmail($data);
    		}

			$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));
    		Configure::write('Config.language', $default['Language']['code']);

    		$this->Session->setFlash(__('The auction status was successfully updated.', true), 'default', array('class' => 'success'));
    		$this->redirect(array('action' => 'winner', $auction['Auction']['id']));
		}

		$this->set('auction', $auction);

		$this->Auction->Winner->recursive = -1;
		$user = $this->Auction->Winner->read(null, $auction['Auction']['winner_id']);
		$this->set('user', $user);

		$this->Auction->Winner->Address->UserAddressType->recursive = -1;
		$addresses = $this->Auction->Winner->Address->UserAddressType->find('all');
		$userAddress = array();
		$addressRequired = 0;
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->Auction->Winner->Address->find('first', array('conditions' => array('Address.user_id' => $auction['Auction']['winner_id'], 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
			}
		}
		$this->set('address', $userAddress);

		$this->set('selectedStatus', $auction['Auction']['status_id']);
		$this->set('statuses', $this->Auction->Status->find('list'));
	}

	function admin_add($product_id = null) {
		if(empty($product_id)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$this->Auction->Product->recursive = -1;
		$product = $this->Auction->Product->read(null, $product_id);
		if(empty($product)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$this->set('product', $product);

		if (!empty($this->data)) {
			if(empty($this->data['Auction']['autolist_minutes'])) {
				$this->data['Auction']['autolist_minutes'] = 0;
			}
			if(empty($this->data['Auction']['max_time'])) {
				$this->data['Auction']['max_time'] = 0;
			}
			if(empty($this->data['Auction']['autobids'])) {
				$this->data['Auction']['autobids'] = 0;
			}
			if(empty($this->data['Auction']['realbids'])) {
				$this->data['Auction']['realbids'] = 0;
			}
			if(empty($this->data['Auction']['limit_id'])) {
				$this->data['Auction']['limit_id'] = 0;
			}
			if(empty($this->data['Auction']['membership_id'])) {
				$this->data['Auction']['membership_id'] = 0;
			}
			if(empty($this->data['Auction']['reserve_price'])) {
				$this->data['Auction']['reserve_price'] = 0;
			}
			if(empty($this->data['Auction']['reverse_extend'])) {
				$this->data['Auction']['reverse_extend'] = 0;
			}
			if(empty($this->data['Auction']['bids_back_total'])) {
				$this->data['Auction']['bids_back_total'] = 0;
			}
			
			/* Change by Andrew Buchan - set buy it fields to 0/0.00 if they are not part of add request */
			if(empty($this->data['Auction']['buy_it'])) {
				$this->data['Auction']['buy_it'] = 0;
			}
			
			if(empty($this->data['Auction']['buy_it_reduction_amount'])) {
				$this->data['Auction']['buy_it_reduction_amount'] = 0.00;
			}
			
			/* End Change */

			if($this->Setting->get('randomize_autobids')) {
				if(!empty($this->data['Auction']['min_autobids']) && !empty($this->data['Auction']['max_autobids'])) {
					$this->data['Auction']['autobids'] = mt_rand($this->data['Auction']['min_autobids'], $this->data['Auction']['max_autobids']);
				} else {
					if(empty($this->data['Auction']['min_autobids'])) {
						$this->data['Auction']['min_autobids'] = 0;
					}
					if(empty($this->data['Auction']['max_autobids'])) {
						$this->data['Auction']['max_autobids'] = 0;
					}
				}

				if(!empty($this->data['Auction']['min_realbids']) && !empty($this->data['Auction']['max_realbids'])) {
					$this->data['Auction']['realbids'] = mt_rand($this->data['Auction']['min_realbids'], $this->data['Auction']['max_realbids']);
				} else {
					if(empty($this->data['Auction']['min_realbids'])) {
						$this->data['Auction']['min_realbids'] = 0;
					}
					if(empty($this->data['Auction']['max_realbids'])) {
						$this->data['Auction']['max_realbids'] = 0;
					}
				}
			}

			$this->data['Auction']['product_id'] = $product_id;
			$this->data['Auction']['price'] = $product['Product']['start_price'];

			$this->Auction->create();
			if ($this->Auction->save($this->data)) {
				$this->Session->setFlash(__('The auction has been added successfully.', true), 'default', array('class' => 'success'));
				if(!empty($this->data['Auction']['increments'])) {
					$this->redirect(array('controller' => 'increments', 'action'=>'auction', $this->Auction->getInsertID()));
				} elseif($this->Session->check('auctionsPage')) {
					$this->redirect('/'.$this->Session->read('auctionsPage'));
				} else {
					$this->redirect(array('controller' => 'products', 'action'=>'auctions', $product_id));
				}
			} else {
				$this->Session->setFlash(__('There was a problem adding the auction please review the errors below and try again.', true));
			}
		} else {
			$this->data['Auction']['active'] = 1;
			$this->data['Auction']['end_time'] = date('Y-m-d H:i:s', time() + 3600);
		}

		if($this->Setting->Module->enabled('win_limits')) {
			$this->set('limits', $this->Auction->Limit->find('list', array('order' => array('Limit.name' => 'asc'))));
		}

		if($this->Setting->Module->enabled('memberships')) {
			$this->set('memberships', $this->Auction->Membership->find('list', array('order' => array('Membership.rank' => 'asc'))));
		}
	}

	function admin_edit($id = null) {
		if (empty($id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Auction->recursive = -1;
		$auction = $this->Auction->read(null, $id);
		if(empty($auction)) {
			$this->Session->setFlash(__('The auction ID was invalid.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Auction->Product->recursive = -1;
		$product = $this->Auction->Product->read(null, $auction['Auction']['product_id']);
		if(empty($product)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$this->set('product', $product);

		if (!empty($this->data)) {
			if(empty($this->data['Auction']['autolist_minutes'])) {
				$this->data['Auction']['autolist_minutes'] = 0;
			}
			if(empty($this->data['Auction']['max_time'])) {
				$this->data['Auction']['max_time'] = 0;
			}
			if(empty($this->data['Auction']['autobids'])) {
				$this->data['Auction']['autobids'] = 0;
			}
			if(empty($this->data['Auction']['realbids'])) {
				$this->data['Auction']['realbids'] = 0;
			}
			if(empty($this->data['Auction']['limit_id'])) {
				$this->data['Auction']['limit_id'] = 0;
			}
			if(empty($this->data['Auction']['membership_id'])) {
				$this->data['Auction']['membership_id'] = 0;
			}
			if(empty($this->data['Auction']['reserve_price'])) {
				$this->data['Auction']['reserve_price'] = 0;
			}
			if(empty($this->data['Auction']['reverse_extend'])) {
				$this->data['Auction']['reverse_extend'] = 0;
			}
			if(empty($this->data['Auction']['bids_back_total'])) {
				$this->data['Auction']['bids_back_total'] = 0;
			}
			
			/* Change by Andrew Buchan - set buy it fields to 0/0.00 if they are not part of edit request */
			if(empty($this->data['Auction']['buy_it'])) {
				$this->data['Auction']['buy_it'] = 0;
				$this->data['Auction']['buy_it_reduction_amount'] = 0.00;
			}
			
			/* End Change */

			// lets only update the end time if its been changed!
			$endTime = $this->data['Auction']['end_time']['year'].'-'.$this->data['Auction']['end_time']['month'].'-'.$this->data['Auction']['end_time']['day'];
			$endTime .= ' '.$this->data['Auction']['end_time']['hour'].':'.$this->data['Auction']['end_time']['min'];
			if($endTime == substr($auction['Auction']['end_time'], 0, 16)) {
				unset($this->data['Auction']['end_time']);
			}

			if ($this->Auction->save($this->data)) {
				if(!empty($auction['Auction']['autobid']) && empty($this->data['Auction']['autobid'])) {
					// lets delete the auto buddies
					$this->Auction->Bidbutler->deleteAll(array('Bidbutler.auction_id' => $auction['Auction']['id'], 'User.autobidder' => true));
				}

				$this->Session->setFlash(__('The auction has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Session->check('auctionsPage')) {
					$this->redirect('/'.$this->Session->read('auctionsPage'));
				} else {
					$this->redirect(array('controller' => 'products', 'action'=>'auctions', $auction['Product']['id']));
				}
			} else {
				$this->Session->setFlash(__('There was a problem updating the auction please review the errors below and try again.', true));
			}
		} else {
			$this->data = $auction;
		}

		if($this->Setting->Module->enabled('win_limits')) {
			$this->set('limits', $this->Auction->Limit->find('list', array('order' => array('Limit.name' => 'asc'))));
		}

		if($this->Setting->Module->enabled('memberships')) {
			$this->set('memberships', $this->Auction->Membership->find('list', array('order' => array('Membership.rank' => 'asc'))));
		}
	}

	function admin_refund($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Auction.', true));
			$this->redirect($this->referer(array('action'=>'index')));
		}

		$auction = $this->Auction->read(null, $id);
		if(empty($auction)) {
			$this->Session->setFlash(__('The auction ID was invalid.', true));
			$this->redirect($this->referer(array('action'=>'index')));
		}

		$this->Auction->Bid->deleteAll(array('Bid.auction_id' => $id));

		$this->Auction->delete($id);

		$this->Session->setFlash(__('The bids were successfully refunded.', true), 'default', array('class' => 'success'));
		$this->redirect($this->referer(array('action'=>'index')));
	}

	function admin_resolved($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Auction.', true));
			$this->redirect($this->referer(array('action'=>'index')));
		}

		$auction['Auction']['id'] 		= $id;
		$auction['Auction']['charity'] 	= false;

		$this->Auction->save($auction);

		$this->Session->setFlash(__('The charity was successfully resolved.', true), 'default', array('class' => 'success'));
		$this->redirect($this->referer(array('action'=>'index')));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Auction.', true));
			$this->redirect($this->referer(array('action'=>'index')));

		}
		if ($this->Auction->delete($id)) {
			$this->Session->setFlash(__('The auction was deleted successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this auction.', true));
		}
		$this->redirect($this->referer(array('action'=>'index')));
	}

	public function upcoming_session_set()
	{
		if(!$this->Session->check('Upcoming.collapse')) {
			$this->Session->write('Upcoming.collapse', '0');
		} else {
			if( $this->Session->read('Upcoming.collapse')) {
				$this->Session->write('Upcoming.collapse', '0');
			} else {
				$this->Session->write('Upcoming.collapse', '1');
			}
		}
		die($this->Session->read('Upcoming.collapse'));
	}
}
?>
