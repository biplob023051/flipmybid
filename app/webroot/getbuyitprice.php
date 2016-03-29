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

// Lets check that the site is online
$siteOnline = siteOnline();

// Starting session
session_start();
$data = $_POST;
// Reading user id
if(!empty($_SESSION['Auth'])) {
	$data['user_id'] = $_SESSION['Auth']['User']['id'];
} elseif(!empty($_COOKIE['CakeCookie']['User']['id'])) {
	$data['user_id'] = $_COOKIE['CakeCookie']['User']['id'];
} else {
	$data['user_id'] = null;
}

// Get the POST data
if(empty($data)){
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

if(isset($data))
{
	// userID is the calling user's id
	$userID = $data['user_id'];
	$auctionID = $data['auction_id'];
	
	/* Change by Andrew Buchan: Get buy it price */
	// Check user_id and auction_id were provided
	if(!empty($userID) && !empty($auctionID))
	{
		// Get auction and product details
		$auction = mysql_fetch_array(mysql_query("SELECT id, product_id, start_time, end_time, price, closed, price_past_zero, buy_it, buy_it_reduction_amount FROM auctions WHERE id = ".$auctionID), MYSQL_ASSOC);

		$product = mysql_fetch_array(mysql_query("SELECT id, rrp, fixed, fixed_price FROM products WHERE id = ".$auction['product_id']), MYSQL_ASSOC);
		
		$result = array();
		
		// Check if this auction has buy it enabled
		$buyItEnabled = $auction['buy_it'];
		if($buyItEnabled)
		{
			// Buy it is enabled so get reduction amount and no. of bids by this user
			$buyItReductionAmount = $auction['buy_it_reduction_amount'];
			$rrp = $product['rrp'];
			
			$bidCountArr = mysql_fetch_array(mysql_query("SELECT user_id, SUM(debit) AS BidCount FROM bids WHERE user_id = " . $userID . " AND auction_id = " . $auctionID . ""), MYSQL_ASSOC);
			$bidCount = $bidCountArr['BidCount'];
			// This id is the user who placed the bid
			$bidUserID = $bidCountArr['user_id'];
			
			// If calling user id and biduserid are the same then return the data we need for the link
			if($userID == $bidUserID)
			{
				$reduction = $bidCount * $buyItReductionAmount;
				$buyItPrice = $rrp - $reduction;
				$result['BuyIt']['enabled'] = 1;
				$result['BuyIt']['reduction_amount'] = $buyItReductionAmount;
				$result['BuyIt']['BidCount'] = $bidCount;
				$result['BuyIt']['price'] = $buyItPrice;
				$result['BuyIt']['user_id'] = $userID;
				$result['Auction']['element'] = 'auction_' . $auctionID;
				$result['Auction']['auction_id'] = $auctionID;
				
				$results[] = $result;
			}
		}
	}
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