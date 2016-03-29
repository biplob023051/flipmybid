<?php
	class Image extends AppModel {

		var $name = 'Image';

		var $belongsTo = array(
			'Product' => array(
				'className'  => 'Product',
				'foreignKey' => 'product_id'
			)
		);

		var $actsAs = array(
			'ImageUpload' => array(
				'image' => array(
					'required' 			  => true,
					'directory'           => 'img/product_images/',
					'allowed_mime'        => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
					'allowed_extension'   => array('.jpg', '.jpeg', '.png', '.gif'),
					'allowed_size'        => 2097152,
					'random_filename'     => true,
					'resize' => array(
						'thumb' => array(
							'directory' => 'img/product_images/thumbs/',
							'phpThumb' => array(
								'far' => 1,
								'bg'  => 'FFFFFF'
							)
						),

						'max' => array(
							'directory'   => 'img/product_images/max/',
							'phpThumb' => array(
								'zc' => 0
							)
						)
					)
				)
			)
		);

		/**
		 * Function to get last order number
		 *
		 * @return int Return last order number
		 */
		function getLastOrderNumber($product_id = null) {
			$this->recursive = -1;
			$lastItem = $this->find('first', array('conditions' => array('product_id' => $product_id), 'order' => array('order' => 'desc')));
			if(!empty($lastItem)) {
				return $lastItem['Image']['order'] + 1;
			} else {
				return 0;
			}
		}
	}
?>
