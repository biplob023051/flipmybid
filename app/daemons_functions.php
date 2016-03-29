<?php
function checkCanClose($id, $isPeakNow, $timeCheck = true, $serverLoad = 1) {
	// DO NOT CHANGE THIS CODE WITHOUT APPROVAL OF MICHAEL HOUGHTON FIRST

	$auction = mysql_fetch_array(mysql_query("SELECT a.id, a.end_time, a.price, a.leader_id, a.winner_id, a.featured, a.autobid, a.autobids, a.realbids, a.limit_id, a.allow_zero, p.rrp, p.bids, p.fixed FROM auctions a, products p WHERE a.id = $id AND a.product_id = p.id"), MYSQL_ASSOC);

	if($timeCheck == true) {
		// lets check it has actually expired
		if(strtotime($auction['end_time']) > time()) {
			return false;
		}
	}

	// lets check if a winner has been assigned to this auction
	$latest_bid = lastBid($auction['id']);

	// this is silly, but needed because sometimes the leader_id !== the highest bidder.
	// this is most likely from a bug but the bug hasn't been worked out yet.
	if(!empty($latest_bid)) {
		if($latest_bid['user_id'] !== $auction['leader_id']) {
			return false;
		}
	}

	// lets check that there are no bid buddies left to be placed
	if(!empty($auction['fixed'])) {
		if(!empty($latest_bid)) {
			$sql = mysql_query("SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND auction_id = ".$auction['id']." AND user_id != ".$latest_bid['user_id']);
		} else {
			$sql = mysql_query("SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND auction_id = ".$auction['id']);
		}
	} else {
		if(!empty($latest_bid)) {
			$sql = mysql_query("SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND minimum_price <= '".$auction['price']."' AND maximum_price > '".$auction['price']."' AND auction_id = ".$auction['id']." AND user_id != ".$latest_bid['user_id']);
		} else {
			$sql = mysql_query("SELECT id, user_id FROM bidbutlers WHERE bids > 0 AND minimum_price <= '".$auction['price']."' AND maximum_price > '".$auction['price']."' AND auction_id = ".$auction['id']);
		}
	}

	$totalRows = mysql_num_rows($sql);

	if($totalRows > 0) {
		// go through each of them and make sure that they have bids left in their account
		while($bidbutler = mysql_fetch_array($sql, MYSQL_ASSOC)) {
			$bid = placeBidbuddy($bidbutler['user_id'], $auction['id'], $bidbutler['id']);
			if(!empty($bid['Bid']['success'])) {
				return false;
			}
		}
	}

	// does this auction have autobidders on it?
	if(!empty($auction['autobid']) && enabled('testing_mode')) {
		// first lets see if enough REAL bids have been placed!  If so, we don't need to check the autobids!
		if(!empty($auction['realbids'])) {
			$totalRealbids = totalRealbids($auction['id']);
			if($totalRealbids < $auction['realbids']) {
				$checkAutobids = true;
			}
		} else {
			$checkAutobids = true;
		}

		if(!empty($auction['allow_zero'])) {
			$totalBids = totalBids($auction['id']);

			if($totalBids == 0) {
				// an easy way to create a random digit!
				$number = strtotime($auction['end_time']);

				if(($number & 1) == 0) {
					$checkAutobids = false;
				}
			}
		}

		if(!empty($checkAutobids)) {
			// lets see if enough autobids have been placed
			$totalAutobids = totalAutobids($auction['id']);

			if($totalAutobids < $auction['autobids']) {
				return false;
			} elseif(empty($latest_bid['autobidder'])) {
				return false;
			}
		}

		// finally, just make sure there are no autobutlers left
		$sql = mysql_query("SELECT b.id FROM bidbutlers b, users u WHERE b.user_id = u.id AND b.auction_id = ".$auction['id']." AND b.bids > 0 and u.autobidder = 1  AND b.user_id != ".$latest_bid['user_id']);
		$totalRows = mysql_num_rows($sql);
		if($totalRows > 0) {
			return false;
		}
	}

	// everything has passed, lets make sure the auction is still ending and the latest bidder is still the same!
	$auction = mysql_fetch_array(mysql_query("SELECT end_time FROM auctions WHERE id = ".$id), MYSQL_ASSOC);

	if($timeCheck == true) {
		// lets check it has actually expired
		if(strtotime($auction['end_time']) > time()) {
			return false;
		}
	}

	$last_bid = lastBid($id);
	if(!empty($latest_bid) && !empty($last_bid)) {
		if($latest_bid['user_id'] !== $last_bid['user_id']) {
			return false;
		}
	}

	return true;
}

