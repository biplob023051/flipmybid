<?php
class Credit extends AppModel {

	var $name = 'Credit';

	var $actsAs = array('Containable');

	var $belongsTo = array('Auction', 'User');

	/**
	 * Function to get bid balance
	 *
	 * @param int $user_id User id
	 * @return int Balance of user's bid
	 */
	function balance($user_id, $expiry) {
		$expiry_date = date('Y-m-d H:i:s', time() - ($expiry * 24 * 60 * 60));

		$credit = $this->find('all', array('conditions' => array('Credit.user_id' => $user_id, 'Credit.created >=' => $expiry_date), 'fields' => "SUM(Credit.credit) as 'credit'"));
		if(empty($credit[0][0]['credit'])) {
			$credit[0][0]['credit'] = 0;
		}

		$debit  = $this->find('all', array('conditions' => array('Credit.user_id' => $user_id), 'fields' => "SUM(Credit.debit) as 'debit'"));
		if(empty($debit[0][0]['debit'])) {
			$debit[0][0]['debit'] = 0;
		}


		return $credit[0][0]['credit'] - $debit[0][0]['debit'];
	}
}
?>
