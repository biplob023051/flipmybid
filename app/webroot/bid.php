<?php
// Include the config file
require_once '../config/config.php';

// just incase the database isn't called yet
require_once '../database.php';

// Include the functions
require_once '../daemons_functions.php';

// Include some get status functions
require_once '../getstatus_functions.php';

// Setup the timezone
$timezone = get('time_zone');
if(!empty($timezone)){
	date_default_timezone_set($timezone);
}

// Reading session id from cookie
if(!empty($_COOKIE['AUCTION'])){
	$sessionId = $_COOKIE['AUCTION'];
	session_id($sessionId);
}

// Starting session
session_start();

// Reading user id
if(!empty($_SESSION['Auth'])) {
	$data['user_id'] = $_SESSION['Auth']['User']['id'];
} elseif(!empty($_COOKIE['CakeCookie']['User']['id'])) {
	$data['user_id'] = $_COOKIE['CakeCookie']['User']['id'];
} else {
	$data['user_id'] = null;
}

if(!empty($_GET['id'])) {
	$data['auction_id']	= $_GET['id'];

	$data['time_increment'] 	= get('time_increment');
	$data['bid_debit'] 			= get('bid_debit');
	$data['price_increment'] 	= get('price_increment');
} else {
	die();
}

// Bid the auction
$auction = bid($data);

// Include JSON libs
require_once '../../vendors/fastjson/fastjson.php';

// Set the header
header('Content-type: text/json');
$json = new FastJSON();
echo $json->convert($auction);
?>