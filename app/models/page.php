<?php
	class Page extends AppModel {

		var $name = 'Page';

		var $actsAs = array('Translate' => array('name', 'title', 'meta_description', 'meta_keywords', 'content'));

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'rule' => array('notEmpty'),
					'message' => __('Name is required', true)
				),
				'title' => array(
					'rule' => array('notEmpty'),
					'message' => __('Title is required', true)
				),
				'content' => array(
					'rule' => array('notEmpty'),
					'message' => __('Content is required', true)
				),
				'email' => array(
					'email' => array(
						'rule' => 'email',
						'message' => __('The email address you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Email address is required.', true)
					)
				),
				'department_id' => array(
					'rule' => array('notEmpty'),
					'message' => __('Department is required', true)
				),
				'message' => array(
					'rule' => array('notEmpty'),
					'message' => __('Enquiry is required', true)
				),
				'slug' => array(
					'rule' => array('notEmpty'),
					'message' => __('Page URL is required.', true)
				)
			);
		}

		/**
		 * Override parent before save for slug generation
		 *
		 * @return boolean Always true
		 */
		function beforeSave(){
			if(!empty($this->data)) {
				// Generating slug from page name
				if(!empty($this->data['Page']['name'])) {
					if(empty($this->data['Page']['id'])) {
						$this->data['Page']['slug'] = $this->generateNiceName($this->data['Page']['name']);
					}
				}

				// the page ordering
				if(!empty($this->data['Page']['id'])) {
					if(empty($this->data['Page']['top_show'])) {
						$this->data['Page']['top_order'] = 0;
					}
					if(empty($this->data['Page']['bottom_show'])) {
						$this->data['Page']['bottom_order'] = 0;
					}
				} else {
					if(!empty($this->data['Page']['top_show'])) {
						$this->data['Page']['top_order']  = $this->getLastOrderNumber('top');
					}
					if(!empty($this->data['Page']['bottom_show'])) {
						$this->data['Page']['bottom_order']  = $this->getLastOrderNumber('bottom');
					}
				}
			}
			return true;
		}

		/**
		 * Function to get last order number
		 *
		 * @return int Return last order number
		 */
		function getLastOrderNumber($position = null) {
			$this->recursive = -1;
			$lastItem = $this->find('first', array('conditions' => array($position.'_show' => 1), 'order' => array($position.'_order' => 'desc')));
			if(!empty($lastItem)) {
				return $lastItem['Page'][$position.'_order'] + 1;
			} else {
				return 0;
			}
		}
	}
?>