function placeBidbuddy($user_id = null, $auction_id = null, $bidbuddy_id = null) {
	$data['user_id'] 		= $user_id;
	$data['bid_butler'] 	= $bidbuddy_id;
	$data['auction_id']		= $auction_id;

	$data['time_increment'] 	= get('time_increment');
	$data['bid_debit'] 			= get('bid_debit');
	$data['price_increment'] 	= get('price_increment');

	// Bid the auction
	return bid($data);
}

function lastBid($auction_id = null) {
	// Use contain user only and get bid.auction_id instead of auction.id
	// cause it needs the auction included in result array
	$lastBid = mysql_fetch_array(mysql_query("SELECT b.id, b.debit, u.username, b.description, b.user_id, u.autobidder, b.created FROM bids b, users u WHERE b.auction_id = $auction_id AND b.user_id = u.id ORDER BY b.id DESC"), MYSQL_ASSOC);

	$bid = array();

	if(!empty($lastBid)) {
		$bid = array(
			'debit'       => $lastBid['debit'],
			'created'     => $lastBid['created'],
			'username'    => $lastBid['username'],
			'description' => $lastBid['description'],
			'user_id'     => $lastBid['user_id'],
			'autobidder'  => $lastBid['autobidder']
		);
	}
	return $bid;
}

function check($auction_id, $end_time, $data, $smartAutobids = false, $beginner = false) {
	// lets check to see if there are no bids in the que already
	$autobid = mysql_fetch_array(mysql_query("SELECT * FROM autobids WHERE auction_id = $auction_id"), MYSQL_ASSOC);

	if(!empty($autobid)) {
		if($autobid['end_time'] == $end_time) {
			if($autobid['deploy'] <= date('Y-m-d H:i:s')) {
				// lets place the bid!
				placeAutobid($auction_id, $data, 0, $beginner);
				mysql_query("DELETE FROM autobids WHERE auction_id = $auction_id");

				$auction = mysql_fetch_array(mysql_query("SELECT end_time FROM auctions WHERE id = $auction_id"), MYSQL_ASSOC);
				$end_time = $auction['end_time'];
			} else {
				return false;
			}
		} else {
			mysql_query("DELETE FROM autobids WHERE auction_id = $auction_id");
		}
	}
	$str_end_time = strtotime($end_time);

	$timeDifference = $str_end_time - time();
	$randomTime = mt_rand(2, $timeDifference);

	$deploy = date('Y-m-d H:i:s', $str_end_time - $randomTime);

	mysql_query("INSERT INTO autobids (deploy, end_time, auction_id) VALUES ('$deploy', '$end_time', '$auction_id')");

	return $data;
}

