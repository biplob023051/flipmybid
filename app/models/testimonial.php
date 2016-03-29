<?php
class Testimonial extends AppModel {

	var $name = 'Testimonial';

	var $actsAs = array(
		'Containable',
		'ImageUpload' => array(
			'image' => array(
				'required' 			  => false,
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

	var $belongsTo = array('Auction', 'User');

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'auction_id' => array(
				'rule' => array('notEmpty'),
				'message' => __('Auction is required.', true)
			),
			'name' => array(
				'rule' => array('notEmpty'),
				'message' => __('Name is a required field.', true)
			),
			'location' => array(
				'rule' => array('notEmpty'),
				'message' => __('Location is a required field.', true)
			),
			'testimonial' => array(
				'rule' => array('notEmpty'),
				'message' => __('Testimonial is a required field.', true)
			)
		);
	}

	function autobidWinners() {
		$data = array();

		$auctions = $this->Auction->find('all', array('conditions' => array('Auction.price > ' => 0, 'Auction.closed' => 1, 'Winner.autobidder' => 1), 'contain' => array('Winner', 'Product', 'Testimonial'), 'limit' => 60, 'order' => array('Auction.end_time' => 'desc')));

		if(!empty($auctions)) {
			foreach ($auctions as $auction) {
				if(empty($auction['Testimonial']['id'])) {
					$data[$auction['Auction']['id']] = $auction['Product']['title'].', Sold for: '.$auction['Auction']['price'].', won by '.$auction['Winner']['username'];
				}
			}
		}

		return $data;
	}
}
?>