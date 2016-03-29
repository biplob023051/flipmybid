<?php
	class Category extends AppModel {

		var $name = 'Category';

		var $actsAs = array(
			'Containable',
			'Tree',
			'Translate' => array('name', 'meta_description', 'meta_keywords'),
			'ImageUpload' => array(
				'image' => array(
					'required' 			  => false,
					'directory'           => 'img/category_images/',
					'allowed_mime'        => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
					'allowed_extension'   => array('.jpg', '.jpeg', '.png', '.gif'),
					'allowed_size'        => 2097152,
					'random_filename'     => true,
					'resize' => array(
						'thumb' => array(
							'directory' => 'img/category_images/thumbs/',
							'phpThumb' => array(
								'far' => 1,
								'bg'  => 'FFFFFF'
							)
						),

						'max' => array(
							'directory' => 'img/category_images/max/',
							'phpThumb' => array(
								'far' => 1,
								'bg'  => 'FFFFFF'
							)
						)
					)
				)
			)
		);

		var $belongsTo = array(
			'ParentCategory' => array(
				'className'  => 'Category',
				'foreignKey' => 'parent_id'
			)
		);

		var $hasMany = array(
			'Product' => array(
				'className'  => 'Product',
				'foreignKey' => 'category_id',
				'dependent'  => false
			),
			'ChildCategory' => array(
				'className'  => 'Category',
				'foreignKey' => 'parent_id',
				'dependent'  => false
			)
		);

		var $validate = array(
			'name' => array(
				'rule' => array('notEmpty'),
	        	'message' => 'Name is a required field.'
	        ),
	        'parent_id' => array(
				'rule' => 'parentCheck',
				'message' => 'The Parent Category cannot be the current category.'
	        ),
		);

		// this makes sure the parent category isn't the current ID
		function parentCheck() {
			if(!empty($this->data['Category']['id']) && (!empty($this->data['Category']['parent_id']))) {
				if($this->data['Category']['id'] == $this->data['Category']['parent_id']) {
					return false;
				}
			}
			return true;
		}

		function getlist($parent = null, $find = 'list', $count = null){
			if($parent == 'parent') {
				if($find !== 'all') {
					$this->recursive = -1;
				}
				$this->contain();
				$categories = $this->find($find, array('conditions' => array('Category.parent_id' => 0), 'order' => array('Category.name' => 'asc')));

			} else {
				$categories = $this->generateTreeList(null, null, null, '-');
			}
			if($count == 'count') {
				foreach($categories as $key => $category) {
					$category_id = $category['Category']['id'];
					$categories[$key]['Category']['count'] = $this->Product->Auction->find('count', array('conditions' => "Product.category_id = $category_id AND Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'"));
					$children = $this->children($category_id, false);
					if(!empty($children)) {
						foreach ($children as $child) {
							$category_id = $child['Category']['id'];
							$categories[$key]['Category']['count'] += $this->Product->Auction->find('count', array('conditions' => "Product.category_id = $category_id AND Auction.start_time < '" . date('Y-m-d H:i:s') . "' AND Auction.end_time > '" . date('Y-m-d H:i:s') . "'"));
						}
					}
				}
			}

			return $categories;
		}

	}
?>
