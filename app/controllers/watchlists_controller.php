<?php
class WatchlistsController extends AppController {

	var $name = 'Watchlists';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->paginate = array('conditions' => array('User.id' => $this->Auth->user('id'), 'Auction.id >' => 0), 'limit' => 50, 'order' => array('Auction.end_time' => 'asc'), 'contain' => array('Auction', 'User'));
		$auctions = $this->paginate();

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$watchlist['Watchlist'] = $auction['Watchlist'];
				$auction = $this->Watchlist->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auction = array_merge($watchlist, $auction);
				$auctions[$key] = $auction;
			}
		}

		$this->set('watchlists', $auctions);

		$this->set('title_for_layout', __('My Watchlist', true));
	}

	function add($auction_id = null) {
		if(!empty($auction_id)){
			$watchlist = $this->Watchlist->find('first', array('conditions' => array('Auction.id' => $auction_id, 'User.id' => $this->Auth->user('id'))));

			if(empty($watchlist)){
				$watchlist['Watchlist']['auction_id'] = $auction_id;
				$watchlist['Watchlist']['user_id'] 	  = $this->Auth->user('id');

				if($this->Watchlist->save($watchlist)){
					$this->Session->setFlash(__('The auction has been added to your watch list.', true), 'default', array('class' => 'success'));
					$this->redirect($this->referer('/auction/'.$auction_id));
				}else{
					$this->Session->setFlash(__('The auction cannot be added to the watchlist.', true));
					$this->redirect($this->referer('/auction/'.$auction_id));
				}
			}else{
				$this->Session->setFlash(__('The auction is already in your watchlist.', true));
				$this->redirect($this->referer('/auction/'.$auction_id));
			}
		}else{
			$this->Session->setFlash(__('Invalid auction.', true));
			$this->redirect($this->referer('/auction/'.$auction_id));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Watchlist', true));
			$this->redirect($this->referer('/'));
		}
		if ($this->Watchlist->delete($id)) {
			$this->Session->setFlash(__('The auction has been deleted from your watchlist.', true), 'default', array('class' => 'success'));
			$this->redirect($this->referer('/watchlists/index'));
		}
	}

	function remove($auction_id = null) {
		$watchlist = $this->Watchlist->find('first', array('conditions' => array('Watchlist.user_id' => $this->Auth->user('id'), 'Watchlist.auction_id' => $auction_id), 'fields' => 'id'));

		if(!empty($watchlist)) {
			$this->Watchlist->delete($watchlist['Watchlist']['id']);
			$this->Session->setFlash(__('The auction has been deleted from your watchlist.', true), 'default', array('class' => 'success'));
			$this->redirect($this->referer('/watchlists'));
		} else {
			$this->Session->setFlash(__('Invalid id for Watchlist', true));
			$this->redirect($this->referer('/'));
		}
	}

	function count() {
		return $this->Watchlist->find('count', array('conditions' => array('Watchlist.user_id' => $this->Auth->user('id'), 'Watchlist.auction_id >' => 0)));
	}

	function check($auction_id) {
		$count = $this->Watchlist->find('count', array('conditions' => array('Watchlist.user_id' => $this->Auth->user('id'), 'Watchlist.auction_id' => $auction_id)));

		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>