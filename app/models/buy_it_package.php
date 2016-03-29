<?php

	class BuyItPackage extends AppModel {
	
		var $name = 'BuyItPackage';
		
		var $belongsTo = array('User', 'Auction', 'Status');
		
		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);
		}
		
		function GetBidCount($user_id, $auction_id)
		{
			$bidCount = $this->Auction->Bid->find('all', array('contain' => '', 'conditions' => array('auction_id' => $auction_id, 'user_id' => $user_id), 'fields' => array('SUM(debit) as sumofbids'), 'group' => 'auction_id'));
			//$bidCount = $this->Auction->Bid->find('all', array('contain' => '', 'conditions' => array('));
			if(!empty($bidCount[0][0]['sumofbids'])){
				$toReturn = $bidCount[0][0]['sumofbids'];
			} else {
				$toReturn = null;
			}
			return $toReturn;
		}
		
		function GetStatus($status)
		{
			$status = $this->Status->find('first', array('contain' => '', 'conditions' => array('id' => $status_id), 'fields' => array('name')));
			return $status;
		}
	
	}
?>