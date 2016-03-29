<?php
	class Country extends AppModel {

		var $name = 'Country';

		var $actsAs = array(
		'Containable',
		'Translate' => array('name')
		);

		var $hasMany = array(
			'Address' => array(
				'className'  => 'Address',
				'foreignKey' => 'country_id',
				'dependent'  => false
			)
		);

		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'name' => array(
					'rule' => array('notEmpty'),
					'message' => __('Country name is a required field.', true)
				),
				'code' => array(
					'rule' => array('notEmpty'),
					'message' => __('Code is a required field.', true)
				)
			);
		}
	}
?>
