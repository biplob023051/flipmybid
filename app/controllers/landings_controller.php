<?php
class LandingsController extends AppController {

	var $name = 'Landings';

	var $helpers = array('Fck');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('view', 'view2');
		}

		if(!$this->Setting->Module->enabled('landing_pages')) {
			$this->cakeError('error404'); die;
		}
	}

	function view() {
		$this->layout = false;

		$endingLimit = $this->Setting->get('home_ending_limit');

		$endSoon  = $this->Landing->Product->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), $endingLimit, array('Auction.featured' => 'desc', 'Auction.end_time' => 'asc'));
		$this->set('auctions_end_soon', $endSoon);

		$landing = $this->Landing->find('first', array('conditions' => array('Landing.slug' => $this->params['pass'][0]), 'recursive' => -1));

		if(empty($landing)) {
			$this->cakeError('error404'); die;
		}

		$this->set('landing', $landing);

		if(!empty($landing['Landing']['product_id'])) {
			$product = $this->Landing->Product->find('first', array('conditions' => array('Product.id' => $landing['Landing']['product_id']), 'contain' => 'Image'));
		}

		if(empty($product)) {
			$product = $this->Landing->Product->find('first', array('contain' => 'Image', 'order' => 'RAND()'));
		}

		$this->set('product', $product);

		$this->set('title_for_layout', $landing['Landing']['meta_title']);

		if(!empty($landing['Landing']['meta_description'])) {
			$this->set('meta_description', $landing['Landing']['meta_description']);
		}
		if(!empty($landing['Landing']['meta_keywords'])) {
			$this->set('meta_keywords', $landing['Landing']['meta_keywords']);
		}

		//$this->set('genders', $this->User->Gender->find('list'));
        //$this->set('sources', $this->User->Source->find('all', array('order' => 'Source.order ASC', 'recursive' => -1)));
	}

	function view2() {
		$autoplay = 0;

		if(!empty($_GET['autoplay'])) {
			$autoplay = true;
		}

		$this->layout = false;

		$endingLimit = $this->Setting->get('home_ending_limit');

		$endSoon  = $this->Landing->Product->Auction->getAuctions(array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1), $endingLimit, array('Auction.featured' => 'desc', 'Auction.end_time' => 'asc'));
		$this->set('auctions_end_soon', $endSoon);

		$landing = $this->Landing->find('first', array('conditions' => array('Landing.slug' => $this->params['pass'][0]), 'recursive' => -1));

		if(empty($landing)) {
			$this->cakeError('error404'); die;
		}

		$this->set('landing', $landing);

		if(!empty($landing['Landing']['product_id'])) {
			$product = $this->Landing->Product->find('first', array('conditions' => array('Product.id' => $landing['Landing']['product_id']), 'contain' => 'Image'));
		}

		if(empty($product)) {
			$product = $this->Landing->Product->find('first', array('contain' => 'Image', 'order' => 'RAND()'));
		}

		$this->set('product', $product);

		$this->set('title_for_layout', $landing['Landing']['meta_title']);

		if(!empty($landing['Landing']['meta_description'])) {
			$this->set('meta_description', $landing['Landing']['meta_description']);
		}
		if(!empty($landing['Landing']['meta_keywords'])) {
			$this->set('meta_keywords', $landing['Landing']['meta_keywords']);
		}

		//$this->set('genders', $this->User->Gender->find('list'));
        //$this->set('sources', $this->User->Source->find('all', array('order' => 'Source.order ASC', 'recursive' => -1)));

        $this->set('autoplay', $autoplay);
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Landing.title' => 'asc'), 'contain' => 'Product');
		$this->set('landings', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Landing->create();
			if ($this->Landing->save($this->data)) {
				$this->Session->setFlash(__('The landing page has been added successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the landing page please review the errors below and try again.', true));
			}
		}

		$this->set('products', $this->Landing->Product->find('list', array('order' => array('Product.title' => 'asc'))));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Landing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Landing->save($this->data)) {
				$this->Session->setFlash(__('The landing page has been updated successfully.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem editing the landing page please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Landing->recursive = -1;
			$this->data = $this->Landing->read(null, $id);
		}

		$this->set('products', $this->Landing->Product->find('list', array('order' => array('Product.title' => 'asc'))));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Landing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Landing->del($id)) {
			$this->Session->setFlash(__('The landing was successfully deleted.', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>