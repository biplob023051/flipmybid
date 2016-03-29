<?php
$start = microtime();

// Include the config file
require_once '../config/config.php';

// Including database
require_once '../database.php';

// Include the functions
require_once '../getstatus_functions.php';

// Include JSON libs
require_once '../../vendors/fastjson/fastjson.php';

// lets override the default currency if needed
if(!empty($_COOKIE['CakeCookie']['currency'])) {
	$currency = $_COOKIE['CakeCookie']['currency'];
}

// Setup the timezone
$timezone = get('time_zone');
if(!empty($timezone)){
	//putenv("TZ=".$timezone);
	date_default_timezone_set($timezone);
}

if(!empty($_GET['histories'])) {
	$bidHistoryLimit = get('bid_history_limit');
	$timePrice = get('time_price');
	$priceIncrement = get('price_increment');
}

// it is always peak
$isPeakNow = 1;

// Lets check that the site is online
$siteOnline = siteOnline();

// Get the POST data
$data 	   = $_POST;
if(empty($data)){
	//$data = array('auction_id' => 1);
	die('No data given');
}

// Result array
$results = array();

// Getting rate from cache
$rate = cacheRead('cake_currency_'.strtolower($currency).'_rate');

if(empty($rate)) {
	$currencyRate = mysql_fetch_array(mysql_query("SELECT rate FROM currencies WHERE currency = '".$currency."'"), MYSQL_ASSOC);
	if(!empty($currencyRate['rate'])){
		$rate = $currencyRate['rate'];
	}else{
		$rate = 1;
	}

	// Writing cache for currency
	cacheWrite('cake_currency_'.strtolower($currency).'_rate', $rate);
}

// Loop through the posted data
foreach($data as $key => $value){
	// Get the auction data
	if(!empty($_GET['histories'])) {
		$result = cacheRead('cake_auction_view_'.$value);
	} else {
		$result = cacheRead('cake_auction_'.$value);
	}

	if(empty($result)) {
		// Get the auction data
		$auction = mysql_fetch_array(mysql_query("SELECT id, product_id, start_time, end_time, price, closed, price_past_zero FROM auctions WHERE id = ".$value), MYSQL_ASSOC);

		// Get the product related to auction
		$product = mysql_fetch_array(mysql_query("SELECT id, rrp, fixed, fixed_price FROM products WHERE id = ".$auction['product_id']), MYSQL_ASSOC);

		$result = array();

		// lets get the latest bidder if there are no histories to get!
		if(empty($_GET['histories'])) {
			// Get the latest bid for auction
			$bid = mysql_fetch_array(mysql_query("SELECT b.id, b.user_id, b.description, b.created, u.username FROM bids b, users u WHERE b.credit = 0 AND b.user_id = u.id AND b.auction_id = ".$value." ORDER BY b.id DESC LIMIT 1"), MYSQL_ASSOC);
			if(!empty($bid['username'])) {
				$bid['username']   = utf8_encode($bid['username']);
				$result['LastBid'] = $bid;
			}else{
				$result['LastBid']['username'] = __('No bids yet');
			}
		}

		// Formatting auction array
		$auction['closes_on'] 			  = niceShort($auction['end_time']);
		$auction['element']				  = $key;

		// Formatting last result
		$result['Product'] = $product;
		$result['Auction'] = $auction;

		// If requested, include the bid histories
		if(!empty($_GET['histories'])) {
			// Get the bid histories
			$bidHistories = mysql_query("SELECT b.id, b.user_id, b.description, b.debit, b.created, u.username FROM bids b, users u WHERE b.credit = 0 AND b.user_id = u.id AND b.auction_id = ".$auction['id']." ORDER BY b.id DESC LIMIT ".$bidHistoryLimit);

			// Get the total rows
			$total_rows   = mysql_num_rows($bidHistories);

			// If there is a result
			if($total_rows > 0) {
				$bidHistoriesResult = array();

				// Loop through results
				$lastBidder = false;

				if($timePrice == 'price') {
					$lastPrice = $auction['price'];
				}


				while($history = mysql_fetch_array($bidHistories, MYSQL_ASSOC)) {
					$bidHistory['Bid']['id']          = $history['id'];
					if($timePrice == 'price') {
						// for showing the amount each time
						$bidHistory['Bid']['created'] = currency($lastPrice, $currency);

						// lets update the last price
						$lastPrice -= $priceIncrement;
					} else {
						$bidHistory['Bid']['created']     = niceShort($history['created']);
					}

					$bidHistory['Bid']['description'] = $history['description'];
					$bidHistory['User']['username']   = utf8_encode($history['username']);
					$bidHistoriesResult[] = $bidHistory;

					if($lastBidder == false) {
						$result['LastBid'] = $bidHistory['User'];
						$lastBidder = true;
					}
				}

				// Put the formatted history to result
				$result['Histories'] = $bidHistoriesResult;
			} else {
				$result['LastBid']['username'] = __('No bids yet');
			}
		}

		// lets cache this query
		if(!empty($_GET['histories'])) {
			$auction = cacheWrite('cake_auction_view_'.$value, $result);
		} else {
			$auction = cacheWrite('cake_auction_'.$value, $result);
		}
	}

	// some settings we couldn't cache
	$result['Product']['rrp'] 	  			= $result['Product']['rrp'] * $rate;
	if(!empty($result['Product']['fixed'])) {
		$result['Product']['fixed_price'] 	= $result['Product']['fixed_price'] * $rate;
	}

	if(!empty($_GET['histories']) || !empty($_GET['savings'])) {
		// Calculate the auction and product savings
		$saving  = savings($result['Auction'], $result['Product']);
		$result['Auction']['savings']['percentage'] = $saving['percentage'] . '%';
		$result['Auction']['savings']['price']      = currency($saving['price'], $currency);
	}

	if($result['Auction']['price'] < 0 && empty($result['Auction']['price_past_zero'])) {
		$result['Auction']['show_price'] = currency(0, $currency);
	}

	// make sure this is after the savings
	$result['Auction']['price'] = currency($result['Auction']['price'], $currency);

	$result['Auction']['serverTimestamp'] 	= time();
	if(!empty($_GET['tf'])){
		$tf = strip_tags($_GET['tf']);
		$result['Auction']['serverTimeString'] 	= date($tf);
	}else{
		$result['Auction']['serverTimeString'] 	= date('M jS, h:i:s');
	}

	$result['Auction']['time_left']	= strtotime($result['Auction']['end_time']) - time();

	// now lets check that the site is online
	if($siteOnline == 0) {
		$result['Auction']['isPeakNow'] 	= 0;
		$result['Auction']['peak_only'] 	= 1;
	} else {
		$result['Auction']['isPeakNow'] 	= $isPeakNow;
	}

	if(!empty($result['Auction']['closed'])) {
		$result['Auction']['end_time_string']	= __('GONE');
	} elseif($result['Auction']['time_left'] == 1) {
		$result['Auction']['end_time_string']   = __('Going...');
	} elseif($result['Auction']['time_left'] < 1) {
		$result['Auction']['end_time_string']   = __('GOING...');
	} else {
		$result['Auction']['end_time_string']   = getStringTime($result['Auction']['end_time']);
	}

	$result['Auction']['end_time'] 		  	= strtotime($result['Auction']['end_time']); // keep it last

	// Put the result to main results array
	$results[] = $result;
}

if(empty($_GET['test'])) {
	// Set the header
	header('Content-type: text/json');
	$json = new FastJSON();
	echo $json->convert($results);
}else{
	$end = microtime() - $start;
	echo round($end * 1000) . 'ms';
}

if(isset($db)) {
	mysql_close($db);
}
?>