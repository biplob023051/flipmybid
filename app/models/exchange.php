<?php
class Exchange extends AppModel {

	var $name = 'Exchange';

	var $actsAs = array('Containable');

	var $belongsTo = array('Auction', 'Status', 'User');
}
?>