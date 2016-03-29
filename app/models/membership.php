<?php
	class Membership extends AppModel {

		var $name = 'Membership';

		var $actsAs = array(
			'Containable',
			'Translate' => array('name', 'description'),
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
							'directory' => 'img/product_images/max/',
							'phpThumb' => array(
								'far' => 1,
								'bg'  => 'FFFFFF'
							)
						)
					)
				)
			)
		);

		var $hasMany = array('Auction', 'User');

		var $validate = array(
			'name' => array(
				'rule' => array('notEmpty'),
	        	'message' => 'Name is a required field.'
	        ),
	        'rank' => array(
				'numeric' => array(
					'rule'=> 'numeric',
					'message' => 'Rank can be a number only.',
				),
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => 'Rank is required.',
				)
			),
			'points' => array(
				'numeric' => array(
					'rule'=> 'numeric',
					'message' => 'Reward points can be a number only.',
				),
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => 'Reward points is required.',
				)
			)
		);
	}
?>
