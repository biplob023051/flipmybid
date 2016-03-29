<?php
class Setting extends AppModel {

	var $name = 'Setting';

	var $belongsTo = array(
						'Module',
						'Parent' => array(
							'className'  => 'Setting',
							'foreignKey' => 'setting_id'
						)
					  );

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'value' => array(
				'rule' => 'check_empty',
				'message' => __('This field is required.', true)
			)
		);
	}

	function check_empty() {
		if(empty($this->data['Setting']['allow_empty']) && strlen($this->data['Setting']['value']) == 0) {
			return false;
		}

		return true;
	}

	function get($name, $auction_id = null) {
		if($name == 'time_increment' || $name == 'bid_debit' || $name == 'price_increment') {
			// lets see if auction increments are enabled
			// this code is a bit lazy
			if($this->SettingsController->enabled('auction_increments') && !empty($auction_id)) {
				$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id." AND low_price = '0.00' AND high_price = '0.00'"), MYSQL_ASSOC);

				if(empty($increment)) {
					$sql = mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id);
					$total_rows   = mysql_num_rows($sql);
					if($total_rows > 0) {
						// lets find the current price
						$auction = mysql_fetch_array(mysql_query("SELECT price FROM auctions WHERE id = ".$auction_id), MYSQL_ASSOC);

						$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id." AND low_price <= '".$auction['price']."' AND high_price > '".$auction['price']."'"), MYSQL_ASSOC);

						if(empty($increment)) {
							// lets check to see if the price is in the upper region
							$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id." AND low_price <= '".$auction['price']."' AND high_price = '0.00'"), MYSQL_ASSOC);
						}

						if(empty($increment)) {
							// lets check to see if the price is in the lower region
							$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id." AND low_price = '0.00' AND high_price > '".$auction['price']."'"), MYSQL_ASSOC);
						}

						if(empty($increment)) {
							// finally if it fits none of them for some strange reason
							$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$auction_id." AND low_price = '0.00' AND high_price = '0.00'"), MYSQL_ASSOC);
						}
					}
				}

				if(!empty($increment)) {
					if($name == 'time_increment') {
						return $increment['time'];
					} elseif($name == 'bid_debit') {
						return $increment['bid'];
					} elseif($name == 'price_increment') {
						return $increment['price'];
					}
				}
			}
		}

		if(!empty($name)) {
			$setting = Cache::read('setting_'.$name);
			if(!empty($setting)) {
				return $setting;
			} else {
				$setting = $this->find('first', array('conditions' => array('Setting.name' => $name), 'fields' => array('Setting.value'), 'recursive' => -1));
				if(!empty($setting)) {
					Cache::write('setting_'.$name, $setting['Setting']['value']);
					return $setting['Setting']['value'];
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	function beforeSave(){
		if(!empty($this->data)){
			if(!empty($this->data['Setting']['name']) && isset($this->data['Setting']['value'])) {
				Cache::delete('setting_'.$this->data['Setting']['name']);
				Cache::write('setting_'.$this->data['Setting']['name'], $this->data['Setting']['value']);

				if($this->data['Setting']['name'] == 'license_code') {
					Cache::delete('license');
				}
			}
		}

		return true;
	}
}
?>