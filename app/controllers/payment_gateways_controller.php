<?php
class PaymentGatewaysController extends AppController{
    var $name = 'PaymentGateways';
    var $uses = array('Auction', 'Package', 'Bid', 'Setting', 'Account', 'Referral', 'Coupon', 'BuyItPackage');
	var $components = array('Cookie');

    function beforeFilter(){
        parent::beforeFilter();
        if(isset($this->Auth)){
            $this->Auth->allow('*');
        }
    }

    function _setAuctionStatus($auction_id, $status_id, $default_id) {
        if(!empty($auction_id)) {
            if(empty($status_id)) {
            	$status_id = $default_id;
            }

            $auction['Auction']['id']        = $auction_id;
            $auction['Auction']['status_id'] = $status_id;

            return $this->Auction->save($auction, false);
        } else {
            return false;
        }
    }

    function _setExchangeStatus($exchange_id, $status_id, $default_id) {
        if(!empty($exchange_id)) {
        	if(empty($status_id)) {
            	$status_id = $default_id;
            }

            $exchange['Exchange']['id']        = $exchange_id;
            $exchange['Exchange']['status_id'] = $status_id;

            return $this->Auction->Exchange->save($exchange, false);
        } else {
            return false;
        }
    }

    function _bids($user_id = null, $description = null, $credit = 0, $debit = 0) {
        if(!empty($user_id) && !empty($description)){
			$bid['Bid']['user_id']     = $user_id;
	        $bid['Bid']['description'] = $description;
	        $bid['Bid']['credit']      = $credit;
	        $bid['Bid']['debit']       = $debit;

	        $this->Bid->create();
			return $this->Bid->save($bid);
        } else {
            return false;
        }
    }

    function _points($user_id = null, $description = null, $credit = 0, $debit = 0) {
        if(!empty($user_id) && !empty($description)){
			$point['Point']['user_id']     = $user_id;
	        $point['Point']['description'] = $description;
	        $point['Point']['credit']      = $credit;
	        $point['Point']['debit']       = $debit;

	        $this->Bid->User->Point->create();
			return $this->Bid->User->Point->save($point);
        } else {
            return false;
        }
    }

    function _account($user_id = null, $name, $bids = 0, $price){
        if(!empty($user_id) && !empty($name)){
            $account['Account']['user_id'] = $user_id;
            $account['Account']['name']    = $name;
            $account['Account']['bids']    = $bids;
            $account['Account']['price']   = $price;

            $this->Account->create();
            return $this->Account->save($account);
        }else{
            return false;
        }
    }