function placeAutobid($id, $data = array(), $ignore_user_id = 0, $beginner = false, $noMoreBids = false) {
	$data['auction_id']	= $id;

	$bid = lastBid($id);

	if(!empty($bid)) {
		$bidder = $bid['user_id'];

		// we are selecing a bidder who has already bid
		$user = mysql_fetch_array(mysql_query("SELECT u.id FROM smartbids s, users u WHERE s.auction_id = $id AND s.user_id != $bidder AND s.user_id = u.id AND u.id != $ignore_user_id ORDER BY rand() LIMIT 1"), MYSQL_ASSOC);

		// Note: with the new win limits we may need advanced code here in the future to make sure the limits also apply to autobidders

		$smartBidders = mysql_query("SELECT id FROM smartbids WHERE auction_id = ".$id);
		$smartBiddersCount = mysql_num_rows($smartBidders);
		if($smartBiddersCount < 3) {
			$noMoreBids = true;
		}


		if(mt_rand(0, 30) == 30) {
			// lets work out how many bidders we already have on this auction to see if we need to select a new bidder
			if($smartBiddersCount < 3) {
				$noMoreBids = false;
				if($beginner == true) {
					$user = beginnerAutobidder(null, $ignore_user_id);
				} else {
					$user = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE active = 1 AND autobidder = 1 AND id != $ignore_user_id ORDER BY modified asc LIMIT 1"), MYSQL_ASSOC);
				}
			}
		}

		if(empty($user)) {
			if($beginner == true) {
				$user = beginnerAutobidder($bidder, $ignore_user_id);
			} else {
				$user = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE active = 1 AND autobidder = 1 AND id != $bidder AND id != $ignore_user_id ORDER BY modified asc LIMIT 1"), MYSQL_ASSOC);
			}
		}
	} else {
		$user = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE active = 1 AND autobidder = 1 ORDER BY modified asc LIMIT 1"), MYSQL_ASSOC);
	}

	if(!empty($user)) {
		$data['user_id']	= $user['id'];

		// Bid the auction
		$auction = bid($data, true);

		if(!empty($auction['Bid']['user_id'])) {
			// this is too ensure only 2 bids are placed at once
			if($noMoreBids == true) {
				$auction['Bid']['previous_bid'] = 0;
			}

			// lets give history to the fact that the autobidder has bid on this auction
			bidPlaced($auction['Auction']['id'], $auction['Bid']['user_id'], $auction['Bid']['previous_bid'], $beginner);
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function beginnerAutobidder($lastBidder = 0, $ingoreUser = 0, $count = 0) {
	$user = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE active = 1 AND autobidder = 1 AND id != $lastBidder AND id != $ingoreUser ORDER BY rand() LIMIT 1"), MYSQL_ASSOC);

	// if the count gets too high lets just return the user
	if($count == 8) {
		return $user;
	}

	// now lets see how many auctions they have won
	$wins = mysql_query("SELECT id FROM auctions WHERE winner_id = ".$user['id']);
	$totalWins = mysql_num_rows($wins);

	if($totalWins <= 5) {
		return $user;
	} else {
		$count ++;
		return beginnerAutobidder($lastBidder, $ingoreUser, $count);
	}

}

function bid($data = array(), $autobid = false) {
	$canBid = true;
	$message = null;

	if(empty($data['user_id'])) {
		$result['Auction']['id']      = $data['auction_id'];
		$result['Auction']['message'] = __('You are not logged in!', true);
		$result['Auction']['element'] = 'auction_'.$data['auction_id'];
		$result['Auction']['hold'] = true;

		return $result;
	}

	// Get the auctions
	$auction = mysql_fetch_array(mysql_query("SELECT a.id, a.product_id, a.start_time, a.end_time, a.price, a.closed, a.autobids, a.featured, a.beginner, a.max_time, a.limit_id, a.reserve, a.reserve_price, a.membership_id, a.reverse, a.reverse_extend, p.exchange, p.rrp, p.bids FROM auctions a, products p WHERE a.product_id = p.id AND a.id = ".$data['auction_id']), MYSQL_ASSOC);

	if(!empty($auction)) {
		// Get user balance
		if($autobid == true) {
			$balance = $data['bid_debit'];
		} else {
			$balance = balance($data['user_id']);
		}

		$latest_bid = lastBid($data['auction_id']);

		// Check if the auction has been end - this only applies to NON autobidders
		if((empty($auction['closed']) && strtotime($auction['end_time']) < time()) && $autobid == false) {
			$message = __('There was an error processing your bid, please try again!', true);
			$canBid = false;
		} elseif((!empty($auction['closed']) || strtotime($auction['end_time']) < time()) && $autobid == false) {
			$message = __('This auction has closed!', true);
			$canBid = false;
		} elseif(strtotime($auction['start_time']) > time()){
			$message = __('Auction has not started yet!', true);
			$canBid = false;
		} elseif(!empty($latest_bid) && $latest_bid['user_id'] == $data['user_id']) {
			$message = __('You cannot bid as you are already the highest bidder!', true);
			$canBid = false;
		} elseif(checkBeginner($data['user_id'], $autobid, $auction['beginner']) == false) {
			// check if this is a beginner auction
			$message = __('This is a beginner auction - only users who have not won yet can bid on this auction.', true);
			$result['Auction']['hold'] = true;
			$canBid = false;

			if(!empty($data['bid_butler'])) {
				clearBidbutler($data['bid_butler']);
			}
		} elseif(checkLimits($data['user_id'], $auction['limit_id'], $autobid) == false) {
			// win limits stuff
			$message = __('Your win limits have been reached on this auction.', true);
			$canBid = false;
		} elseif(!empty($auction['exchange'])) {
			// lets check if they have already exchanged this product
			$exchanges = mysql_query("SELECT id FROM exchanges WHERE auction_id = ".$data['auction_id']." AND user_id = ".$data['user_id']);
			$totalExchanges   = mysql_num_rows($exchanges);
			if($totalExchanges > 0) {
				$message = __('You have already purchased this product.', true);
				$canBid = false;

				if(!empty($data['bid_butler'])) {
					clearBidbutler($data['bid_butler']);
				}
			}
		}

		// lets do some final membership checking
		if(enabled('memberships') && empty($autobid) && !empty($auction['membership_id'])) {
			// lets get there membership
			$user = mysql_fetch_array(mysql_query("SELECT membership_id from users WHERE id = ".$data['user_id']), MYSQL_ASSOC);
			$membership = mysql_fetch_array(mysql_query("SELECT id, beginner from memberships WHERE id = ".$user['membership_id']), MYSQL_ASSOC);

			if(empty($membership['beginner']) && !empty($auction['beginner'])) {
				$message = __('Your membership does not allow you to bid on beginner auctions.', true);
				$canBid = false;
			} elseif($user['membership_id'] < $auction['membership_id']) {
				$message = __('You cannot bid on this auction as it is outside your membership level.', true);
				$canBid = false;
			}
		}

		if($canBid == true) {
			// Checking if user has enough bid to place
			if($balance >= $data['bid_debit']) {
				// Formatting user bid transaction
				$bid['user_id'] 	  = $data['user_id'];
				$bid['auction_id'] 	  = $auction['id'];
				$bid['credit']     	  = 0;
				$bid['debit']     	  = $data['bid_debit'];

				// Insert proper description, bid or bidbutler
				if(!empty($data['bid_butler'])){
					$bid['description'] = __('Bid Buddy', true);
				} else {
					$bid['description'] = __('Single Bid', true);
				}

				// Check if it's bidbutler call
				if(!empty($data['bid_butler'])) {
					$bidbutler = mysql_fetch_array(mysql_query("SELECT * FROM bidbutlers WHERE id = ".$data['bid_butler']), MYSQL_ASSOC);

					// If bidbutler found
					if(!empty($bidbutler)) {
						if($bidbutler['bids'] >= $data['bid_debit']) {
							// Decrease the bid buddies bids
							$bidbutler['bids'] -= $data['bid_debit'];

							// Save it
							mysql_query("UPDATE bidbutlers SET bids = '".$bidbutler['bids']."', modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$bidbutler['id']);
						} else {
							// Get out of here, the bids on bidbutler was empty
							return $auction;
						}
					}
				}

				// leader_id
				$auction['leader_id'] = $data['user_id'];

				// lets grab it again to make sure we have the latest
				$endTime = mysql_fetch_array(mysql_query("SELECT end_time FROM auctions WHERE id = ".$data['auction_id']), MYSQL_ASSOC);

				// lets see if this is a reverse auction with reverse extend
				if(($auction['price'] - $data['price_increment']) <= 0 && !empty($auction['reverse']) && $auction['reverse_extend'] > 0) {
					// if they price IS zero, then we change the clock!
					if(($auction['price'] - $data['price_increment']) == '0.00') {
						$auction['end_time'] = date('Y-m-d H:i:s', time() + $auction['reverse_extend']);
					}
				} else {
					// lets see if we need to check the max time extend stuff
					$maxAuctionTime = get('max_auction_time');
					$maxCounterTime = get('max_counter_time');

					if(!empty($maxAuctionTime) && !empty($auction['max_time'])) {
						if((strtotime($auction['end_time']) - time()) <= $auction['max_time']) {
							$checkAuctionCounterTime = true;
						} else {
							$noTimeExtend = true;
						}
					} elseif(!empty($maxCounterTime)) {
						if((strtotime($auction['end_time']) - time()) <= $maxCounterTime) {
							$checkCounterTime = true;
						} else {
							$noTimeExtend = true;
						}
					}

					$auction['end_time'] = date('Y-m-d H:i:s', strtotime($endTime['end_time']) + $data['time_increment']);

					if(!empty($checkAuctionCounterTime)) {
						if((strtotime($auction['end_time']) - time()) > $auction['max_time']) {
							$auction['end_time'] = date('Y-m-d H:i:s', time() + $auction['max_time']);
						}
					} elseif(!empty($checkCounterTime)) {
						if((strtotime($auction['end_time']) - time()) > $maxCounterTime) {
							$auction['end_time'] = date('Y-m-d H:i:s', time() + $maxCounterTime);
						}
					}
				}

				// lets make sure the auction time is now less than now
				if(strtotime($auction['end_time']) < time()) {
					$auction['end_time'] = date('Y-m-d H:i:s', time() + $data['time_increment']);
				}

				// this is part of the max end time stuff
				$endTimeSql = '';
				if(empty($noTimeExtend)) {
					$endTimeSql = "end_time = '".$auction['end_time']."', ";
				}

				if(!empty($auction['reverse'])) {
					$data['price_increment'] = $data['price_increment'] * -1;
				}

				$success = mysql_query("UPDATE auctions SET $endTimeSql price = price + ".$data['price_increment'].", closed = 0, leader_id = ".$bid['user_id'].", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction['id']);

				if($success == 1) {
					// Save the bid
					mysql_query("INSERT INTO bids (user_id, auction_id, description, debit, created, modified) VALUES ('".$bid['user_id']."', '".$bid['auction_id']."', '".$bid['description']."', '".$bid['debit']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
					fixDoubleBids($bid['auction_id']);

					if($autobid == true) {
						mysql_query("UPDATE users SET modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['user_id']);
					}
					
					/* Change by Andrew Buchan on 2015-03-05: Automatically upgrade user to next membership rank if total bids > next membership level points*/
					if(enabled('memberships'))
					{
						// First: get the user's current membership_id
						$currentMembership = mysql_fetch_array(mysql_query("SELECT membership_id FROM users WHERE id = " . $data['user_id']), MYSQL_ASSOC);
						if(!empty($currentMembership))
						{
							$membershipID = $currentMembership['membership_id'];
							
							// Second: get number of bids user has
							$currentTotalBids = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS totalbids FROM bids WHERE user_id = " . $data['user_id'] . " AND auction_id > 0"), MYSQL_ASSOC);
							if(!empty($currentTotalBids))
							{
								$totalBids = $currentTotalBids['totalbids'];
								
								// Third: get next membership level
								$nextMembership = mysql_fetch_array(mysql_query("SELECT id, points FROM memberships WHERE id > " . $membershipID . " ORDER BY id LIMIT 1"), MYSQL_ASSOC);
								if(!empty($nextMembership))
								{
									$membershipLevel = $nextMembership['id'];
									$bidsRequired = $nextMembership['points'];
									
									// Fourth check if $totalBids >= $bidsRequired. If so update users set membership_id = $membershipLevel, modified = now() where id = user_id
									if($totalBids >= $bidsRequired)
									{
									
										mysql_query("UPDATE users SET membership_id = " . $membershipLevel . ", modified = NOW() WHERE id = " . $data['user_id']);
									
									}
								
								}
								
							}
						}
					}
					
					/* End Change */

					// lets see if the auction had a reserve
					if(!empty($auction['reserve'])) {
						$price = $auction['price'] + $data['price_increment'];

						if($price >= $auction['reserve_price']) {
							mysql_query("UPDATE auctions SET reserve = 0, modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$data['auction_id']);
						}
					}
                                        $result['Auction']['balance'] = $balance - $bid['debit'];
					$message = __('Your bid was placed!', true);
				} else {
					$message = __('There was a problem placing the bid please contact us!', true);
				}

				// this is normally in afterSave but need this here
				clearCache($auction['id'], $data['user_id']);

				// lets add in the bid information for smartBids - we need this
				if(empty($latest_bid['user_id'])) {
					$latest_bid['user_id'] = 0;
				}
				$bid['previous_bid'] = $latest_bid['user_id'];
				$bid['success'] = true;
				$result['Bid'] = $bid;
			} else {
				$message = '<a href="/packages">'.__('You have no bids in your account. Click here to purchase bids so you can bid on this product!').'</a>';
				$result['Auction']['hold'] = true;
				if(!empty($data['bid_butler'])) {
					clearBidbutler($data['bid_butler']);
				}
			}
		}

		$result['Auction']['id']      = $auction['id'];
		$result['Auction']['message'] = $message;
		$result['Auction']['element'] = 'auction_'.$auction['id'];
		if(empty($result['Auction']['hold'])) {
			$result['Auction']['hold'] = false;
		}

		return $result;
	} else {
		return false;
	}
}

function fixDoubleBids($auction_id = null) {
	$bidHistories = mysql_query("SELECT * FROM bids WHERE credit = 0 AND auction_id = ".$auction_id." ORDER BY id DESC LIMIT 2");
	$totalBids   = mysql_num_rows($bidHistories);

	if($totalBids > 0) {
		$user_id = 0;
		while($bid = mysql_fetch_array($bidHistories, MYSQL_ASSOC)) {
			if(empty($user_id)) {
				// this is the first bid checking
				$user_id = $bid['user_id'];
			} else {
				// lets compare this to the second bid
				if($bid['user_id'] == $user_id) {
					mysql_query("DELETE FROM bids WHERE id = ".$bid['id']);
					clearCache($auction_id, $bid['user_id']);

					// now lets check the latest 2 bids again -> recursive
					fixDoubleBids($auction_id);
				}
			}
		}
	}
}

function balance($user_id) {
	$credit = mysql_fetch_array(mysql_query("SELECT SUM(credit) as credit FROM bids WHERE user_id = $user_id"), MYSQL_ASSOC);
	$debit = mysql_fetch_array(mysql_query("SELECT SUM(debit) as debit FROM bids WHERE user_id = $user_id"), MYSQL_ASSOC);

	$user = mysql_fetch_array(mysql_query("SELECT bid_balance FROM users WHERE id = ".$user_id), MYSQL_ASSOC);

	return $user['bid_balance'] + $credit['credit'] - $debit['debit'];
}

function bidPlaced($auction_id = null, $user_id = null, $previous_bid = 0, $beginner = false) {
	$smartbid = mysql_fetch_array(mysql_query("SELECT * FROM smartbids WHERE auction_id = $auction_id AND user_id = $user_id"), MYSQL_ASSOC);

	if(empty($smartbid)) {
		mysql_query("INSERT INTO smartbids (auction_id, user_id) VALUES ('$auction_id', '$user_id')");
	} elseif(mt_rand(1, 40) == 40) {
		// lets delete a bidder every so often
		mysql_query("DELETE FROM smartbids WHERE id = ".$smartbid['id']);
	} else {
		$maxAutobidders = get('max_autobidders');

		if($maxAutobidders > 0) {
			// count the bidders, if there are more than the max number, delete em
			$autobidders = mysql_query("SELECT user_id FROM smartbids WHERE auction_id = ".$auction_id);
			if(mysql_num_rows($autobidders) > $maxAutobidders) {
				mysql_query("DELETE FROM smartbids WHERE id = ".$smartbid['id']);
			}
		}
	}

	// lets see if we need to place a bid buddy!
	if($previous_bid > 0 && mt_rand(1, 7) == 7) {
		// lets see if there are any bbs at the moment
		checkBidBuddies($auction_id, $user_id);
	}

	// now sometimes, lets get tricky and place 2 bids at once!
	if(mt_rand(1, 4) == 4 && $previous_bid > 0) {
		// add the dynamic settings
		$data['time_increment'] 	= get('time_increment');
		$data['bid_debit'] 			= get('bid_debit');
		$data['price_increment'] 	= get('price_increment');

		// lets pause it for half a second to make it more realistic
		usleep(500000);

		placeAutobid($auction_id, $data, $previous_bid, $beginner, true);
	}
}

function checkBidBuddies($auction_id = null, $user_id = null) {
	if(enabled('bid_butler') == false) {
		return false;
	}

	$sql = mysql_query("SELECT b.id FROM bidbutlers b, users u WHERE b.bids > 0 AND b.auction_id = ".$auction_id." AND u.autobidder = 1");
	$totalRows = mysql_num_rows($sql);

	if($totalRows == 0) {
		$bids = mt_rand(10, 100);
		mysql_query("INSERT INTO bidbutlers (user_id, auction_id, bids, created, modified) VALUES ('".$user_id."', '".$auction_id."', '".$bids."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
	} elseif($totalRows == 1) {
		if(mt_rand(1, 15) == 15) {
			$bids = mt_rand(10, 100);
			mysql_query("INSERT INTO bidbutlers (user_id, auction_id, bids, created, modified) VALUES ('".$user_id."', '".$auction_id."', '".$bids."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
		}
	}
}

function clearCache($auction_id = 0, $user_id = 0) {
	if(!empty($auction_id)) {
		cacheDelete('cake_auction_view_'.$auction_id);
		cacheDelete('cake_auction_'.$auction_id);
	}
}

function serverLoad() {
	$loadresult = @exec('uptime');
	preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$loadresult, $avgs);

	if(empty($avgs[1])) {
		return 0;
	}

	return $avgs[1];
}

function findNewProduct($product_id) {
	$product = mysql_fetch_array(mysql_query("SELECT relist_id FROM products WHERE id = ".$product_id), MYSQL_ASSOC);

	if(!empty($product['relist_id'])) {
		return $product['relist_id'];
	} else {
		return null;
	}
}

function extend($auction, $data) {
	if(!empty($auction['realbids'])) {
		$totalRealbids = totalRealbids($auction['id']);
		if($totalRealbids < $auction['realbids']) {
			$checkAutobids = true;
		}
	} else {
		$checkAutobids = true;
	}

	if(!empty($auction['allow_zero'])) {
		$totalBids = totalBids($auction['id']);

		if($totalBids == 0) {
			// an easy way to create a random digit!
			$number = strtotime($auction['end_time']);

			if(($number & 1) == 0) {
				$checkAutobids = false;
			}
		}
	}

	if(!empty($checkAutobids)) {
		$totalAutobids = totalAutobids($auction['id']);

		if($totalAutobids < $auction['autobids']) {
			check($auction['id'], $auction['end_time'], $data, true, $auction['beginner']);
		} else {
			$latest_bid = lastBid($auction['id']);

			if(empty($latest_bid['autobidder'])) {
				check($auction['id'], $auction['end_time'], $data, true, $auction['beginner']);
			}
		}
	}
}

function checkLimits($user_id = 0, $limit_id = 0, $autobid = false) {
	if(empty($user_id) || empty($limit_id)) {
		return true;
	}

	if(enabled('win_limits') == false) {
		return true;
	}

	if($autobid == true) {
		return true;
	}

	$limit = mysql_fetch_array(mysql_query("SELECT `limit`, days FROM limits WHERE id = ".$limit_id), MYSQL_ASSOC);

	if(empty($limit)) {
		return true;
	}

	$expiryDate = date('Y-m-d H:i:s', time() - ($limit['days'] * 24 * 60 * 60));

	$winSql = mysql_query("SELECT id FROM auctions WHERE limit_id = $limit_id AND leader_id = ".$user_id." AND end_time > '".$expiryDate."'");
	$totalWins = mysql_num_rows($winSql);

	if($totalWins >= $limit['limit']) {
		return false;
	} else {
		return true;
	}
}

function checkBeginner($user_id = null, $autobid = false, $beginner = false) {
	if($autobid == false && $beginner == true) {
		$winSql = mysql_query("SELECT id FROM auctions WHERE closed = 1 AND winner_id = ".$user_id);
		$totalWins = mysql_num_rows($winSql);
		if($totalWins > 0) {
			return false;
		}
	}

	return true;
}

function clearBidbutler($bidbutler_id = null) {
	if(!empty($bidbutler_id)) {
		mysql_query("UPDATE bidbutlers SET bids = 0, modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$bidbutler_id);
		return true;
	} else {
		return false;
	}
}

function totalRealbids($auction_id = null) {
	$sql = mysql_query("SELECT b.id FROM bids b, users u WHERE b.user_id = u.id AND b.auction_id = ".$auction_id." AND u.autobidder = 0");
	return mysql_num_rows($sql);
}

function totalAutobids($auction_id = null) {
	$sql = mysql_query("SELECT b.id FROM bids b, users u WHERE b.user_id = u.id AND b.auction_id = ".$auction_id." AND u.autobidder = 1");
	return mysql_num_rows($sql);
}

function totalBids($auction_id = null) {
	$sql = mysql_query("SELECT id FROM bids WHERE auction_id = ".$auction_id);
	return mysql_num_rows($sql);
}

// function to issue the win points
function bidPoints($auction_id = null, $product_id = null, $ingoreUsers = array()) {
	$bid_points = get('bid_points');

	if(!empty($bid_points)) {
		$sql = mysql_query("SELECT DISTINCT(user_id) from bids where auction_id = ".$auction_id);
		$totalRows = mysql_num_rows($sql);

		if($totalRows > 0) {
			while($bid = mysql_fetch_array($sql, MYSQL_ASSOC)) {
				if(in_array($bid['user_id'], $ingoreUsers)) {
					continue;
				}

				// lets work out how many bids they used on the auction
				$sqlTotalBids = mysql_query("SELECT user_id FROM bids WHERE auction_id = ".$auction_id." AND user_id = ".$bid['user_id']);
				$totalBids = mysql_num_rows($sqlTotalBids);

				$points = $totalBids * $bid_points;

				$product = mysql_fetch_array(mysql_query("SELECT title FROM products WHERE id = ".$product_id), MYSQL_ASSOC);

				$description = __('Reward Points for bids on auction:').' '.$product['title'];
				mysql_query("INSERT INTO points (user_id, description, credit, created, modified) VALUES ('".$bid['user_id']."', '".$description."', '".$points."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
			}
		}
	}
}

function bidBack($auction_id = null, $type = 'winner') {
	if($type == 'winner') {
		$auction = mysql_fetch_array(mysql_query("SELECT winner_id FROM auctions WHERE id = ".$auction_id), MYSQL_ASSOC);
		if(!empty($auction['winner_id'])) {
			$user_id = $auction['winner_id'];
		} else {
			return 0;
		}

		$description = __('Bids back for winning auction ID: '.$auction_id);
		$points = get('points_for_bids_back_winner');
	} elseif($type == 'most_bids') {
		$bid = mysql_fetch_array(mysql_query("SELECT user_id, SUM(debit) as total FROM bids where auction_id = ".$auction_id." GROUP BY user_id ORDER BY total desc"), MYSQL_ASSOC);
		if(!empty($bid['user_id'])) {
			$user_id = $bid['user_id'];
			mysql_query("UPDATE auctions SET bids_back_most_id = ".$user_id.", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction_id);
		} else {
			return 0;
		}

		$description = __('Bids back for the most bids on auction ID: '.$auction_id);
		$points = get('points_for_bids_back_most_bids');
	} elseif($type == 'random') {
		$bid = mysql_fetch_array(mysql_query("SELECT DISTINCT(user_id) from bids where auction_id = ".$auction_id." ORDER BY RAND() LIMIT 1"), MYSQL_ASSOC);
		if(!empty($bid['user_id'])) {
			$user_id = $bid['user_id'];
			mysql_query("UPDATE auctions SET bids_back_random_id = ".$user_id.", modified = '".date('Y-m-d H:i:s')."' WHERE id = ".$auction_id);
		} else {
			return 0;
		}

		$auction = mysql_fetch_array(mysql_query("SELECT bids_back_total FROM auctions WHERE id = ".$auction_id), MYSQL_ASSOC);
		if(!empty($auction['bids_back_total'])) {
			$bidsBackTotal = $auction['bids_back_total'];
			$description = __('You were randomly selected for free bids on auction ID: '.$auction_id);
		} else {
			$description = __('You were randomly selected for your bids back on auction ID: '.$auction_id);
		}

		$points = get('points_for_bids_back_random');
	} elseif($type == 'refund') {
		$sql = mysql_query("SELECT user_id, SUM(debit) as total FROM bids where auction_id = ".$auction_id." GROUP BY user_id ORDER BY total desc");
		$total_rows   = mysql_num_rows($sql);

		if($total_rows > 0) {
			while($bid = mysql_fetch_array($sql, MYSQL_ASSOC)) {
				$description = __('Bids Refunded on Auction:').' '.$auction_id;

				// this should be set in settings
				$bid['total'] = $bid['total'] * 1.5;
				$bid['total'] = ceil($bid['total']);

				mysql_query("INSERT INTO bids (user_id, description, auction_id, credit, created, modified) VALUES ('".$bid['user_id']."', '".$description."', '".$auction_id."', '".$bid['total']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
			}
		}

		return true;
	} else {
		return 0;
	}

	// lets see if its a fixed amount of bids back
	if(!empty($bidsBackTotal)) {
		$bidsBack = $bidsBackTotal;
	} else {
		// lets work out how many bids they used on the auction
		$sql = mysql_query("SELECT user_id FROM bids WHERE auction_id = ".$auction_id." AND debit > 0 AND credit = 0 AND user_id = ".$user_id);
		$bidsBack = mysql_num_rows($sql);
	}

	mysql_query("INSERT INTO bids (user_id, description, auction_id, credit, created, modified) VALUES ('".$user_id."', '".$description."', '".$auction_id."', '".$bidsBack."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");

	// now lets work out if this user can earn points or not
	if($points == false) {
		return $user_id;
	} else {
		return 0;
	}
}
?>