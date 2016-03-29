<?php

function pr($variable = null){
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
}

function __($text) {
	// lets see what language we are dealing with!
	if(!empty($_COOKIE['CakeCookie']['language'])) {
		$language = $_COOKIE['CakeCookie']['language'];
	} else {
		global $config;
		$language = $config['App']['language'];
	}

	if($language == 'en') {
		$extension = 'eng';
	} elseif($language == 'es') {
		$extension = 'spa';
	} elseif($language == 'pt') {
		$extension = 'por';
	} else {
		$extension = $language;
	}

	if(substr($_SERVER['DOCUMENT_ROOT'], -12) == '/app/webroot') {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('/app/webroot', '', $_SERVER['DOCUMENT_ROOT']);
	}

	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/app/locale/'.$extension.'/daemons.php')) {
		// ok so we have some translations to do!
		include($_SERVER['DOCUMENT_ROOT'].'/app/locale/'.$extension.'/daemons.php');

		if(!empty($msgid)) {
			foreach ($msgid as $key => $string) {
				if($string == $text) {
					if(!empty($msgstr[$key])) {
						$text = $msgstr[$key];
					}
				}
			}
		}
	}

	return $text;
}
function get($name = null) {
	if($name == 'time_increment' || $name == 'bid_debit' || $name == 'price_increment') {
		// lets see if auction increments are enabled
		if(enabled('auction_increments')) {
			global $data;

			//$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$data['auction_id']." AND low_price = '0.00' AND high_price = '0.00'"), MYSQL_ASSOC);
			$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = '" . $data['auction_id'] . "' AND low_price = '0.00' AND high_price = '0.00'"), MYSQL_ASSOC);

			if(empty($increment)) {
				$sql = mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = '" . $data['auction_id'] . "'");
				$total_rows   = mysql_num_rows($sql);
				if($total_rows > 0) {
					// lets find the current price
					$auction = mysql_fetch_array(mysql_query("SELECT price FROM auctions WHERE id = ".$data['auction_id']), MYSQL_ASSOC);

					$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$data['auction_id']." AND low_price <= '".$auction['price']."' AND high_price > '".$auction['price']."'"), MYSQL_ASSOC);

					if(empty($increment)) {
						// lets check to see if the price is in the upper region
						$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$data['auction_id']." AND low_price <= '".$auction['price']."' AND high_price = '0.00'"), MYSQL_ASSOC);
					}

					if(empty($increment)) {
						// lets check to see if the price is in the lower region
						$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$data['auction_id']." AND low_price = '0.00' AND high_price > '".$auction['price']."'"), MYSQL_ASSOC);
					}

					if(empty($increment)) {
						// finally if it fits none of them for some strange reason
						$increment = mysql_fetch_array(mysql_query("SELECT bid, price, time FROM increments WHERE auction_id = ".$data['auction_id']." AND low_price = '0.00' AND high_price = '0.00'"), MYSQL_ASSOC);
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

	$setting = cacheRead('cake_setting_'.$name);

	if(!empty($setting)) {
		return $setting;
	} else {
		$setting = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = '$name'"), MYSQL_ASSOC);
		if(!empty($setting)) {
			cacheWrite('cake_setting_'.$name, $setting['value']);
			return $setting['value'];
		} else {
			return false;
		}
	}
}

function enabled($name = null) {
	$module = cacheRead('cake_module_'.$name);

	if(!empty($module)) {
		return $module;
	} else {
		$module = mysql_fetch_array(mysql_query("SELECT active FROM modules WHERE name = '$name'"), MYSQL_ASSOC);
		if(!empty($module)) {
			cacheWrite('cake_module_'.$name, $module['active']);
			return $module['active'];
		} else {
			return false;
		}
	}
}

function getStringTime($timestamp){
	$diff 	= strtotime($timestamp) - time();

	if($diff < 0) $diff = 0;

	$day    = floor($diff / 86400);
	if($day < 1){
		$day = '';
	}else{
		if($day > 1) {
			$day = $day.' Days';
		} else {
			$day = $day.' Day';
		}
	}

	$diff   -= $day * 86400;
	$hour   = floor($diff / 3600);
	if($hour < 10) $hour = '0'.$hour;
	$diff   -= $hour * 3600;

	$minute = floor($diff / 60);
	if($minute < 10) $minute = '0'.$minute;
	$diff   -= $minute * 60;

	$second = $diff;
	if($second < 10) $second = '0'.$second;

	return trim($day.' '.$hour.':'.$minute.':'.$second);
}

