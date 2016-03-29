<?php
$start = microtime();

ini_set('memory_limit', '256M');

if(defined('STDIN')) {
	$dir = str_replace('/daemons/close.php', '', $_SERVER['SCRIPT_FILENAME']);
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

if(cacheRead('cake_close.pid')) {
	return false;
} else {
	cacheWrite('cake_close.pid', microtime(), $cronTime * 55);
}
$data['time_increment'] 	= get('time_increment');
$data['bid_debit'] 			= get('bid_debit');
$data['price_increment'] 	= get('price_increment');

$expireTime = time() + ($cronTime * 60);

$serverLoad = serverLoad();

while (time() < $expireTime) {
	// lets start by getting all the auctions that have closed
	$sql = mysql_query("SELECT * FROM auctions WHERE end_time <= '".date('Y-m-d H:i:s')."' AND closed = 0 AND active = 1");
	$total_rows   = mysql_num_rows($sql);

	if($total_rows > 0) {
		while($auction = mysql_fetch_array($sql, MYSQL_ASSOC)) {
			if(checkCanClose($auction['id'], 1, true, $serverLoad) == false) {
				$placed = placeAutobid($auction['id'], $data, 0, $auction['beginner']);
				if($placed == false) {
					// if the bid wasn't placed for any reason, then lets simply extend the auction
					$auction['end_time'] = date('Y-m-d H:i:s', time() + 60);
					mysql_query("UPDATE auctions SET end_time = '".$auction['end_time']."', modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);
					clearCache($auction['id']);
				}
			} else {
				// it is OK to close this auction
				mysql_query("UPDATE auctions SET closed = 1, serverload = ".$serverLoad.", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);

				// lets get the winner
				$bid = lastBid($auction['id']);

				// now lets check the auction is still closed
				$check = mysql_fetch_array(mysql_query("SELECT closed FROM auctions WHERE id = ".$auction['id']), MYSQL_ASSOC);
				if($check['closed'] == 0) {
					continue;
				}

				$reserveMet = true;

				// lets see if there is a reserve
				if($auction['reserve_price'] > 0) {
					// there is alright.  Lets double check it was not meet!
					if($auction['reserve_price'] > $auction['price']) {
						// right, time to refund all the users!
						bidBack($auction['id'], 'refund');

						// and lastly, set the $reserveNotMet variable
						$reserveMet = false;
					}
				}

				if(!empty($bid) && $reserveMet == true) {
					if($bid['autobidder'] == 0) {
						// add the auction_id into auction_emails for sending
						mysql_query("INSERT INTO auction_emails (auction_id) VALUES ('".$auction['id']."')");
						mysql_query("UPDATE auctions SET status_id = 1, closed = 1, winner_id = ".$bid['user_id'].", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);
					} else {
						mysql_query("UPDATE auctions SET winner_id = ".$bid['user_id'].", closed = 1, modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);
					}
				}

				clearCache($auction['id']);

				// lets remove any autobids from the system
				mysql_query("DELETE FROM autobids WHERE auction_id = ".$auction['id']);
				mysql_query("DELETE FROM smartbids WHERE auction_id = ".$auction['id']);

				if($reserveMet == true) {
					$ingoreUsers = array();

					if(!empty($auction['bids_back_winner']) && get('bids_back_winner')) {
						$ingoreUsers[] = bidBack($auction['id'], 'winner');
					}

					if(!empty($auction['bids_back_most_bids']) && get('bids_back_most_bids')) {
						$ingoreUsers[] = bidBack($auction['id'], 'most_bids');
					}

					if(!empty($auction['bids_back_random']) && get('bids_back_random')) {
						$ingoreUsers[] = bidBack($auction['id'], 'random');
					}

					// lets calulate any bid points!
					if(enabled('reward_points') && get('bid_points')) {
						bidPoints($auction['id'], $auction['product_id'], $ingoreUsers);
					}
				}

				// now check if we need to relist this auction
				if(!empty($auction['autolist']) && enabled('autolisting')) {
					$productSql = mysql_query("SELECT id FROM auctions WHERE closed = 0 AND active = 1 AND autolist_minutes = '".$auction['autolist_minutes']."' AND product_id = ".$auction['product_id']);
					if(mysql_num_rows($productSql) == 0 || empty($auction['autolist_minutes'])) {
						// check for a delayed start time
						$delayed_start = get('autolist_delay_time');

						if(!empty($auction['autolist_minutes'])) {
							if(!empty($delayed_start)) {
								$auction['start_time'] = date('Y-m-d H:i:s', time() + $delayed_start * 60);
								$auction['end_time'] = date('Y-m-d H:i:s', time() + ($auction['autolist_minutes'] + $delayed_start) * 60);
							} else {
								$auction['start_time'] = date('Y-m-d H:i:s');
								$auction['end_time'] = date('Y-m-d H:i:s', time() + $auction['autolist_minutes'] * 60);
							}
						} else {
							if(!empty($delayed_start)) {
								$auction['start_time'] = date('Y-m-d H:i:s', time() + $delayed_start * 60);
							} else {
								$auction['start_time'] = date('Y-m-d H:i:s');
							}

							// lets work out the new end time
							if($auction['autolist_time'] == '0:0') {
								$auction['autolist_time'] = '00:00';
							}

							$auction['end_time'] = date('Y-m-d '.$auction['autolist_time'].':00');

							// lets make sure the time is not more than 24 hours away
							if(strtotime($auction['end_time']) > time() + 86400) {
								$auction['end_time'] = date('Y-m-d H:i:s', strtotime($auction['end_time']) - 86400);
							}

							// lets make sure the time is not less than now
							if(strtotime($auction['end_time']) < time()) {
								$auction['end_time'] = date('Y-m-d H:i:s', strtotime($auction['end_time']) + 86400);
							}

							// finally lets just make sure the start time isn't greater than the end time.  If it is, extend the end time by 24 hours
							if(strtotime($auction['start_time']) > strtotime($auction['end_time'])) {
								$auction['end_time'] = date('Y-m-d H:i:s', strtotime($auction['end_time']) + 86400);
							}
						}

						if(get('randomize_autobids')) {
							if(!empty($auction['min_autobids']) && !empty($auction['max_autobids'])) {
								$auction['autobids'] = mt_rand($auction['min_autobids'], $auction['max_autobids']);
							}

							if(!empty($auction['min_realbids']) && !empty($auction['max_realbids'])) {
								$auction['realbids'] = mt_rand($auction['min_realbids'], $auction['max_realbids']);
							}
						}

						$product = mysql_fetch_array(mysql_query("SELECT start_price FROM products WHERE id = ".$auction['product_id']), MYSQL_ASSOC);
						$auction['price'] = $product['start_price'];

						if($auction['reserve_price'] > 0) {
							$auction['reserve'] = 1;
						}

						mysql_query("INSERT INTO auctions (product_id, start_time, end_time, price, autolist, autolist_time, autolist_minutes, featured, beginner, autobid, autobids, min_autobids, max_autobids, realbids, min_realbids, max_realbids, limit_id, active, membership_id, free, reserve, reserve_price, allow_zero, bids_back_winner, bids_back_most_bids, bids_back_random, bids_back_total, reverse_extend, price_past_zero, charity, created, modified) VALUES ('".$auction['product_id']."', '".$auction['start_time']."', '".$auction['end_time']."', '".$auction['price']."', '".$auction['autolist']."', '".$auction['autolist_time']."', '".$auction['autolist_minutes']."', '".$auction['featured']."', '".$auction['beginner']."', '".$auction['autobid']."', '".$auction['autobids']."', '".$auction['min_autobids']."', '".$auction['max_autobids']."', '".$auction['realbids']."', '".$auction['min_realbids']."', '".$auction['max_realbids']."', '".$auction['limit_id']."', '".$auction['active']."', '".$auction['membership_id']."', '".$auction['free']."', '".$auction['reserve']."', '".$auction['reserve_price']."', '".$auction['allow_zero']."', '".$auction['bids_back_winner']."', '".$auction['bids_back_most_bids']."', '".$auction['bids_back_random']."', '".$auction['bids_back_total']."', '".$auction['reverse_extend']."', '".$auction['price_past_zero']."', '".$auction['charity']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
					}
				}
			}
		}
	}
	// sleep for 0.5 of a second
	flush();
	usleep(500000);
}

cacheDelete('cake_close.pid');

if(isset($db)) {
	mysql_close($db);
}
?>