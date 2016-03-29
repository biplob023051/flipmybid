<?php
class Reward extends AppModel {

	var $name = 'Reward';

	var $actsAs = array('Containable');

	var $belongsTo = array('Product', 'Status', 'User');
}
?>