<?php
	class Gender extends AppModel {

		var $name = 'Gender';

		var $actsAs = array(
			'Containable',
			'Translate' => array('name')
		);

		var $hasMany = array(
			'User' => array(
				'className'  => 'User',
				'foreignKey' => 'gender_id',
				'dependent'  => false
			)
		);

	}
?>
