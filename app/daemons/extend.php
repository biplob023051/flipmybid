<?php
$start = microtime();

ini_set('memory_limit', '256M');

// lets get the directory
if(defined('STDIN')) {
	$dir = str_replace('/daemons/extend.php', '', $_SERVER['SCRIPT_FILENAME']);
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

// lets see if testing mode is turned on!
if(enabled('testing_mode') == false) {
	return false;
}

if(cacheRead('cake_extend.pid')) {
	return false;
} else {
	cacheWrite('cake_extend.pid', microtime(), $cronTime * 55);
}

// lets extend it by placing an autobid
$autobid_time 				= get('autobid_time');
if(serverLoad() > 5) {
	$autobid_time = $autobid_time * 2;
}

// add the dynamic settings
$data['time_increment'] 	= get('time_increment');
$data['bid_debit'] 			= get('bid_debit');
$data['price_increment'] 	= get('price_increment');

$expireTime = time() + ($cronTime * 60);

while (time() < $expireTime) {
	if($autobid_time > 0) {
		$date = date('Y-m-d H:i:s', time() + $autobid_time);
		$sql = mysql_query("SELECT a.id, a.end_time, a.autobids, a.realbids, a.winner_id, a.leader_id, a.price, a.beginner, a.allow_zero, p.rrp FROM auctions a, products p WHERE p.id = a.product_id AND a.closed = 0 AND a.active = 1 AND a.autobid = 1 AND a.end_time < '$date'");
	} else {
		$sql = mysql_query("SELECT a.id, a.end_time, a.autobids, a.realbids, a.winner_id, a.leader_id, a.price, a.beginner, a.allow_zero, p.rrp FROM auctions a, products p WHERE p.id = a.product_id AND a.closed = 0 AND a.active = 1 AND a.autobid = 1");
	}
	$total_rows   = mysql_num_rows($sql);

	if($total_rows > 0) {
		while($auction = mysql_fetch_array($sql, MYSQL_ASSOC)) {
			extend($auction, $data);
		}
	}

	// sleep for a second
	flush();
	sleep(1);
}

cacheDelete('cake_extend.pid');

if(isset($db)) {
	mysql_close($db);
}
?>