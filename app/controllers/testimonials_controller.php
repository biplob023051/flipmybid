<?php
class TestimonialsController extends AppController {

	var $name = 'Testimonials';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index');
		}
	}

	function index() {
		$this->paginate = array('conditions' => array('Testimonial.approved' => true), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Testimonial.order' => 'asc', 'Testimonial.id' => 'desc'), 'contain' => array('Auction', 'User'));
		$testimonials = $this->paginate();

		if(!empty($testimonials)) {
			foreach ($testimonials as $key => $testimonial) {
				if(!empty($testimonial['Auction']['product_id'])) {
					$product = $this->Testimonial->Auction->Product->find('first', array('conditions' => array('Product.id' => $testimonial['Auction']['product_id']), 'contain' => ''));
					$testimonials[$key]['Auction']['Product'] = $product['Product'];
				}
			}
		}

		$this->set('testimonials', $testimonials);

		$this->set('title_for_layout', __('Testimonials', true));
	}

	function add($auction_id = null) {
		$auction = $this->Testimonial->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id, 'Auction.winner_id' => $this->Auth->user('id')), 'contain' => array('Testimonial', 'Winner')));

		if(empty($auction)) {
			$this->Session->setFlash(__('You cannot add a testimonial to this auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
		}

		if(!empty($auction['Testimonial']['id'])) {
			$this->Session->setFlash(__('You have already placed a testimonial on this auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
		}

		if(!empty($auction['Auction']['product_id'])) {
			$product = $this->Testimonial->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
			$auction['Product'] = $product['Product'];
		}

		$this->set('auction', $auction);

		if(!empty($auction['Product']['bids']) && empty($auction['Auction']['beginner'])) {
			$this->Session->setFlash(__('You cannot place a testimonial on this auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
		}

		if (!empty($this->data)) {
			$this->data['Testimonial']['approved'] 	 = 0;
			$this->data['Testimonial']['auction_id'] = $auction_id;
			$this->data['Testimonial']['user_id']	 = $this->Auth->user('id');
			$this->data['Testimonial']['order'] 	 = 0;

			$this->Testimonial->create();
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The testimonial has been added successfully.  If approved will show on the website and your free bids will be credited to your account.', true), 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the testimonial please review the errors below and try again.', true));
			}
		} else {
			$this->data['Testimonial']['name'] = $auction['Winner']['first_name'];
			$this->data['Testimonial']['location'] = $this->requestAction('/users/ip/'.$auction['Winner']['ip']);
		}
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Testimonial.order' => 'asc', 'Testimonial.id' => 'desc'), 'contain' => array('Auction', 'User'));
		$testimonials = $this->paginate();

		if(!empty($testimonials)) {
			foreach ($testimonials as $key => $testimonial) {
				if(!empty($testimonial['Auction']['product_id'])) {
					$product = $this->Testimonial->Auction->Product->find('first', array('conditions' => array('Product.id' => $testimonial['Auction']['product_id']), 'contain' => ''));
					$testimonials[$key]['Auction']['Product'] = $product['Product'];
				}
			}
		}

		$this->set('testimonials', $testimonials);
	}

	function admin_add() {
		if (!empty($this->data)) {
			if(!empty($this->data['Testimonial']['auction_id'])) {
				$auction = $this->Testimonial->Auction->find('first', array('conditions' => array('Auction.id' => $this->data['Testimonial']['auction_id']), 'contain' => '', 'fields' => 'Auction.winner_id'));
				$this->data['Testimonial']['user_id'] = $auction['Auction']['winner_id'];
			}

			$this->data['Testimonial']['approved'] 	 = 1;
			$this->data['Testimonial']['order'] 	 = 0;

			$this->Testimonial->create();
			if ($this->Testimonial->save($this->data)) {
				$this->Session->setFlash(__('The testimonial has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the testimonial please review the errors below and try again.', true));
			}
		} else {
			$user = $this->Testimonial->User->find('first', array('conditions' => array('User.autobidder' => 0), 'contain' => '', 'order' => 'rand()'));

			$this->data['Testimonial']['name'] = $user['User']['first_name'];
			$this->data['Testimonial']['location'] = $this->requestAction('/users/ip/'.$user['User']['ip']);
		}

		$this->set('auctions', $this->Testimonial->autobidWinners());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}

		$testimonial = $this->Testimonial->find('first', array('conditions' => array('Testimonial.id' => $id), 'contain' => array('Auction', 'User')));
		if(empty($testimonial)) {
			$this->Session->setFlash(__('Invalid Testimonial', true));
			$this->redirect(array('action'=>'index'));
		}

		$product = $this->Testimonial->Auction->Product->find('first', array('conditions' => array('Product.id' => $testimonial['Auction']['product_id']), 'contain' => ''));
		if(!empty($product)) {
			$testimonial['Auction']['Product'] = $product['Product'];
		}

		if (!empty($this->data)) {
			if ($this->Testimonial->save($this->data)) {
				if(!empty($this->data['Testimonial']['approved']) && empty($testimonial['Testimonial']['approved']) && $this->Setting->get('testimonial_free_bids')) {
					if(!empty($testimonial['User']['language_id'])) {
						$language = $this->Language->find('first', array('conditions' => array('Language.id' => $testimonial['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
						Configure::write('Config.language', $language['Language']['code']);

						$this->Testimonial->Auction->Product->locale = $language['Language']['code'];
					}

					$productTranslation 		= $this->Testimonial->Auction->Product->find('first', array('conditions' => array('Product.id' => $testimonial['Auction']['product_id']), 'contain' => ''));
					if(!empty($productTranslation)) {
						$testimonial['Auction']['Product'] 	= $productTranslation['Product'];
					} else {
						$testimonial['Auction']['Product'] 	= $product['Product'];
					}

					$bid['Bid']['user_id'] = $testimonial['Auction']['winner_id'];
					$bid['Bid']['description'] = __('Free bid(s) given for submitting a testimonial.', true);
					$bid['Bid']['credit'] = $this->Setting->get('testimonial_free_bids');

					$this->Testimonial->User->Bid->create();
					$this->Testimonial->User->Bid->save($bid);

					// lets email the user to let them know the testimonial was approved
					$data						   = $testimonial;
	    			$data['to'] 				   = $testimonial['User']['email'];
					$data['subject'] 			   = sprintf(__('%s - Testimonial Approved', true), $this->appConfigurations['name']);
					$data['template'] 			   = 'auctions/testimonial';
					$this->_sendEmail($data);

					$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));
    				Configure::write('Config.language', $default['Language']['code']);

					$this->Session->setFlash(__('The testimonial has been updated successfully and the free bids have been given.', true), 'default', array('class' => 'success'));
				} else {
					$this->Session->setFlash(__('The testimonial has been updated successfully.', true), 'default', array('class' => 'success'));
				}

				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the testimonial please review the errors below and try again.', true));
			}
		} else {
			$this->data = $testimonial;
		}
	}

	function admin_saveorder() {
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';

		if(!empty($_POST['testimonial'])) {
			foreach($_POST['testimonial'] as $order => $id) {
				$testimonial['Testimonial']['id'] = $id;
				$testimonial['Testimonial']['order'] = $order;

				$this->Testimonial->save($testimonial, false);
			}
			$this->set('message', 'The order has been saved successfully.');
		} else {
			$this->set('message', 'Their was an error.');
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Testimonial.', true));
		}
		if ($this->Testimonial->delete($id)) {
			$this->Session->setFlash(__('The testimonial was deleted successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this testimonial.', true));
		}
		$this->redirect(array('action' => 'index'));
	}
}
?>