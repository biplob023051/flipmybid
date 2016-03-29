<?php
class IncrementsController extends AppController {

	var $name = 'Increments';

	function beforeFilter(){
		parent::beforeFilter();

		if(!$this->Setting->Module->enabled('auction_increments')) {
			$this->cakeError('error404'); die;
		}
	}

	function admin_auction($auction_id = null) {
		if (empty($auction_id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}

		$auction = $this->Increment->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => 'Product'));
		if(empty($auction)) {
			$this->Session->setFlash(__('The auction ID was invalid.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}

		$this->set('auction', $auction);

		$this->paginate = array('conditions' => array('Increment.auction_id' => $auction_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('low_price' => 'asc'), 'contain' => '');
		$this->set('increments', $this->paginate());
	}

	function admin_add($auction_id = null) {
		if (empty($auction_id)) {
			$this->Session->setFlash(__('Invalid Auction', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}

		$auction = $this->Increment->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => 'Product'));
		if(empty($auction)) {
			$this->Session->setFlash(__('The auction ID was invalid.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}

		if (!empty($this->data)) {
			$this->Increment->create();
			$this->data['Increment']['auction_id'] = $auction_id;

			if(empty($this->data['Increment']['high_price'])) {
				$this->data['Increment']['high_price'] = 0;
			}
			if(empty($this->data['Increment']['low_price'])) {
				$this->data['Increment']['low_price'] = 0;
			}

			if ($this->Increment->save($this->data)) {
				$this->Session->setFlash(__('The auction increment has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'auction', $auction_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the increment please review the errors below and try again.', true));
			}
		}

		$this->set('auction', $auction);
	}

	function admin_edit($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Increment', true));
			$this->redirect($this->referer(array('controllers' => 'auctions', 'action'=>'index')));
		}

		$auction = $this->Increment->find('first', array('conditions' => array('Increment.id' => $id), 'contain' => array('Auction' => 'Product')));

		if(empty($auction)) {
			$this->Session->setFlash(__('The auction ID was invalid.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'index'));
		}
		if(!empty($auction['Auction']['Product'])) {
			$auction['Product'] = $auction['Auction']['Product'];
		}

		if (!empty($this->data)) {
			if(empty($this->data['Increment']['high_price'])) {
				$this->data['Increment']['high_price'] = 0;
			}
			if(empty($this->data['Increment']['low_price'])) {
				$this->data['Increment']['low_price'] = 0;
			}

			$this->data['Increment']['id'] = $id;
			if ($this->Increment->save($this->data)) {
				$this->Session->setFlash(__('The auction increment has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'auction', $auction['Auction']['id']));
			} else {
				$this->Session->setFlash(__('The auction increment could not be saved. Please, try again.', true));
			}
		} else {
			$this->data = $auction;
		}

		$this->set('auction', $auction);
		$this->set('id', $id);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Country', true));
			$this->redirect($this->referer(array('controllers' => 'auctions', 'action'=>'index')));
		}
		if ($this->Increment->delete($id)) {
			$this->Session->setFlash(__('The auction increment was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect($this->referer(array('controllers' => 'auctions', 'action'=>'index')));
		}
	}
}
?>