<?php
class ProductsController extends AppController {

	var $name = 'Products';

	var $helpers = array('Fck');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index');
		}
	}

	function index() {
		$order = $this->requestAction('/settings/get/products_order');

		$this->paginate = array('contain' => 'Image', 'conditions' => array('Product.exchange >' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Product.'.$order => 'asc'));
		$this->set('products', $this->paginate());

		$this->set('title_for_layout', __('Products for Sale', true));
	}

	function url($id = null) {
		// lets find the most recent live auction
		$auction = $this->Product->Auction->find('first', array('conditions' => array('Auction.product_id' => $id, 'Auction.closed' => false), 'contain' => 'Product', 'order' => array('Auction.end_time' => 'asc')));

		if(empty($auction)) {
			$auction = $this->Product->Auction->find('first', array('conditions' => array('Auction.product_id' => $id, 'Auction.closed' => true), 'contain' => 'Product', 'order' => array('Auction.end_time' => 'desc')));
		}

		if(!empty($auction)) {
			$this->redirect('/auction/'.$auction['Auction']['id']);
		} else {
			$this->redirect('/auctions');
		}
	}

	function admin_index($rewardsOnly = false) {
		if($rewardsOnly == true) {
			$this->paginate = array('conditions' => array('Product.reward' => true), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Product.title' => 'asc'), 'contain' => array('Category', 'Auction' => array('limit' => 1)));
		} else {
			$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Product.title' => 'asc'), 'contain' => array('Category', 'Auction' => array('limit' => 1)));
		}

		$this->set('products', $this->paginate('Product'));

		$this->set('rewardsOnly', $rewardsOnly);
	}

	function admin_auctions($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('action'=>'index'));
		}
		$product = $this->Product->recursive = -1;
		$product = $this->Product->read(null, $id);
		if(empty($product)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('product', $product);

		$this->paginate = array('conditions' => array('Auction.product_id' => $id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Auction.end_time' => 'desc'), 'contain' => array('Product' => array('Category'), 'Status', 'Winner', 'Bid'));
		$this->set('auctions', $this->paginate('Auction'));

		$this->Session->write('auctionsPage', $this->params['url']['url']);
	}

	function admin_add($id = null) {
		if (!empty($this->data)) {
			if(empty($this->data['Product']['rrp'])) {
				$this->data['Product']['rrp'] = 0;
			}
			if(empty($this->data['Product']['fixed_price'])) {
				$this->data['Product']['fixed_price'] = 0;
			}
			if(empty($this->data['Product']['delivery_cost'])) {
				$this->data['Product']['delivery_cost'] = 0;
			}
			if(empty($this->data['Product']['bids'])) {
				$this->data['Product']['bids'] = 0;
			}
			if(empty($this->data['Product']['exchange'])) {
				$this->data['Product']['exchange'] = 0;
			}
			if(empty($this->data['Product']['status_id'])) {
				$this->data['Product']['status_id'] = 0;
			}
			if(empty($this->data['Product']['reward_points'])) {
				$this->data['Product']['reward_points'] = 0;
			}
			if(empty($this->data['Product']['win_points'])) {
				$this->data['Product']['win_points'] = 0;
			}

			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The product has been added successfully.  <a href="/admin/images/index/%d">Click here to add more images to the product</a>.', true), $this->Product->getInsertID()), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the product please review the errors below and try again.', true));
			}
		}
		$this->set('categories', $this->Product->Category->generatetreelist(null, null, null, '-'));
		$this->set('statuses', $this->Product->Status->find('list'));
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Product->locale = $language;
		}

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if(empty($this->data['Product']['rrp'])) {
				$this->data['Product']['rrp'] = 0;
			}
			if(empty($this->data['Product']['fixed_price'])) {
				$this->data['Product']['fixed_price'] = 0;
			}
			if(empty($this->data['Product']['minimum_price'])) {
				$this->data['Product']['minimum_price'] = 0;
			}
			if(empty($this->data['Product']['exchange'])) {
				$this->data['Product']['exchange'] = 0;
			}
			if(empty($this->data['Product']['status_id'])) {
				$this->data['Product']['status_id'] = 0;
			}
			if(empty($this->data['Product']['reward_points'])) {
				$this->data['Product']['reward_points'] = 0;
			}
			if(empty($this->data['Product']['win_points'])) {
				$this->data['Product']['win_points'] = 0;
			}

			$this->data['Product']['id'] = $id;

			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The product has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem updating the product please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Product->recursive = -1;
			$this->data = $this->Product->read(null, $id);
		}

		$this->set('categories', $this->Product->Category->generatetreelist(null, null, null, '-'));
		$this->set('statuses', $this->Product->Status->find('list'));

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$product = $this->Product->find('first', array('conditions' => array('Product.id' => $id), 'contain' => ''));
		if(empty($product)) {
			$this->Session->setFlash(__('Invalid id for Product', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('product', $product);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product.', true));

		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('The product was deleted successfully.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this product.', true));
		}
		$this->redirect(array('action' => 'index'));
	}
}
?>