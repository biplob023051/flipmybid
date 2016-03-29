<?php
$start = microtime();

ini_set('memory_limit', '256M');

if(defined('STDIN')) {
	$dir = str_replace('/daemons/bidbutler.php', '', $_SERVER['SCRIPT_FILENAME']);
} else {
  	if(substr($_SERVER['DOCUMENT_ROOT'], -12) == '/app/webroot') {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('/app/webroot', '', $_SERVER['DOCUMENT_ROOT']);
	}
	$dir = $_SERVER['DOCUMENT_ROOT'].'/app';
}

// Include the config file
require_once $dir.'/config/config.php';

// call the database
require_once $dir.'/database.php';

// Include the functions
require_once $dir.'/daemons_functions.php';

// Include some get status functions
require_once $dir.'/getstatus_functions.php';

// Setup the timezone
$timezone = get('time_zone');
if(!empty($timezone)){
	date_default_timezone_set($timezone);
}

// get the cron time
$cronTime = get('cron_time');

session_start();

// Get the peak
$isPeakNow = 1;

// Lets check that the site is online
$siteOnline = siteOnline();

if($siteOnline == 0) {
	exit;
}

if(cacheRead('cake_bidbutler.pid')) {
	return false;
} else {
	cacheWrite('cake_bidbutler.pid', microtime(), $cronTime * 55);
}

ob_start();

// Get the bid buddy time
$bidButlerTime = get('bid_butler_time');

// Get various settings needed
$data['time_increment'] 	= get('time_increment');
$data['bid_debit'] 			= get('bid_debit');
$data['price_increment'] 	= get('price_increment');

$expireTime = time() + ($cronTime * 60);

$count = 0;

while (time() < $expireTime) {
	$bidButlerEndTime = date('Y-m-d H:i:s', time() + $bidButlerTime);

	// Find the bidbutler entry - we get them from the lowest price to the maximum price so that they all run!
	$sql = mysql_query("SELECT b.auction_id, a.price, b.id, b.minimum_price, b.maximum_price, b.user_id, u.autobidder, p.fixed FROM auctions a, bidbutlers b, users u, products p WHERE a.id = b.auction_id AND u.id = b.user_id AND p.id = a.product_id AND a.end_time < '$bidButlerEndTime' AND a.closed = 0 AND a.active = 1 AND b.bids > 0 ORDER BY rand()");
	$totalRows   = mysql_num_rows($sql);

	if($totalRows > 0) {
		while($bidbutler = mysql_fetch_array($sql, MYSQL_ASSOC)) {
			if($bidbutler['price'] >= $bidbutler['minimum_price'] &&
			   $bidbutler['price'] < $bidbutler['maximum_price'] ||
			   $bidbutler['fixed'] == 1 ||
			   $bidbutler['autobidder'] == 1) {
				// Add more information
				$data['auction_id']	= $bidbutler['auction_id'];
				$data['user_id']	= $bidbutler['user_id'];
				$data['bid_butler']	= $bidbutler['id'];

				// Bid the auction
				bid($data, $bidbutler['autobidder']);

				// could i check for more bid buddies in the array here and loop em through?
			}
		}
	}

	// sleep for a random time between 1 and 5 seconds
	ob_flush();
	flush();
	sleep(mt_rand(1, 5));
}

cacheDelete('cake_bidbutler.pid');

if(isset($db)) {
	mysql_close($db);
}
?>