<?php
	class UserAddressType extends AppModel {

		var $name = 'UserAddressType';

		var $actsAs = array(
			'Containable',
			'Translate' => array('name')
		);

		var $hasMany = array(
			'Address' => array(
				'className' => 'Address',
				'foreignKey' => 'user_address_type_id',
				'dependent' => false
			)
		);

	}
?>
