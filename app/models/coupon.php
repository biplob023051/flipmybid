<?php
class Coupon extends AppModel{
    var $name = 'Coupon';
    var $belongsTo = array('CouponType');

    function beforeSave(){
        if(!empty($this->data['Coupon']['code'])){
            $this->data['Coupon']['code'] = strtoupper($this->data['Coupon']['code']);
        }

        return true;
    }

    /**
	 * This function generates coupon code
	 *
	 * @param int $length How long the new code will be
	 * @param string $random_string The string to be used when generate the password
	 * @return string New generated code
	*/
	function generateCode($length = 5, $randomString = null) {
		if(empty($randomString)){
	        $randomString = 'abcdefghijklmnopqrstuvwxyz';
	    }
	    $newPassword = '';
	    for($i=0;$i<$length;$i++){
            $newPassword .= substr($randomString, mt_rand(0, strlen($randomString)-1), 1);
	    }

	    return strtoupper($newPassword);
	}
}
?>