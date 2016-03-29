<?php
class Autobid extends AppModel {

	var $name = 'Autobid';

	var $actsAs = array('Containable');

	var $belongsTo = 'Auction';
}
?>