function savings($auction, $product) {
	if($product['rrp'] > 0) {
		if(!empty($product['fixed'])) {
			if($product['fixed_price'] > 0) {
				$data['percentage'] = 100 - ($product['fixed_price'] / $product['rrp'] * 100);
			} else {
				$data['percentage'] = 100;
			}
			$data['price']  = $product['rrp'] - $product['fixed_price'];
		} else {
			$data['percentage'] = 100 - ($auction['price'] / $product['rrp'] * 100);
			$data['price']      = $product['rrp'] - $auction['price'];
		}
	} else {
		$data['percentage'] = 0;
		$data['price'] = 0;
	}

	$data['percentage'] = number_format($data['percentage'], 2);
	$data['price'] 		= $data['price'];

	return $data;
}

function currency($number, $currency = 'USD', $options = array()) {
	$default = array(
		'before'=>'', 'after' => '', 'zero' => '0', 'places' => 2, 'thousands' => ',',
		'decimals' => '.','negative' => '-', 'escape' => true
	);

	$currencies = array(
		'USD' => array(
			'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'GBP' => array(
			'before'=>'&#163;', 'after' => 'p', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-','escape' => false
		),
		'EUR' => array(
			'before'=>'&#8364;', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => '.',
			'decimals' => '.', 'negative' => '-', 'escape' => false
		),
		'AUD' => array(
			'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'NZD' => array(
			'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'CAD' => array(
			'before' => '$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'ZAR' => array(
			'before' => 'R', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'INR' => array(
			'before' => 'Rs. ', 'after' => '', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'HKD' => array(
			'before' => '$', 'after' => '', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'AED' => array(
			'before' => 'AED', 'after' => '', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'SGD' => array(
			'before' => 'S$', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'MYR' => array(
			'before' => 'RM ', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'THB' => array(
			'before' => '฿', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'TRY' => array(
			'before' => 'TL', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'JPY' => array(
			'before' => '¥', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'IDR' => array(
			'before' => 'Rp', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'ILS' => array(
			'before' => '₪', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		),
		'PHP' => array(
			'before' => 'P', 'after' => 'c', 'zero' => 0, 'places' => 2, 'thousands' => ',',
			'decimals' => '.', 'negative' => '-', 'escape' => true
		)
	);

	if (isset($currencies[$currency])) {
		$default = $currencies[$currency];
	} elseif (is_string($currency)) {
		$options['before'] = $currency;
	}

	$options = array_merge($default, $options);

	$result = null;

	if ($number == 0 ) {
		if ($options['zero'] !== 0 ) {
			return $options['zero'];
		}
		$options['after'] = null;
	} elseif ($number < 1 && $number > -1 ) {
		$options['after'] = null;
	} else {
		$options['after'] = null;
	}

	$abs = abs($number);

	$result = _format($abs, $options);

	if ($number < 0 ) {
		if($options['negative'] == '()') {
			$result = '(' . $result .')';
		} else {
			$result = $options['negative'] . $result;
		}
	}
	return $result;
}

function niceShort($dateString = null, $userOffset = null) {
	$date = $dateString ? _fromString($dateString, $userOffset) : time();

	$y = _isThisYear($date) ? '' : ' Y';
	$timeFormat = "H:i:s";

	if (_isToday($date)) {
		$ret = "Today, " . date($timeFormat, $date);
	} elseif (_wasYesterday($date)) {
		$ret = "Yesterday, " . date($timeFormat, $date);
	} else {
		$ret = date("M jS{$y}, ".$timeFormat, $date);
	}

	return $ret;
}

function siteOnline() {
	$site_live = cacheRead('cake_site_live');

	if(!empty($site_live)) {
		return $site_live;
	} else {
		$site_live = mysql_fetch_array(mysql_query("SELECT value FROM settings WHERE name = 'site_live'"), MYSQL_ASSOC);
		cacheWrite('cake_site_live', $site_live['value']);
		return $site_live['value'];
	}
}

function cacheRead($file) {
	if(defined('STDIN') ) {
		$dir = cacheCommandClean();

		if(file_exists($dir.'/tmp/cache/'.$file)) {
			$data = file($dir.'/tmp/cache/'.$file);
			if(time() < $data[0]) {
				return unserialize($data[1]);
			} else {
				unlink($dir.'/tmp/cache/'.$file);
				return null;
			}
		} else {
			return null;
		}
	} elseif(file_exists('../tmp/cache/'.$file)) {
		$data = file('../tmp/cache/'.$file);
		if(time() < $data[0]) {
			return unserialize($data[1]);
		} else {
			unlink('../tmp/cache/'.$file);
			return null;
		}
	} else {
		return null;
	}
}

function cacheDelete($file) {
	if(defined('STDIN') ) {
		$dir = cacheCommandClean();

		if(file_exists($dir.'/tmp/cache/'.$file)) {
			unlink($dir.'/tmp/cache/'.$file);
			return true;
		} else {
			return false;
		}
	} elseif(file_exists('../tmp/cache/'.$file)) {
		unlink('../tmp/cache/'.$file);
		return true;
	} else {
		// lets find the cache file another way!
		if(substr($_SERVER['DOCUMENT_ROOT'], -12) == '/app/webroot') {
			$_SERVER['DOCUMENT_ROOT'] = str_replace('/app/webroot', '', $_SERVER['DOCUMENT_ROOT']);
		}
		$dir = $_SERVER['DOCUMENT_ROOT'].'/app';
		if(file_exists($dir.'/tmp/cache/'.$file)) {
			unlink($dir.'/tmp/cache/'.$file);
			return true;
		} else {
			return false;
		}
	}
}

function cacheWrite($file, $data, $duration = '86400') {
	$lineBreak = "\n"; // this function will NOT work on a windows server without further modification

	$data = serialize($data);

	$expires = time() + $duration;
	$contents = $expires . $lineBreak . $data . $lineBreak;

	if(defined('STDIN') ) {
		$dir = cacheCommandClean();
		$write = $dir.'/tmp/cache/'.$file;
	} else {
		$write = '../tmp/cache/'.$file;
	}

	$result = fopen($write, 'w');

	if (is_writable($write)) {
		if (!$handle = fopen($write, 'a')) {
			return false;
		}
		if (fwrite($result, $contents) === false) {
			return false;
		}
		fclose($result);
		return true;
	} else {
	     return false;
	}
}

function _isThisYear($dateString, $userOffset = null) {
	$date = _fromString($dateString, $userOffset);
	return  date('Y', $date) == date('Y', time());
}

function _isToday($dateString, $userOffset = null) {
	$date = _fromString($dateString, $userOffset);
	return date('Y-m-d', $date) == date('Y-m-d', time());
}

function _wasYesterday($dateString, $userOffset = null) {
	$date = _fromString($dateString, $userOffset);
	return date('Y-m-d', $date) == date('Y-m-d', strtotime('yesterday'));
}

function _fromString($dateString, $userOffset = null) {
	if (is_integer($dateString) || is_numeric($dateString)) {
		$date = intval($dateString);
	} else {
		$date = strtotime($dateString);
	}

	return $date;
}

function _format($number, $options = false) {
	$places = 0;
	if (is_int($options)) {
		$places = $options;
	}

	$separators = array(',', '.', '-', ':');

	$before = $after = null;
	if (is_string($options) && !in_array($options, $separators)) {
		$before = $options;
	}
	$thousands = ',';
	if (!is_array($options) && in_array($options, $separators)) {
		$thousands = $options;
	}
	$decimals = '.';
	if (!is_array($options) && in_array($options, $separators)) {
		$decimals = $options;
	}

	$escape = true;
	if (is_array($options)) {
		$options = array_merge(array('before'=>'$', 'places' => 2, 'thousands' => ',', 'decimals' => '.'), $options);
		extract($options);
	}

	$out = $before . number_format($number, $places, $decimals, $thousands) . $after;
	if ($escape) {
		return _h($out);
	}
	return $out;
}

function _h($text, $charset = null) {
	global $config;

	if (is_array($text)) {
		return array_map('h', $text);
	}
	if (empty($charset)) {
		$charset = $config['App']['encoding'];
	}
	if (empty($charset)) {
		$charset = 'UTF-8';
	}
	return htmlspecialchars($text, ENT_QUOTES, $charset);
}

function cacheCommandClean() {
	$dir = $_SERVER['SCRIPT_FILENAME'];

	$dir = str_replace('/daemons/bidbutler.php', '', $dir);
	$dir = str_replace('/daemons/close.php', '', $dir);
	$dir = str_replace('/daemons/extend.php', '', $dir);
	$dir = str_replace('/daemons/daily.php', '', $dir);

	return $dir;
}
?>
