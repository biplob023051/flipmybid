<?php
class CategoriesController extends AppController {

	var $name = 'Categories';

	var $uses = array('Category', 'Auction');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('index', 'view', 'getlist');
		}
	}

	function index() {
 		$this->Category->recursive = 0;
 		$this->paginate = array('conditions' => array('Category.parent_id' => 0), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Category.name' => 'asc'));
		$categories = $this->paginate();

		foreach($categories as $key => $category) {
			if(empty($category['Category']['image'])) {
				$image = $this->Category->Product->Image->find('first', array('conditions' => array('Product.category_id' => $category['Category']['id'], 'Image.image !=' => ''), 'order' => 'rand()', 'recursive' => 0, 'fields' => 'Image.image'));
				$categories[$key]['Category']['random_image'] = $image['Image']['image'];
			}
		}
		$this->set('categories', $categories);

		$this->set('title_for_layout', __('Categories', true));
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Category.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Category->contain();
		$category = $this->Category->read(null, $id);
		if (empty($category)) {
			$this->Session->setFlash(__('Invalid Category.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $category);
		$this->set('parents', $this->Category->getpath($id));
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => $category['Category']['id']), 'order' => array('Category.name' => 'asc'))));

		$this->paginate = array('contain' => 'Product', 'conditions' => array("Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'", 'Product.category_id' => $id, 'Auction.active' => 1), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Auction.end_time' => 'asc'));
		$auctions = $this->paginate('Auction');

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auction = $this->Category->Product->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
				$auctions[$key]['Auction'] = $auction['Auction'];
				$auctions[$key]['Product'] = $auction['Product'];
			}
		}

		$this->set('auctions', $auctions);

		$this->set('title_for_layout', $category['Category']['name']);
		if(!empty($category['Category']['meta_description'])) {
			$this->set('meta_description', $category['Category']['meta_description']);
		}
		if(!empty($category['Category']['meta_keywords'])) {
			$this->set('meta_keywords', $category['Category']['meta_keywords']);
		}
	}

	function getlist($parent = null, $find = 'list', $count = null){
		if($parent == 'parent') {
			if($find !== 'all') {
				$this->Category->recursive = -1;
			}
			$categories = $this->Category->find($find, array('contain' => '', 'conditions' => array('Category.parent_id' => 0), 'order' => array('Category.name' => 'asc')));

		} else {
			$categories = $this->Category->generateTreeList(null, null, null, '-');
		}

		if($count == 'count') {
			foreach($categories as $key => $category) {
				$category_id = $category['Category']['id'];
				$categories[$key]['Category']['count'] = $this->Category->Product->Auction->find('count', array('conditions' => "Product.category_id = $category_id AND Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'"));
				$children = $this->Category->children($category_id, false);
				if(!empty($children)) {
					foreach ($children as $child) {
						$category_id = $child['Category']['id'];
						$categories[$key]['Category']['count'] += $this->Category->Product->Auction->find('count', array('conditions' => "Product.category_id = $category_id AND Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'"));
					}
				}
			}
		}

		return $categories;
	}

	function admin_index($id = 0) {
 		if($id > 0) {
 			$this->set('parents', $this->Category->getpath($id));
 		}
 		$this->paginate = array('conditions' => array('Category.parent_id' => $id), 'order' => array('Category.name' => 'asc'), 'contain' => array('ChildCategory'));
		$this->set('categories', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			if(empty($this->data['Category']['parent_id'])) {
				$this->data['Category']['parent_id'] = 0;
			}
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The Category has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the category please review the errors below and try again.', true));
			}
		}
		$parentCategories = $this->Category->ParentCategory->generateTreeList(null, null, null, '--');
		$this->set(compact('parentCategories'));
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Category->locale = $language;
		}

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Category', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if(!empty($this->data['Category']['image_delete'])) {
				$this->data['Category']['image']['delete'] = 1;
			}
			if(empty($this->data['Category']['parent_id'])) {
				$this->data['Category']['parent_id'] = 0;
			}

			$this->data['Category']['id'] = $id;

			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category was updated successfully.', true), 'default', array('class' => 'success'));

				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Category->recursive = -1;
				$category = $this->Category->read(null, $id);
				$this->data['Category']['image'] = $category['Category']['image'];
				$this->Session->setFlash(__('There was a problem updating the category please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Category->recursive = -1;
			$this->data = $this->Category->read(null, $id);
		}
		$parentCategories = $this->Category->ParentCategory->generateTreeList(null, null, null, '--');
		$this->set(compact('parentCategories'));

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Category', true));
			$this->redirect(array('action'=>'index'));
		}
		$category = $this->Category->find('first', array('conditions' => array('Category.id' => $id), 'contain' => ''));
		if (empty($category)) {
			$this->Session->setFlash(__('Invalid id for Category', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('category', $category);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('The category was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>