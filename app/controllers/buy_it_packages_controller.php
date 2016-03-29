<?php
class BuyItPackagesController extends AppController {

		var $name = 'BuyItPackages';
		
		var $uses = array('BuyItPackage', 'User', 'Auction', 'Setting', 'Coupon');
		
		function beforeFilter(){
			parent::beforeFilter();

			if(isset($this->Auth)){
				$this->Auth->allow('admin_index', 'index', 'add');
			}

			if($this->Setting->Module->enabled('coupons')) {
				if($coupon = Cache::read('coupon_user_'.$this->Auth->user('id'))){
					$coupon = $this->Coupon->findByCode(strtoupper($coupon['Coupon']['code']));
					if(empty($coupon)){
						Cache::delete('coupon_user_'.$this->Auth->user('id'));
						$this->Session->setFlash(__('The coupon you applied no longer exists. Please enter another coupon.', true));
						$this->redirect(array('controller' => 'packages', 'action' => 'index'));
					}
				}
			}
		}
		
		function admin_index()
		{
			$this->paginate = array('contain' => array('User', 'Auction' => array('Bid')), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('created' => 'desc'));
			$this->set('packages', $this->paginate());
		}
		
		function index()
		{
		
			$buyItProducts = $this->BuyItPackage->find('all', array('contain' => '', 'conditions' => array('user_id' => $this->Auth->user('id'))));
			
			$this->set('buyitproducts', $buyItProducts);
		
		}
		
		function add($user_id = null, $auction_id = null)
		{
		
			$this->BuyItPackage->create();
			
			// Get SUM of all bids made by the user on this auction
			$bidCount = $this->Auction->Bid->find('all', array('contain' => '', 'conditions' => array('auction_id' => $auction_id, 'user_id' => $this->Auth->user('id')), 'fields' => array('SUM(debit) as sumofbids'), 'group' => 'auction_id'));

			// Get this auction's details
			$auction = $this->Auction->getAuctions(array('Auction.id' => $auction_id), 1, null, null, 'max');
			
			if($auction)
			{
			
				$buyItReductionAmount = $auction['Auction']['buy_it_reduction_amount'];
				
				// Only continue if buy_it is enabled on this auction
				$buyIt = $auction['Auction']['buy_it'];
				if($buyIt == 1)
				{
				
					if(isset($bidCount[0][0]['sumofbids']))
					{
					
						$bidsSum = $bidCount[0][0]['sumofbids'];
						$total = $buyItReductionAmount * $bidsSum;
						$buyItPrice = $auction['Product']['rrp'] - $total;
						
						// Check row does not exist for this user id and auction id. If it does not: insert, if a row does direct the user to payment page
						$exists = $this->BuyItPackage->find('first', array('contain' => '', 'conditions' => array('auction_id' => $auction_id, 'user_id' => $this->Auth->user('id')), 'fields' => array('id'), 'order' => array('id DESC')));
						if(!$exists)
						{
						
							// This buy it does not already exist
							
							if($this->BuyItPackage->save(array('user_id' => $user_id, 'auction_id' => $auction_id, 'name' => $auction['Product']['title'], 'price' => $buyItPrice, 'contract' => '', 'points' => 0)))
							{
								// Get id of last inserted row as we need this to load the correct buy it info
								$lastID = $this->BuyItPackage->find('first', array('contain' => '', 'conditions' => array('auction_id' => $auction_id, 'user_id' => $this->Auth->user('id')), 'fields' => array('id'), 'order' => array('id DESC')));
								$id = $lastID['BuyItPackage']['id'];
								
								$this->redirect(array('controller' => 'payment_gateways', 'action' => 'paypal', 'buyitpackage', $id));
							}
						}
						else
						{
						
							// This buy it does exist so direct user to payment page referencing existing ID
							$id = $exists['BuyItPackage']['id'];
							$this->redirect(array('controller' => 'payment_gateways', 'action' => 'paypal', 'buyitpackage', $id));
							
						}
					}
				}
			}
			$this->redirect(array('controller' => 'auction', 'action' => 'view', $auction_id));
		}

	}
?>