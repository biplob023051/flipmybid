<?php
class Point extends AppModel{
    var $name = 'Point';

	var $actsAs = array('Containable');

    var $belongsTo = 'User';

    function balance($user_id = null, $creditOnly = false) {
		$credit = $this->find('all', array('conditions' => array('Point.user_id' => $user_id), 'fields' => "SUM(Point.credit) as 'credit'"));
		if(empty($credit[0][0]['credit'])) {
			$credit[0][0]['credit'] = 0;
		}

		if($creditOnly == true) {
			$debit[0][0]['debit'] = 0;
		} else {
			$debit  = $this->find('all', array('conditions' => array('Point.user_id' => $user_id), 'fields' => "SUM(Point.debit) as 'debit'"));
			if(empty($debit[0][0]['debit'])) {
				$debit[0][0]['debit'] = 0;
			}
		}

		$balance = $credit[0][0]['credit'] - $debit[0][0]['debit'];

		return $balance;
	}
}
?>
