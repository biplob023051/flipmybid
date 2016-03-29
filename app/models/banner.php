<?php
	class Banner extends AppModel {

		var $name = 'Banner';

		var $belongsTo = 'BannerLocation';

		var $validate = array(
			'description' => array(
				'rule' => array('notEmpty'),
	        	'message' => 'Description is a required field.'
	        ),
	        'code' => array(
				'rule' => array('notEmpty'),
	        	'message' => 'Banner Code is a required field.'
	        )
		);
	}
?>