    function _getAuction($auction_id, $user_id, $redirect = true){
        $auction = $this->Auction->find('first', array('conditions' => array('Auction.id' => $auction_id), 'contain' => 'Winner'));
		if(!empty($auction['Auction']['product_id'])) {
			$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $auction['Auction']['product_id']), 'contain' => ''));
			$auction['Product'] = $product['Product'];
		}

        if(!empty($auction)){
            // Check if logged user is the winner
            if($auction['Auction']['winner_id'] != $user_id){
                if($redirect){
                    $this->Session->setFlash(__('Invalid auction', true));
                    $this->redirect(array('controller' => 'auctions', 'action' => 'won'));
                }else{
                    return false;
                }
            }

            // Check auction status is not paid
            if($auction['Auction']['status_id'] != 1){
                if($redirect){
                    $this->Session->setFlash(__('You have already paid for this auction.', true));
                    $this->redirect(array('controller' => 'auctions', 'action' => 'won'));
                }else{
                    return false;
                }
            }

            // Get the total cost
            $total = 0;
            if(!empty($auction['Auction']['free'])) {
				$total = $auction['Product']['delivery_cost'];
            } elseif(!empty($auction['Product']['fixed'])) {
                $total = $auction['Product']['fixed_price'] + $auction['Product']['delivery_cost'];
            } else {
                $total = $auction['Auction']['price'] + $auction['Product']['delivery_cost'];
            }

            if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('redeemable_won_auctions')) {
				$credits = $this->Auction->Winner->Point->balance($this->Auth->user('id'));

				if($credits >= $this->Setting->get('redeemable_won_auctions')) {
					$total = $auction['Product']['delivery_cost'];
					$auction['Auction']['credits'] = $this->Setting->get('redeemable_won_auctions');
				} else {
					$auction['Auction']['credits'] = 0;
				}
			}

            $auction['Auction']['total'] = $total;
        }

        return $auction;
    }

    function _getPackage($id, $user_id = null, $key = 'id') {
        if(!empty($id)){
			// Set the user id in session for coupon
			// in package's afterFind()
			if(!empty($user_id)){

				// better to put it on PaymentGateway array than
				// Auth.User.id since it will open security hole
				$this->Session->write('PaymentGateway.user_id', $user_id);

				// Check validity of user's coupon
				if(Configure::read('App.coupons')){
					if($coupon = Cache::read('coupon_user_'.$user_id)){
						$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
					}
				}
			}

			$package = $this->Package->find('first', array('conditions' => array('Package.'.$key => $id)));

			return $package;
        }else{
            return false;
        }
    }
	/*
	Created by Andrew Buchan. Retrieve package info from BuyIt model
	*/
	function _getBuyItPackage($id, $user_id = null, $key = 'id')
	{
        if(!empty($id))
		{
			// Set the user id in session for coupon
			// in package's afterFind()
			if(!empty($user_id))
			{

				// better to put it on PaymentGateway array than
				// Auth.User.id since it will open security hole
				$this->Session->write('PaymentGateway.user_id', $user_id);

				// Check validity of user's coupon
				if(Configure::read('App.coupons')){
					if($coupon = Cache::read('coupon_user_'.$user_id)){
						$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
					}
				}
			}

			$package = $this->BuyItPackage->find('first', array('conditions' => array('BuyItPackage.'.$key => $id)));

			return $package;
        }
		else
		{
            return false;
        }
	}

    function _isAddressCompleted($user_id = null){
        if(empty($user_id)){
            $user_id = $this->Auth->user('id');
        }

        return $this->Auction->Winner->Address->isCompleted($user_id);
    }

    /**
     * Check if this is user first won auction
     */
    function _firstWin($user_id = null){
        if(empty($user_id)){
            $user_id = $this->Auth->user('id');
        }

        $won = $this->Auction->find('count', array('conditions' => array('Auction.winner_id' => $user_id)));
        if($won < 2) {
            $credit = $this->Setting->get('free_won_auction_bids');
			if(!empty($credit) && $credit > 0){
				$description = __('Free bids given for winning your first auction.', true);
				$this->_bids($user_id, $description, $credit, 0);
			}
        }else{
            return false;
        }
    }

    /**
     * Check if this is user first bid package purchase
     */
    function _checkFirstPurchase($user_id = null, $bids = null){
        if(!empty($user_id)){
            $purchasedBefore = $this->User->Account->find('first', array('conditions' => array('Account.user_id' => $user_id, 'Account.bids >' => 0)));
            if(empty($purchasedBefore)) {
                // Get the setting
                $setting = $this->Setting->get('free_bid_packages_bids');

				if(!empty($setting)) {
					// If setting for free bids is not 0
					if((is_numeric($setting)) && $setting > 0) {
						$credit = $setting;
					} elseif(substr($setting, -1) == '%' && is_numeric(substr($setting, 0, -1))) {
						$credit = $bids * (substr($setting, 0, -1) / 100);
					}

					$description = __('Free bids given for purchasing bids for the first time.', true);
					$this->_bids($user_id, $description, $credit, 0);
				} else {
					 return false;
				}
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check if user referred by another user
     */
    function _checkReferral($user_id = null){
        $referral = $this->Referral->find('first', array('conditions' => array('Referral.user_id' => $user_id, 'Referral.purchased' => 0), 'fields' => array('Referral.id', 'Referral.referrer_id'), 'contain' => 'User.username'));

		if(!empty($referral)) {
			$referral['Referral']['purchased'] = true;
			$this->User->Referral->save($referral);

	        $setting = $this->Setting->get('free_purchase_bids');
	        if(!empty($setting)) {
				$description = __('Referral bids earned for bid purchase:', true).' '.$referral['User']['username'];
				$this->_bids($referral['Referral']['referrer_id'], $description, $setting, 0);
			}


	        // lets check for reward points also!
			if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('referral_points')) {
				$setting = $this->Setting->get('referral_points');
				if((is_numeric($setting)) && $setting > 0) {
					$this->_points($referral['Referral']['referrer_id'], __('Referral points earned for bid purchase:', true).' '.$referral['User']['username'], $setting);
				}
			}
		}
    }

    function _confirmationEmail($user_id = null, $packageName = null) {
        $user = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => ''));

        $data['template'] = 'users/package';
        $data['layout']   = 'default';

        $data['to'] 	  = $user['User']['email'];

        $data['subject']  = 'Bid Package Purchased';
        $data['User']	  = $user['User'];

        $this->set('data', $data);
        $this->set('packageName', $packageName);

		// not using this atm.  If it is to be used, it will need to be updated to multi language

        if($this->_sendEmail($data)){
            return true;
        }else{
            return false;
        }
    }

    function _processAuction($id = null, $user_id = null) {
		$auction = $this->_getAuction($id, $user_id, false, false);

		// Check the first winners bonus
		$this->_firstWin($user_id, $id);

		if(!empty($auction['Product']['bids'])) {
			$description = __('Free bids given for auction:', true).' '.$auction['Product']['title'];
			$this->_bids($user_id, $description, $auction['Product']['bids'], 0);

			$status = $this->_setAuctionStatus($id, $auction['Product']['status_id'], 3);
		} else {
			$status = $this->_setAuctionStatus($id, $auction['Product']['status_id'], 2);
		}

		if($this->Setting->Module->enabled('reward_points') && !empty($auction['Auction']['credits'])) {
			$this->_points($user_id, __('Points redeemed for won auction:', true).' '.$auction['Product']['title'], 0, $auction['Auction']['credits']);
		}

		if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('win_points') && !empty($auction['Product']['win_points'])) {
			$this->_points($user_id, __('Reward Points for winning auction:', true).' '.$auction['Product']['title'], $auction['Product']['win_points'], 0);
		}
    }

    function _processPackage($id = null, $user_id = null, $quantity = 1) {
    	$package = $this->_getPackage($id, $user_id);

		// Adding bids
		if($quantity > 1) {
			$description 	= $quantity.__(' x Bids purchased - package name:', true).' '.$package['Package']['name'];
		} else {
			$description 	= __('Bids purchased - package name:', true).' '.$package['Package']['name'];
		}

		$credit      = $package['Package']['bids'];
		$this->_bids($user_id, $description, $credit, 0);

		if($this->Setting->Module->enabled('reward_points') && !empty($package['Package']['points'])) {
			$this->_points($user_id, $description, $package['Package']['points'], 0);
		}

		// Updating account
		$name  = __('Bids purchased - package name:', true).' '.$package['Package']['name'];
		$bids  = $package['Package']['bids'];
		$price = $package['Package']['price'];

		$this->_account($user_id, $name, $bids, $price);

		// Add bonus if it's user first purchase
		$this->_checkFirstPurchase($user_id, $bids);

		// Checking referral bonus
		$this->_checkReferral($user_id);
    }

    function _processExchange($id = null, $user_id = null) {
		$exchange   = $this->Auction->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $user_id), 'contain' => 'Auction'));

		if(!empty($exchange['Auction']['product_id'])) {
			$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
			$exchange['Auction']['Product'] = $product['Product'];
		}

		if(!empty($exchange)) {
			if(!empty($exchange['Auction']['Product']['bids'])) {
				$description = __('Free bids given for auction:', true).' '.$exchange['Auction']['Product']['title'];
				$this->_bids($user_id, $description, $exchange['Auction']['Product']['bids'], 0);

				$status = $this->_setExchangeStatus($id, $exchange['Auction']['Product']['status_id'], 3);
			} else {
				$status = $this->_setExchangeStatus($id, $exchange['Auction']['Product']['status_id'], 2);
			}
			return true;
		} else {
			return false;
		}
    }

	function returning($model = 'package') {
		if($model == 'exchange') {
			$this->Session->setFlash(__('Your payment has been approved and your purchased product will be shipped shortly.', true), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
		} elseif($model == 'auction') {
			$this->Session->setFlash(__('Your payment has been approved and your won auction status has been updated.', true), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
		} else {
			$this->Session->setFlash(__('Your payment has been approved and your bids should now be available for you to use.  If they do not appear in a few minutes please contact us.', true), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'bids', 'action' => 'index', true));
		}
	}

	function credits($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
		}

		$user_id = $this->Auth->user('id');
		$auction = $this->_getAuction($id, $user_id, false);

		if($this->Setting->Module->enabled('reward_points') && $this->Setting->get('redeemable_won_auctions')) {
			if($auction['Auction']['total'] > 0) {
				$this->Session->setFlash(__('Invalid Auction.', true));
				$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
			}
		} elseif($auction['Auction']['total'] > 0) {
			$this->Session->setFlash(__('Invalid Auction.', true));
			$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
		}

		$this->_processAuction($id, $user_id);

		if($auction['Auction']['payment'] == 'Bid Credits') {
			$description = __('Bids Credit(s) for auction:', true).' '.$auction['Product']['title'];

			$bidValue = $this->requestAction('/settings/get/bid_value');
			$bids = round($auction['Auction']['total'] * -100 * $bidValue);

			$this->_bids($user_id, $description, $bids, 0);
		}

		$this->Session->setFlash(__('Your won auction has been confirmed.', true), 'default', array('class' => 'success'));
		$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
    }

	function demo($model = 'package', $id = null) {
		if(!$this->Setting->get('demo_gateway')) {
			$this->Session->setFlash(__('Invalid Gateway.', true));
			$this->redirect($this->referer(array('controller' => 'packages', 'action'=>'won')));
		}

		$user_id = $this->Auth->user('id');

		if(!empty($user_id)) {
			switch($model){
				case 'package':
					if(!empty($id)) {
						$this->_processPackage($id, $user_id);

						$this->Session->setFlash(__('You have successfully paid for your package!', true), 'default', array('class' => 'success'));
						$this->redirect(array('controller' => 'bids', 'action'=>'index'));
					} else {
						$this->Session->setFlash(__('Invalid Package.', true));
						$this->redirect(array('controller' => 'packages', 'action'=>'index'));
					}
					break;
				case 'auction':
					if(empty($id)) {
						$this->Session->setFlash(__('Invalid Auction.', true));
						$this->redirect(array('controller' => 'auctions', 'action'=>'won'));
					}

					$this->_processAuction($id, $user_id);

					$this->Session->setFlash(__('You have successfully paid for your won auction!', true), 'default', array('class' => 'success'));
					$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
					break;
				case 'exchange':
					if(empty($id)) {
						$this->Session->setFlash(__('Invalid Auction.', true));
						$this->redirect(array('controller' => 'exchanges', 'action'=>'index'));
					}

					$this->_processExchange($id, $user_id);

					$this->Session->setFlash(__('You have successfully paid for your purchased auction!', true), 'default', array('class' => 'success'));
					$this->redirect(array('controller' => 'exchanges', 'action'=>'index'));
					break;
				default:
					$this->Session->setFlash(__('Invalid Model', true));
					$this->redirect('/');
			}
		} else {
			$this->Session->setFlash(__('Invalid Model', true));
			$this->redirect('/');
		}
    }

    function dalpay($model = null, $id = null){
		if(!$this->Setting->get('dalpay')) {
			$this->Session->setFlash(__('Dalpay not Active.', true));
            $this->redirect($this->referer(array('controller' => 'packages', 'action'=>'index')));
		}

		$gateway['url']  = $this->Setting->get('dalpay_url');

		$dalpay  = array();

		if(!empty($model)){
			$dalpay['mer_id']  = $this->Setting->get('dalpay_merchant_id');

			$dalpay['num_items'] = 1;
			$dalpay['item1_qty'] = 1;
			$dalpay['valuta_code'] = $this->appConfigurations['currency'];
			$dalpay['user1'] = $this->Auth->user('id');

			// lets see if this user has an address
			$address = $this->_isAddressCompleted($this->Auth->user('id'));

			if(!empty($address[1])) {
				$dalpay['cust_country'] = $address[1]['country_name'];
				$dalpay['cust_name'] = $address[1]['name'];
				$dalpay['cust_address1'] = $address[1]['address_1'].' '.$address[1]['address_2'];
				if(empty($address[1]['postcode'])) {
					$address[1]['postcode'] = 99999;
				}
				$dalpay['cust_zip'] = $address[1]['postcode'];
				$dalpay['cust_city'] = $address[1]['suburb'];
				$dalpay['cust_state'] = $address[1]['city'];
				$dalpay['cust_email'] = $this->Auth->user('email');
				$dalpay['cust_phone'] = $address[1]['phone'];
				}

			if(!empty($address[2])) {
				$dalpay['info1'] = $address[2]['name'];
				$dalpay['info1'] .= "\n".$address[2]['address_1'];
				if(!empty($address[2]['address_2'])) {
					$dalpay['info1'] .= "\n".$address[2]['address_2'];
				}
				if(!empty($address[2]['suburb'])) {
					$dalpay['info1'] .= "\n".$address[2]['suburb'];
				}
				$dalpay['info1'] .= "\n".$address[2]['city'].' '.$address[2]['postcode'];
				$dalpay['info1'] .= "\n".$address[2]['country_name'];
			}

			switch($model){
                case 'package':
                    $dalpay['mer_url_idx']	= $this->Setting->get('dalpay_package_order_page');

                    $package   = $this->_getPackage($id);

                    // Formating the data
					$dalpay['item1_desc'] = $package['Package']['name'];
					$dalpay['item1_price'] = $package['Package']['price'];
					$dalpay['user2'] = $package['Package']['id'];

                    break;
                case 'auction':
                    $dalpay['mer_url_idx']	= $this->Setting->get('dalpay_auction_order_page');

                    $auction   = $this->_getAuction($id, $this->Auth->user('id'), true, false);
                    $user      = $auction['Winner'];

                    // Formating the data
					$dalpay['item1_desc'] 	= $auction['Product']['title'];
					$dalpay['item1_price'] 	= $auction['Auction']['total'];
					$dalpay['user2'] 		= $auction['Auction']['id'];
                break;

                case 'exchange':
                    $dalpay['mer_url_idx']	= $this->Setting->get('dalpay_package_order_page');

                    $exchange   = $this->Auction->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $this->Auth->user('id')), 'contain' => array('Auction', 'User')));

					if(empty($exchange)) {
						$this->Session->setFlash(__('Invalid buy now', true));
                    	$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
					}

					if(!empty($exchange['Auction']['product_id'])) {
						$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
						$exchange['Auction']['Product'] = $product['Product'];
                    }

                    $addresses = $this->_isAddressCompleted();
                    $user      = $exchange['User'];

					// Formating the data
					$dalpay['item1_desc'] 	= $exchange['Auction']['Product']['title'];
					$dalpay['item1_price'] 	= $exchange['Exchange']['price'] + $exchange['Auction']['Product']['delivery_cost'];
					$dalpay['user2']		= $exchange['Exchange']['id'];
                    break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }

			$this->set('dalpay', $dalpay);
			$this->set('gateway', $gateway);
		}else{
			$this->Session->setFlash(__('Invalid payment gateway', true));
		}
    }

    function dalpay_ipn($model = 'package'){
		$this->layout = 'ajax';

		$user_id 	= !empty($_POST['user1']) ? $_POST['user1'] : null;
		$id      	= !empty($_POST['user2']) ? $_POST['user2'] : null;

		if(!empty($user_id)) {
			switch($model){
				case 'auction':
					if(!empty($id)) {
						$this->_processAuction($id, $user_id);
					} else {
						$message = sprintf('Dalpay IPN : There is no id for %s or user id in posted data. I need both of them!', $model);
						$this->log($message);
					}
					break;
				case 'exchange':
					if(!empty($id)) {
						$this->_processExchange($id, $user_id);
					} else {
						$message = sprintf('Dalpay IPN : There is no id for %s or user id in posted data. I need both of them!', $model);
						$this->log($message);
					}
					break;
				case 'package':
					if(!empty($id)) {
						$this->_processPackage($id, $user_id);
					} else {
						$message = sprintf('Dalpay IPN : There is no id for %s or user id in posted data. I need both of them!', $model);
						$this->log($message);
					}
					break;
					default:
					$message = 'Dalpay IPN : Invalid model';
					$this->log($message);
				}

		} else {
			$message = sprintf('Dalpay IPN : There is no id for %s or user id in posted data. I need both of them!', $model);
			$this->log($message);
		}
	}

	function paypal($model = null, $id = null){
		if(!$this->Setting->get('paypal')) {
			$this->Session->setFlash(__('Paypal not Active.', true));
            $this->redirect($this->referer(array('controller' => 'packages', 'action'=>'index')));
		}

		$gateway['url'] = $this->Setting->get('paypal_url');
		$gateway['email'] = $this->Setting->get('paypal_email');
		$gateway['lc'] = $this->Setting->get('paypal_locale');

		$paypal  = array();

		if(!empty($model)){
			$paypal['cancel_return'] = Configure::read('App.url') . '/users';
			$paypal['notify_url']    = Configure::read('App.url') . '/payment_gateways/paypal_ipn';
			$paypal['url'] 	  	     = $gateway['url'];
			$paypal['business']      = $gateway['email'];
			$paypal['lc'] 	 	     = $gateway['lc'];
			$paypal['currency_code'] = Configure::read('App.currency');
			$paypal['custom']		 = $model . '#' . $id . '#' . $this->Auth->user('id');
			$paypal['first_name']  	 = $this->Auth->user('first_name');
			$paypal['last_name']     = $this->Auth->user('last_name');
			$paypal['email']         = $this->Auth->user('email');

			$addresses = $this->_isAddressCompleted();
			if(!empty($addresses)) {
				$paypal['address1']    = $addresses[1]['address_1'];
				$paypal['address2']    = $addresses[1]['address_2'];
				$paypal['city']    	   = $addresses[1]['city'];
				$paypal['zip']    	   = $addresses[1]['postcode'];
			}

			switch($model){
                case 'auction':
                    $auction   = $this->_getAuction($id, $this->Auth->user('id'), true, false);

                    $user      = $auction['Winner'];

					// Formating the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/auction';
					$paypal['item_name']   = $auction['Product']['title'];
					$paypal['item_number'] = $auction['Auction']['id'];
					$paypal['amount']      = $auction['Auction']['total'];

                    break;
                 case 'exchange':
                    $exchange   = $this->Auction->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $this->Auth->user('id')), 'contain' => array('Auction', 'User')));

					if(empty($exchange)) {
						$this->Session->setFlash(__('Invalid product', true));
                    	$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
					}

					if(!empty($exchange['Auction']['product_id'])) {
						$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
						$exchange['Auction']['Product'] = $product['Product'];
                    }

                    $addresses = $this->_isAddressCompleted();
                    $user      = $exchange['User'];

					// Formating the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/exchange';
					$paypal['item_name']   = $exchange['Auction']['Product']['title'];
					$paypal['item_number'] = $exchange['Exchange']['id'];
					$paypal['amount']      = $exchange['Exchange']['price'] + $exchange['Auction']['Product']['delivery_cost'];

                    break;
                case 'package':
                    $package   = $this->_getPackage($id);

                    // Formating the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/package';
					$paypal['item_name']   = $package['Package']['name'];
					$paypal['item_number'] = $package['Package']['id'];
					$paypal['amount']      = number_format($package['Package']['price'], 2);

                    break;
				case 'buyitpackage':
					$package = $this->_getBuyItPackage($id);
					// Formatting the data
					$paypal['return'] 	     = Configure::read('App.url') . '/payment_gateways/returning/package';
					$paypal['item_name']   = $package['BuyItPackage']['name'];
					$paypal['item_number'] = $package['BuyItPackage']['id'];
					$paypal['amount']      = number_format($package['BuyItPackage']['price'], 2);
					break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }

			$this->Paypal->configure($paypal);
			$paypalData = $this->Paypal->getFormData();
			// echo '<pre>';
			// print_r($paypalData);
			// exit;
			$this->set('paypalData', $paypalData);
		}else{
			$this->Session->setFlash(__('Invalid payment gateway', true));
		}
    }

    function paypal_ipn(){
		$gateway['url'] = $this->Setting->get('paypal_url');
		$gateway['email'] = $this->Setting->get('paypal_email');
		$gateway['lc'] = $this->Setting->get('paypal_locale');

		$this->Paypal->configure($gateway);
		if($this->Paypal->validate_ipn()) {

			if(strtolower($this->Paypal->ipn_data['payment_status']) == 'completed' || strtolower($this->Paypal->ipn_data['payment_status']) == 'pending') {
				// Read the info
				$control = explode('#', $this->Paypal->ipn_data['custom']);

				$model    = !empty($control[0]) ? $control[0] : null;
				$id       = !empty($control[1]) ? $control[1] : null;
				$user_id  = !empty($control[2]) ? $control[2] : null;

				switch($model){
					case 'auction':
						$this->_processAuction($id, $user_id);
						break;
					case 'exchange':
						$this->_processExchange($id, $user_id);
						break;
					case 'package':
						if(strtolower($this->Paypal->ipn_data['payment_status']) == 'completed') {
							$this->_processPackage($id, $user_id);
						}
						break;
				}
			}
		}else{
			$this->log('ipn validation failed.');
		}
    }

    function bank($model = null, $id = null){
		if(!$this->Setting->get('bank_transfer')) {
			$this->Session->setFlash(__('Bank Transfer not Active.', true));
            $this->redirect($this->referer(array('controller' => 'packages', 'action'=>'index')));
		}

		if(!empty($model)) {
			switch($model) {
                case 'auction':
                    $auction   = $this->_getAuction($id, $this->Auth->user('id'), true, false);

                    $user      = $auction['Winner'];

                    break;
                 case 'exchange':
                    $exchange   = $this->Auction->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $this->Auth->user('id')), 'contain' => array('Auction', 'User')));

					if(empty($exchange)) {
						$this->Session->setFlash(__('Invalid product', true));
                    	$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
					}

					if(!empty($exchange['Auction']['product_id'])) {
						$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
						$exchange['Auction']['Product'] = $product['Product'];
                    }

                    $addresses = $this->_isAddressCompleted();
                    $user      = $exchange['User'];

                    break;
                case 'package':
                    $package   = $this->_getPackage($id);
					$this->set('package', $package);

                    break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }

            $this->set('model', $model);
		}else{
			$this->Session->setFlash(__('Invalid payment gateway', true));
		}
    }

    function easypay($model = null, $id = null, $method = 'creditcard') {
		switch($model){
                case 'auction':
                    $auction   = $this->_getAuction($id, $this->Auth->user('id'), true, false);
                    $user      = $auction['Winner'];

					if($auction['Auction']['total'] < 0.5) {
						$auction['Auction']['total'] = 0.5;
					}

					//$url = 'http://test.easypay.pt/_s/api_easypay_01BG.php?ep_cin=8050&ep_user=CASTSOMBRAS&ep_entity=10611&ep_ref_type=auto&t_key='.$model.'|'.$user['id'].'|'.$auction['Auction']['id'].'&t_value='.$auction['Auction']['total'].'&ep_country=PT&ep_language=PT';
					$url = 'https://www.easypay.pt/_s/api_easypay_01BG.php?ep_cin=2199&ep_user=CAST301111&ep_entity=10611&&ep_ref_type=auto&t_key='.$model.'|'.$user['id'].'|'.$auction['Auction']['id'].'&t_value='.$auction['Auction']['total'].'&ep_country=PT&ep_language=PT';
					$ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL, $url);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			        $output = curl_exec($ch);
			        curl_close($ch);

					$xml = simplexml_load_string($output);
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);

					if($method == 'creditcard') {
						if(!empty($array['ep_link'])) {
							$this->redirect($array['ep_link']);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/auctions/won');
						}
					} elseif($method == 'mb') {
						if($array['ep_value'] > 0) {
							$this->set('easypay', $array);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/auctions/won');
						}
					}

                    break;
                 case 'exchange':
                    $exchange   = $this->Auction->Exchange->find('first', array('conditions' => array('Exchange.id' => $id, 'Exchange.user_id' => $this->Auth->user('id')), 'contain' => array('Auction', 'User')));

					if(empty($exchange)) {
						$this->Session->setFlash(__('Invalid product', true));
                    	$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
					}

					if(!empty($exchange['Auction']['product_id'])) {
						$product = $this->Auction->Product->find('first', array('conditions' => array('Product.id' => $exchange['Auction']['product_id']), 'contain' => ''));
						$exchange['Auction']['Product'] = $product['Product'];
                    }

                    $addresses = $this->_isAddressCompleted();
                    $user      = $exchange['User'];

					$total = $exchange['Exchange']['price'] + $exchange['Auction']['Product']['delivery_cost'];

					//$url = 'http://test.easypay.pt/_s/api_easypay_01BG.php?ep_cin=8050&ep_user=CASTSOMBRAS&ep_entity=10611&ep_ref_type=auto&t_key='.$model.'|'.$exchange['User']['id'].'|'.$exchange['Exchange']['id'].'&t_value='.$total.'&ep_country=PT&ep_language=PT';
					$url = 'https://www.easypay.pt/_s/api_easypay_01BG.php?ep_cin=2199&ep_user=CAST301111&ep_entity=10611&ep_ref_type=auto&t_key='.$model.'|'.$exchange['User']['id'].'|'.$exchange['Exchange']['id'].'&t_value='.$total.'&ep_country=PT&ep_language=PT';
					$ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL, $url);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			        $output = curl_exec($ch);
			        curl_close($ch);

					$xml = simplexml_load_string($output);
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);

					if($method == 'creditcard') {
						if(!empty($array['ep_link'])) {
							$this->redirect($array['ep_link']);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/exchanges');
						}
					} elseif($method == 'mb') {
						if($array['ep_value'] > 0) {
							$this->set('easypay', $array);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/exchanges');
						}
					}


                    break;
                case 'package':
                    $package   = $this->_getPackage($id);

					$url = 'https://www.easypay.pt/_s/api_easypay_01BG.php?ep_cin=2199&ep_user=CAST301111&ep_entity=10611&ep_ref_type=auto&t_key='.$model.'|'.$this->Auth->user('id').'|'.$package['Package']['id'].'&t_value='.$package['Package']['price'].'&ep_country=PT&ep_language=PT';
					//$url = 'http://test.easypay.pt/_s/api_easypay_01BG.php?ep_cin=8050&ep_user=CASTSOMBRAS&ep_entity=10611&ep_ref_type=auto&t_key='.$model.'|'.$this->Auth->user('id').'|'.$package['Package']['id'].'&t_value='.$package['Package']['price'].'&ep_country=PT&ep_language=PT';

					$ch = curl_init();
			        curl_setopt($ch, CURLOPT_URL, $url);
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			        $output = curl_exec($ch);
			        curl_close($ch);

					$xml = simplexml_load_string($output);
					$json = json_encode($xml);
					$array = json_decode($json,TRUE);

					if($method == 'creditcard') {
						if(!empty($array['ep_link'])) {
							$this->redirect($array['ep_link']);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/packages');
						}
					} elseif($method == 'mb') {
						if($array['ep_value'] > 0) {
							$this->set('easypay', $array);
						} else {
							$this->Session->setFlash(__('There was a problem, please try again!', true));
                    		$this->redirect('/packages');
						}
					}

                    break;
                default:
                    $this->Session->setFlash(sprintf(__('There is no handler for %s in this payment gateway.', true), $model));
                    $this->redirect('/');
            }
    }

    function easypay_ipn($method = 'mb') {
    	/* Dump the following SQL when using this
    	 *
    	 * CREATE TABLE `easypay_autoMB_key` (
		`ep_key` int(11) NOT NULL auto_increment,
		`ep_doc` varchar(50) default NULL,
		`ep_cin` varchar(20) default NULL,
		`ep_user` varchar(20) default NULL,
		`ep_date_stamp` timestamp NULL default CURRENT_TIMESTAMP,
		`ep_status` varchar(20) default 'pending',
		`ep_entity` varchar(10) default NULL,
		`ep_reference` varchar(9) default NULL,
		`ep_value` double default NULL,
		`ep_payment_type` varchar(6) default NULL,
		`ep_value_fixed` double default NULL,
		`ep_value_var` double default NULL,
		`ep_value_tax` double default NULL,
		`ep_value_transf` double default NULL,
		`ep_date_transf` date default NULL,
		`ep_date_read` date default NULL,
		`ep_status_read` varchar(20) default NULL,
		`ep_invoice_number` varchar(30) default NULL,
		`ep_transf_number` varchar(20) default NULL,
		PRIMARY KEY (`ep_key`),
		UNIQUE KEY `ep_doc` (`ep_doc`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    	 */


		if($method == 'creditcard') {
			if(!empty($_GET['e']) && !empty($_GET['r']) && !empty($_GET['v']) && !empty($_GET['k'])) {
				$url = 'https://www.easypay.pt/_s/api_easypay_05AG.php?e='.$_GET['e'].'&r='.$_GET['r'].'&v='.$_GET['v'].'&k='.$_GET['k'];
				//$url = 'http://test.easypay.pt/_s/api_easypay_05AG.php?e='.$_GET['e'].'&r='.$_GET['r'].'&v='.$_GET['v'].'&k='.$_GET['k'];

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);
				curl_close($ch);

				$xml = simplexml_load_string($output);
				$json = json_encode($xml);
				$array = json_decode($json, true);

				if(!empty($array['ep_key'])) {
		    		$key = explode('|', $_GET['t_key']);

		    		$model    = $key[0];
					$user_id  = $key[1];
					$id       = $key[2];

					switch($model){
						case 'auction':
							$this->_processAuction($id, $user_id);
							$this->Session->setFlash(__('The auction was successfully paid for.', true), 'default', array('class' => 'success'));
							$this->redirect(array('controller' => 'auctions', 'action' => 'won'));
							break;
						case 'exchange':
							$this->_processExchange($id, $user_id);
							$this->Session->setFlash(__('The buy now was successfully paid for.', true), 'default', array('class' => 'success'));
							$this->redirect(array('controller' => 'exchanges', 'action' => 'index'));
							break;
						case 'package':
							$this->_processPackage($id, $user_id);

							$this->Session->setFlash(__('The bids were successfully credited.', true), 'default', array('class' => 'success'));
							$this->redirect(array('controller' => 'bids', 'action' => 'index', true));
							break;
					}
	    		} else {
					$this->Session->setFlash(__('Your credit card details were incorrect, please try again.', true));
					$this->redirect(array('controller' => 'packages', 'action' => 'index'));
	    		}
			} else {
				$this->Session->setFlash(__('Your credit card details were incorrect, please try again.', true));
				$this->redirect(array('controller' => 'packages', 'action' => 'index'));
			}
		} else {
			$this->layout = false;

	    	if(!empty($_GET['ep_cin']) && !empty($_GET['ep_user']) && !empty($_GET['ep_doc'])) {

				$this->User->query("INSERT INTO easypay_autoMB_key (ep_cin, ep_user, ep_doc) VALUES ('".$_GET['ep_cin']."', '".$_GET['ep_user']."', '".$_GET['ep_doc']."')");

				$id = mysql_insert_id();
				$this->set('ep_key', $id);

				$this->set('ep_cin', $_GET['ep_cin']);
				$this->set('ep_user', $_GET['ep_user']);
				$this->set('ep_doc', $_GET['ep_doc']);
	    	} else {
	    		$this->log('Easypay - GET details missing');
	    	}
		}
    }

    function easypay_cron() {
    	$data = $this->User->query("SELECT * FROM easypay_autoMB_key WHERE ep_status = 'pending'");
    	if(!empty($data)){
    		foreach ($data as $easypay) {
				$url = 'https://www.easypay.pt/_s/api_easypay_03AG.php?ep_cin=2199&ep_user=CAST301111&ep_key='.$easypay['easypay_autoMB_key']['ep_key'].'&ep_doc='.$easypay['easypay_autoMB_key']['ep_doc'];
				//$url = 'http://test.easypay.pt/_s/api_easypay_03AG.php?ep_cin=8050&ep_user=CASTSOMBRAS&ep_key='.$easypay['easypay_autoMB_key']['ep_key'].'&ep_doc='.$easypay['easypay_autoMB_key']['ep_doc'];

				$ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $url);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    $output = curl_exec($ch);
			    curl_close($ch);

				$xml = simplexml_load_string($output);
				$json = json_encode($xml);
				$array = json_decode($json, true);

			   	if(!empty($array['t_key'])) {
		    		if($array['ep_payment_type'] == 'MB') {
			    		$key = explode('|', $array['t_key']);

			    		$model    = $key[0];
						$user_id  = $key[1];
						$id       = $key[2];

						switch($model){
							case 'auction':
								$this->_processAuction($id, $user_id);
								break;
							case 'exchange':
								$this->_processExchange($id, $user_id);
								break;
							case 'package':
								$this->_processPackage($id, $user_id);
								break;
						}
		    		}

					// now lets update the status!
					$this->User->query("update easypay_autoMB_key SET ep_status = '".$array['ep_status']."', ep_entity = '".$array['ep_entity']."', ep_reference = '".$array['ep_reference']."', ep_value = '".$array['ep_value']."', ep_payment_type = '".$array['ep_payment_type']."', ep_value_fixed = '".$array['ep_value_fixed']."', ep_value_var = '".$array['ep_value_var']."', ep_value_tax = '".$array['ep_value_tax']."', ep_value_transf = '".$array['ep_value_transf']."', ep_date_transf = '".$array['ep_date_transf']."', ep_date_read = '".$array['ep_date_read']."', ep_status_read = '".$array['ep_status_read']."' WHERE ep_key = ".$easypay['easypay_autoMB_key']['ep_key']);
	    		}
    		}
    	}
    }

    function admin_add($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Bid->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => ''));
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		if(!empty($this->data)) {
			if(empty($this->data['Package']['package_id'])) {
				$this->Session->setFlash(__('Please select a package.', true));
				$this->redirect(array('action' => 'add', $user_id));
			}

			$id = $this->data['Package']['package_id'];
			$this->_processPackage($id, $user_id);

			$this->Session->setFlash(__('The bids were successfully credited.', true), 'default', array('class' => 'success'));
			$this->redirect(array('controller' => 'bids', 'action' => 'user', $user_id));
		}

		$this->set('user', $user);
		$this->set('packages', $this->Package->find('list', array('order' => array('Package.price' => 'asc'))));
    }
}
?>