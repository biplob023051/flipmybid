<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $restricted_users_delete = array(1);
	var $uses = array('User', 'Setting', 'Membership');
        

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('ajaxCheck', 'register', 'reset', 'activate', 'ip', 'points',
				'facebook', 'wonbefore', 'get', 'captcha', 'login', 'facebook_logout', 'register');
		}
	}

	function get($id = 0, $fields = '', $contain = '') {
		return $this->User->find('first', array('conditions' => array('User.id' => $id), 'fields' => $fields, 'contain' => $contain));
	}

	function ajaxCheck($type = null){
		Configure::write('debug', 0);
		$content = strip_tags($_POST['content']);
		if(!empty($type) && !empty($content)){
			switch($type){
				case 'username':
					$this->User->set(array('User' => array('username' => $content)));
					$this->User->validates();
					$error = $this->User->invalidFields();

					if(empty($error['username'])){
						$this->set('result', array('result' => 1, 'message' => __('Username is valid', true)));
					}else{
						$this->set('result', array('result' => 0, 'message' => $error['username']));
					}
					break;

				case 'password':
					$this->User->set(array('User' => array('before_password' => $content)));
					$this->User->validates();
					$error = $this->User->invalidFields();

					if(empty($error['before_password'])){
						$this->set('result', array('result' => 1, 'message' => __('Password is valid', true)));
					}else{
						$this->set('result', array('result' => 0, 'message' => $error['before_password']));
					}
					break;

				case 'retypePassword':
					$content2 = strip_tags($_POST['content2']);
					if(!empty($content2)){
						$this->User->set(array('User' => array('before_password' => $content2, 'retype_password' => $content)));
						$this->User->validates();
						$error = $this->User->invalidFields();

						if(empty($error['retype_password'])){
							$this->set('result', array('result' => 1, 'message' => __('Password and Retype Password match', true)));
						}else{
							$this->set('result', array('result' => 0, 'message' => $error['retype_password']));
						}
					}else{
						$this->set('result', array('result' => 0, 'message' => __('Password and Retype Password do not match.', true)));
					}
					break;

				case 'email':
					$this->User->set(array('User' => array('email' => $content)));
					$this->User->validates();
					$error = $this->User->invalidFields();

					if(empty($error['email'])){
						$this->set('result', array('result' => 1, 'message' => __('Email is valid', true)));
					}else{
						$this->set('result', array('result' => 0, 'message' => $error['email']));
					}
					break;

				case 'confirmEmail':
					$content2 = strip_tags($_POST['content2']);
					if(!empty($content2)){
						$this->User->set(array('User' => array('email' => $content2, 'confirm_email' => $content)));
						$this->User->validates();
						$error = $this->User->invalidFields();

						if(empty($error['confirm_email'])){
							$this->set('result', array('result' => 1, 'message' => __('Email and Confirm Email match', true)));
						}else{
							$this->set('result', array('result' => 0, 'message' => $error['confirm_email']));
						}
					}else{
						$this->set('result', array('result' => 0, 'message' => __('Email and Confirm Email do not match.', true)));
					}
					break;

				default:
					$this->set('result', array('result' => 0,'message' => __('Unknown Error', true)));
			}
		}else{
			$this->set('result', array('result' => 0, 'message' => __('Empty Field', true)));
		}
	}

	function login($fbId = null, $fbEmail = null) {
		if(!empty($_GET['admin'])) {
			$this->set('adminLogin', 1);
		}
		$user = array();
		if(!empty($fbId) && !empty($fbEmail)) {
			$user = $this->User->find('first', array(
				'conditions' => array(
//					'OR' => array(
//						'facebook_id' => $fbId,
						'email' => $fbEmail))
//			)
			);

			if(!empty($user)){
				$this->data['User']['username'] = $user['User']['username'];
				$this->data['User']['password'] = $user['User']['password'];
			} else {
				$this->redirect(array('action' => 'facebook_logout'));
			}
		}

		if(!empty($this->data)) {
			if(!empty($user['User']['id'])){
				$auth = $this->Auth->login($user['User']['id']);
			} else {
				$auth = $this->Auth->login();
			}
			if( $auth ) {
				if($this->Auth->user('deleted') == 1) {
					$this->Auth->logout();
					$this->Session->setFlash(__('Your account has been deleted and you can no longer login.', true));
            		$this->redirect(array('action'=>'login'));
				}

				if(!empty($this->data['User']['remember_me'])){
					$this->Cookie->write('User.id', $this->Auth->user('id'), false, '+30 Days');
					if($this->Auth->user('admin')) {
						$this->Cookie->write('User.admin', $this->Auth->user('admin'), false, '+30 Days');
					} elseif($this->Auth->user('translator')) {
						$this->Cookie->write('User.translator', $this->Auth->user('translator'), false, '+30 Days');
					}

					unset($this->data['User']['remember_me']);
				} else {
					$this->Cookie->write('User.id', $this->Auth->user('id'), false, '+12 hour');
					if($this->Auth->user('admin')) {
						$this->Cookie->write('User.admin', $this->Auth->user('admin'), false, '+12 hour');
					} elseif($this->Auth->user('translator')) {
						$this->Cookie->write('User.translator', $this->Auth->user('translator'), false, '+12 hour');
					}
				}



				// lets delete the vistor cache, they are logged in now & set the users cache file
				if(Cache::read('visitor_count_'.$_SERVER['REMOTE_ADDR'])) {
					Cache::delete('visitor_count_'.$_SERVER['REMOTE_ADDR']);
				}
				$this->Cookie->delete('visitor');

				if(!Cache::read('user_count_'.$this->Auth->user('id'))) {
			 		Cache::write('user_count_'.$this->Auth->user('id'), true, 'short');
				}

				$this->Session->setFlash(__('You have been successfully logged in.', true), 'default', array('class' => 'success'));
				// if(!empty($this->data['User']['url'])) {
				// 	$this->redirect($this->data['User']['url']);
				// } else {
    //         		$this->redirect(array('action'=>'login'));
    //       		}

				
				// redirect to home page
				$this->redirect('/');
			}
		} else {
			$id = $this->Auth->user('id');
			if(!empty($id)) {
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set('title_for_layout', __('Login', true));
	}

//	function connect_facebook($fbId = null, $fbToken = null)
//	{
//		//get user id
//
//		//isnert fbid hwere user id
//
//		//redrect
//		$this->redirect(array('action' => 'index'));
//
//	}

	function logout() {
		// lets delete the user cache, they are logged out now & set the visitors cache file
		if(Cache::read('user_count_'.$this->Auth->user('id'))) {
			Cache::delete('user_count_'.$this->Auth->user('id'));
		}
		if(!Cache::read('visitor_count_'.$_SERVER['REMOTE_ADDR']) && !$this->Cookie->read('visitor')) {
			// lets set the cache to 10 mintes for the online user
			$this->Cookie->write('visitor', 1, false, 600);
			Cache::write('visitor_count_'.$_SERVER['REMOTE_ADDR'], true, 'short');
		}

		// Deleting remember me cookie if it exists
		if($this->Cookie->read('User.id')) {
			$this->Cookie->delete('User.id');
		}

		if($this->Cookie->read('User.admin')) {
			$this->Cookie->delete('User.admin');
		}

		if($this->Cookie->read('User.translator')) {
			$this->Cookie->delete('User.translator');
		}

		// Deleting getstatus cookie if it exists
		if($this->Cookie->read('user_id')) {
			$this->Cookie->delete('user_id');
		}

		$this->Session->setFlash(__('You have been logged out successfully.', true), 'default', array('class' => 'success'));
       	$this->redirect($this->Auth->logout());
	}

	function facebook_logout() {
		// lets delete the user cache, they are logged out now & set the visitors cache file
		if(Cache::read('user_count_'.$this->Auth->user('id'))) {
			Cache::delete('user_count_'.$this->Auth->user('id'));
		}
		if(!Cache::read('visitor_count_'.$_SERVER['REMOTE_ADDR']) && !$this->Cookie->read('visitor')) {
			// lets set the cache to 10 mintes for the online user
			$this->Cookie->write('visitor', 1, false, 600);
			Cache::write('visitor_count_'.$_SERVER['REMOTE_ADDR'], true, 'short');
		}

		// Deleting remember me cookie if it exists
		if($this->Cookie->read('User.id')) {
			$this->Cookie->delete('User.id');
		}

		if($this->Cookie->read('User.admin')) {
			$this->Cookie->delete('User.admin');
		}

		if($this->Cookie->read('User.translator')) {
			$this->Cookie->delete('User.translator');
		}

		// Deleting getstatus cookie if it exists
		if($this->Cookie->read('user_id')) {
			$this->Cookie->delete('user_id');
		}

//		$this->Session->setFlash(__('You have been logged out successfully.', true), 'default', array('class' => 'success'));
		$this->Session->setFlash(__('There is no facebook associated.', true));
		$this->redirect($this->Auth->logout());
	}

	function index($firstTime = false) {
		$this->set('user', $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => 'Membership')));

		$addresses = $this->User->Address->UserAddressType->find('all', array('recursive' => -1));
		$data = array();
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$data[$address['UserAddressType']['name']] = $this->User->Address->find('first', array('conditions' => array('Address.user_id' => $this->Auth->user('id'), 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
				if(empty($data[$address['UserAddressType']['name']])) {
					$data[$address['UserAddressType']['name']] = array('Address' => array('user_address_type_id' => $address['UserAddressType']['id']));
				}
			}
		}

		$this->set('userAddress', $data);

		$this->set('unpaidAuctions', $this->User->Auction->find('count', array('conditions' => array('Auction.winner_id' => $this->Auth->user('id'), 'Status.id' => 1))));

		$auctions = $this->User->Auction->Bid->find('all', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0, 'Auction.closed' => 0), 'fields' => 'DISTINCT Bid.auction_id', 'contain' => 'Auction', 'order' => array('Auction.end_time' => 'asc')));

		if(!empty($auctions)) {
			foreach($auctions as $key => $auction) {
				$auctions[$key] = $this->User->Auction->getAuctions(array('Auction.id' => $auction['Auction']['id']), 1);
			}
		}

		$this->set('auctions', $auctions);
		$this->set('firstTime', $firstTime);				/* Change by Andrew Buchan on 2015-03-02 */		$bidPoints = $this->User->Auction->Bid->find('count', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0)));		$this->set('bidPoints', $bidPoints);		/* End Change */
		$this->set('title_for_layout', __('Dashboard', true));
	}

	function reset(){
		if(!empty($this->data)){
			if($data = $this->User->reset($this->data)){
				if($this->_sendEmail($data)){
					$this->Session->setFlash(__('Please check your account.  An email containing your account details has been sent to you.', true), 'default', array('class' => 'success'));
					$this->redirect(array('action'=>'login'));
				}else{
					$this->Session->setFlash(__('There was a problem sending the email, please contact us', true));
				}
			}else{
				$this->Session->setFlash(__('The email address you entered was not found in our database.', true));
			}
		}

		$this->set('title_for_layout', __('Reset Your Password', true));
	}

	function resend() {
		$user = $this->User->read(null, $this->Auth->user('id'));
		if($user['User']['active'] == 0) {
			$user['User']['activate_link'] 	= $this->appConfigurations['url'] . '/users/activate/' . $user['User']['key'];
			$data['User']						= $user['User'];
			$data['to'] 				  		= $user['User']['email'];
			$data['from'] 						= $this->appConfigurations['name'].' <'.$this->appConfigurations['email'].'>';
			$data['subject'] 					= sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
			$data['template'] 			   		= 'users/activate';
			if($this->_sendEmail($data)) {
				$this->Session->setFlash(__('We have sent you a confirmation email to validate your account.', true), 'default', array('class' => 'success'));
			} else {
				$this->Session->setFlash(__('There was a problem sending the email, please contact us.', true));
			}
		} else {
			$this->Session->setFlash(__('Your account has already been validated.', true));
		}

		$this->redirect(array('action' => 'index'));
	}

	function activate($key){
		if(!empty($key)) {
			$user = $this->User->activate($key);

			if(!empty($user)) {
				$setting = $this->Setting->get('free_registration_bids');
				if((is_numeric($setting)) && $setting > 0) {
					$bid['Bid']['user_id'] = $user['User']['id'];
					$bid['Bid']['description'] = __('Free bids for confirming email address.', true);
					$bid['Bid']['credit'] = $setting;
					$this->User->Bid->create();
					$this->User->Bid->save($bid);

					$this->Session->setFlash(__('Your email address has been confirmed and some free bid credits have been added to your account.', true), 'default', array('class' => 'success'));
				} else {
					$this->Session->setFlash(__('Your email address has been confirmed.', true), 'default', array('class' => 'success'));
				}
			} else {
				$this->Session->setFlash(__('Your email address has already been confirmed.', true));
			}
		}

		//if($this->Auth->user('id')) {
			//$this->redirect(array('action' => 'index'));
		//} else {
			$this->redirect(array('action' => 'login'));
		//}
	}

	function register($fbId = null, $fbEmail = null, $fbFirstName = null, $fbLastName = null, $fbGender = null,
					  $fbUsername = null, $fbBirthDate = null) {



		if($this->theme == 'quibids') {
			$this->layout = false;
		}

		if($fbEmail == 'undefined'){
			$fbEmail = null;
		}

		if($fbFirstName == 'undefined'){
			$fbFirstName = null;
		}

		if($fbLastName == 'undefined'){
			$fbLastName = null;
		}

		if($fbGender == 'undefined'){
			$fbGender = null;
		}

		if($fbGender == 'male') {
			$newGender = 1;
		} else {
			$newGender = 2;
		}

		if($fbUsername == 'undefined'){
			$fbUsername = null;
		}

		$validateCaptcha = $this->Captcha->validateCaptcha();

		if(!empty($fbId) && !empty($fbEmail) ) {
			$validateCaptcha = true;

			if(empty($fbFirstName)) {
				$newFirstName = 'Name';
			} else {
				$tagsA = strtolower(strip_tags ($fbFirstName));
				$newFirstName = str_replace(' ', '', $tagsA);
			}

			if(empty($fbLastName)) {
				$newLastName = 'Name';
			} else {
				$tagsB = strtolower(strip_tags ($fbLastName));
				$newLastName = str_replace(' ', '', $tagsB);
			}

			if(empty($fbUsername)){
				$newUsername = 'usr'.uniqid();
			} else {
				$newUsername = $fbUsername;
			}
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$password = substr(str_shuffle($chars),0,8);

			$birthDate = new \DateTime();
			$birthDate->modify('-16 years');

			$this->data['User'] = array(
				'username' => $newUsername,
				'email' => $fbEmail,
				'confirm_email' => $fbEmail,
				'before_password' => $password,
				'retype_password' => $password,
				'first_name' => ucfirst($newFirstName),
				'last_name' => ucfirst($newLastName),
				'gender_id' => $newGender,
				'facebook_id' => $fbId,
				'referrer' => '',
				'source_id' => 2,
				'source_extra' => '',
				'newsletter' => 1,
				'terms' => 1,
				'date_of_birth' => array(
					'month' => $birthDate->format('m'),
					'day' => $birthDate->format('d'),
					'year' => $birthDate->format('Y'))
			);
		} elseif (!empty($fbId) && empty($fbEmail)) {
			$this->Session->setFlash(__('You cannot register with Facebook, fill the form below.', true));
			$this->redirect(array('action' => 'register'));
		}

		if($this->Setting->get('limit_registration')) {
			if($this->Cookie->read('registered')) {
				$this->Session->setFlash(__('You have already registered an account from this computer.  It is against our terms and conditions to register more than one account per household.', true), 'default', array('class' => 'message'));
				$this->redirect(array('action' => 'login'));
			}
		}

		if (!empty($this->data)) {
			if($this->appConfigurations['demoMode']) {
				$this->data['User']['admin'] = 1;
			} else {
				$this->data['User']['admin'] = 0;
			}
			if(isset($this->data['User']['terms']) && $this->data['User']['terms'] == 0) {
				$this->data['User']['terms'] = null;
			}

			if($this->Setting->get('registration_tracking') && $this->Cookie->read('registerTracking')) {
				$this->data['User']['source_extra'] = $this->Cookie->read('registerTracking');
			}

			if($this->Cookie->read('referral')) {
				$this->Session->write('referral', $this->Cookie->read('referral'));
				$this->data['User']['referrer'] = $this->Cookie->read('referral');
			}

			// lets see if the membership module is installed
			if($this->Setting->Module->enabled('memberships')) {
				// lets get the default membership
				$membership = $this->User->Membership->find('first', array('conditions' => array('Membership.default' => true), 'contain' => '', 'fields' => 'Membership.id'));
				if(!empty($membership)) {
					$this->data['User']['membership_id'] = $membership['Membership']['id'];
				}
			}
			if($validateCaptcha) {
				if ($data = $this->User->register($this->data)) {
						$this->_sendEmail($data);
						$user = $this->User->find('first', array('conditions' => array('User.id' => $data['User']['id']), 'contain' => ''));

						$this->Cookie->write('registered', true, true, '+90 day');

						if($this->Auth->login($user)) {
								$this->Cookie->write('User.id', $this->Auth->user('id'), true, '+1 hour');
								$this->Session->setFlash(__('Your registration was successful and you have been automatically logged in.  A welcome email has been sent to your email address.', true), 'default', array('class' => 'success'));
								$this->redirect(array('controller' => 'packages', 'action' => 'index', true));
						} else {
								$this->Session->setFlash(__('Your registration was successful, please login below.', true), 'default', array('class' => 'success'));
								$this->redirect(array('action' => 'login'));
						}
				} else {
						$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
				}
			} else {
				//$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
                           
		} else {
				if($this->Auth->user('id')) {
						$this->redirect(array('action' => 'index'));
				}

				$this->data['User']['newsletter'] = true;
		}
                        
                
		$this->set('genders', $this->User->Gender->find('list'));

        if($this->Setting->get('registration_options')) {
        	$this->set('sources', $this->User->Source->find('all', array('order' => 'Source.order ASC', 'contain' => '')));
        }

        if($this->Setting->get('registration_tracking') && $this->Cookie->read('registerTracking')) {
			$this->set('registerTracking', $this->Cookie->read('registerTracking'));
		}

		if($this->Cookie->read('referral')) {
			$this->data['User']['hideReferral'] = true;
		}

		$this->set('title_for_layout', __('Register', true));
	}

	function facebook() {
		if(!$this->Setting->Module->enabled('facebook_login')) {
			$this->Session->setFlash(__('Access Denined.', true));
			$this->redirect(array('action' => 'login'));
		}

//		$facebookAppId = $this->Setting->get('facebook_app_id');
//		$facebookAppSecret = $this->Setting->get('facebook_app_secret');				/* Change by Andrew Buchan. Set app id and secret */		$facebookAppId = '780971695307080';		$facebookAppSecret = 'f1bf0ee48a955cab410f54c30b0075a1';		/* End Change */


		//		$appId=Configure::read('Facebook.appId');
		$facebookAppId= '449785581872611';
//		$app_secret=Configure::read('Facebook.secret');
		$facebookAppSecret='40e2db874aade9a488839c875115097c';


		if(empty($_GET['code'])) {
			$this->redirect('https://www.facebook.com/dialog/oauth?client_id='.$facebookAppId.'&redirect_uri='.$this->appConfigurations['url'].'/users/facebook&scope=email,user_birthday');
		}

		$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$facebookAppId.'&redirect_uri='.$this->appConfigurations['url'].'/users/facebook&client_secret='.$facebookAppSecret.'&code='.$_GET['code'];

		$response = file_get_contents($token_url);
		$params = null;
		parse_str($response, $params);

		$graph_url = "https://graph.facebook.com/me?access_token=".$params['access_token'];

		$facebook = json_decode(file_get_contents($graph_url));

		if(!empty($facebook->id)) {
			// lets see if this user is already registered!
			$user = $this->User->find('first', array('conditions' => array('User.facebook_id' => $facebook->id), 'contain' => ''));

			if(!empty($user)) {
				// lets log the user in!
				if(!empty($user['User']['deleted'])) {
					$this->Session->setFlash(__('Your account has been deleted and you can no longer login.', true));
	           		$this->redirect('/');
				}

				if($this->Auth->login($user)) {
					$this->Session->delete('Message.Auth');

					if(!Cache::read('visitor_count_'.$_SERVER['REMOTE_ADDR'])) {
						Cache::delete('visitor_count_'.$_SERVER['REMOTE_ADDR']);
					}
					$this->Cookie->delete('visitor');

					if(!Cache::read('user_count_'.$this->Auth->user('id'))) {
				 		Cache::write('user_count_'.$this->Auth->user('id'), array(), 600);
					}

					$this->Session->setFlash(__('You have been succesfully logged in.', true), 'default', array('class' => 'success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('There was a problem with the Facebook login. Please try again! If the problem persists, please contact us.', true));
		    		$this->redirect('/');
				}
			} else {
				// lets see if this person is already registered!
				$user = $this->User->find('first', array('conditions' => array('User.email' => $facebook->email), 'contain' => '', 'fields' => 'User.id'));
				if(!empty($user)) {
					// lets update the users details with the new FB fields
					$user['User']['facebook_id'] = $facebook->id;

					if(isset($this->Session->read('facebook')->username)) {
						$user['User']['facebook_username'] = $facebook->username;
					}

					if(isset($facebook->location->name)) {
						$user['User']['facebook_location'] = $facebook->location->name;
					}

					if(isset($facebook->hometown->name)) {
						$user['User']['facebook_hometown'] = $facebook->hometown->name;
					}

					$user['User']['facebook_timezone'] = $facebook->timezone;
					$user['User']['facebook_locale'] = $facebook->locale;

					$this->User->save($user, false);
					$this->redirect(array('action' => 'facebook'));
				} else {
					// lets make sure they are old enough to register!
					if(!empty($facebook->birthday)) {
						$birthday = explode('/', $facebook->birthday);
						$date = $birthday[2].'-'.$birthday[0].'-'.$birthday[1];
						// lets go back 18 years!
						$dateLimit = date('Y-m-d', strtotime('-18 year'));
						if(strtotime($dateLimit) < strtotime($date)) {
							$this->Session->setFlash(__('You need to be at least 18 years old to become a member of our website!', true));
			    			$this->redirect('/');
						}
					}

					$this->Session->write('facebook', $facebook);

					$this->Session->setFlash(__('You have successfully logged in using Facebook.  Please register other details below.', true), 'default', array('class' => 'success'));
			   		$this->redirect('/users/register');
				}
			}
		} else {
		   	$this->Session->setFlash(__('There was a problem with the Facebook login. Please try again! If the problem persists, please contact us.', true));
		   	$this->redirect('/');
		}
	}

	function edit() {
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			if($this->User->save($this->data)) {
				$this->Session->setFlash(__('Your account has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		} else {
			$this->data = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));
		}

		$this->set('genders', $this->User->Gender->find('list'));

		$this->set('title_for_layout', __('Edit Profile', true));
	}

	function newsletter() {
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			if($this->User->save($this->data)) {
				$this->Session->setFlash(__('Your newsletter preferences have been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		} else {
			$this->data = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));
		}

		$this->set('title_for_layout', __('Newsletter', true));
	}

	function changepassword() {
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			if(!empty($this->data['User']['before_password'])){
				$this->data['User']['password'] = Security::hash(Configure::read('Security.salt').$this->data['User']['before_password']);
			}
			$this->User->set($this->data);
    		if($this->User->validates()) {
				// stupid cake bug requires manual validation here
				if($this->data['User']['before_password'] == $this->data['User']['retype_password']) {
					if($this->User->save($this->data, false)) {
						$this->Session->setFlash(__('Your password has been changed successfully.', true), 'default', array('class' => 'success'));
						$this->redirect(array('action'=>'index'));
					} else {
						$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
					}
				} else {
					$this->Session->setFlash(__('The new password you entered does not match.', true));
				}
    		}
		}

		$this->set('title_for_layout', __('Change Password', true));
	}

	function delete() {
		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');

			if($this->User->save($this->data)) {
				// stupid cake bug!
				$user['User']['id'] = $this->Auth->user('id');
				$user['User']['deleted'] = 1;
				$this->User->save($user, false);

				$this->redirect(array('action' => 'logout'));
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		}

		$this->set('title_for_layout', __('Delete Account', true));
	}

	function ip($ip = null) {
		$location = '';

		$ip_loc = $this->GeoIp->lookupIp($ip);

		if(!empty($ip_loc)) {
			if(!empty($ip_loc['city'])) {
				$location .= $ip_loc['city'].', ';
			}

			$location .= $ip_loc['country_name'];
		}

		return $location;
	}

	function paypal($id = null, $method = 'auction') {

		if(!empty($this->data)) {
			$this->data['User']['id'] = $this->Auth->user('id');
			if($this->Auth->user('admin') == 0) {
				$this->data['User']['admin'] = 0;
			}
			if($this->User->save($this->data)) {
				$this->Session->setFlash(__('Your PayPal address has been updated successfully. Please now confirm your details below.', true), 'default', array('class' => 'success'));
				if($method == 'exchange') {
					$this->redirect(array('controller' => 'exchanges', 'action'=>'confirm', $id));
				} elseif($method == 'reward') {
					$this->redirect(array('controller' => 'rewards', 'action'=>'confirm', $id));
				} else {
					$this->redirect(array('controller' => 'auctions', 'action'=>'pay', $id));
				}
			} else {
				$this->Session->setFlash(__('Unfortunately there was a problem.  Please correct the errors below.', true));
			}
		} else {
			$this->data = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'contain' => ''));
		}

		$this->set('id', $id);
		$this->set('method', $method);

		$this->set('title_for_layout', __('PayPal Address', true));
	}

	function points($id = null) {
		return $this->User->Point->balance($id);
	}

	function bids($id = null) {
		if(empty($id)) {
			if($this->Auth->user('id')) {
				$id = $this->Auth->user('id');
			} else {
				return false;
			}
		}

		return $this->User->Bid->balance($id);
	}

	function wins($id = null) {
		if(empty($id)) {
			if($this->Auth->user('id')) {
				$id = $this->Auth->user('id');
			} else {
				return false;
			}
		}

		return $this->User->Bid->Auction->find('count', array('conditions' => array('Auction.winner_id' => $id), 'recursive' => -1));
	}

	function wonbefore($id = null) {
		if(empty($id)) {
			if($this->Auth->user('id')) {
				$id = $this->Auth->user('id');
			} else {
				return false;
			}
		}

		$count = $this->User->Bid->Auction->find('count', array('conditions' => array('Auction.winner_id' => $id), 'recursive' => -1));

		if($count > 0) {
			return true;
		} else {
			return false;
		}
	}

	function tasks($task = null, $id = null, $user_id = null) {
		if(empty($user_id)) {
			$user_id = $this->Auth->user('id');
		}

		switch ($task) {
		    case 'buy_now':
		        $count = $this->User->Exchange->find('count', array('conditions' => array('Exchange.user_id' => $user_id), 'recursive' => -1));
				if($count > 0) {
					return true;
				} else {
					return false;
				}
		        break;
		    case 'won_auction':
		        return $this->wonbefore($user_id);
		        break;
		    case 'purchased_bids':
		        $count = $this->User->Account->find('count', array('conditions' => array('Account.user_id' => $user_id), 'recursive' => -1));
				if($count > 0) {
					return true;
				} else {
					return false;
				}
		        break;
		    case 'rewards':
		        $count = $this->User->Point->find('count', array('conditions' => array('Point.user_id' => $user_id, 'Point.debit >' => 0), 'recursive' => -1));
				if($count > 0) {
					return true;
				} else {
					return false;
				}
		        break;
		     case 'membership_up':
		        $membership = $this->User->Membership->find('first', array('conditions' => array('Membership.id' => $id), 'recursive' => -1, 'fields' => 'default'));
		        if(empty($membership['Membership']['default'])) {
		        	return true;
		        } else {
		        	return false;
		        }
		        break;
		    case 'membership_top':
		        $membership = $this->User->Membership->find('first', array('order' => array('rank' => 'desc'), 'recursive' => -1, 'fields' => 'id'));
		        if($membership['Membership']['id'] == $id) {
		        	return true;
		        } else {
		        	return false;
		        }
		        break;
		    case 'testimonial':
		        $count = $this->User->Testimonial->find('count', array('conditions' => array('Testimonial.user_id' => $user_id), 'recursive' => -1));
				if($count > 0) {
					return true;
				} else {
					return false;
				}
		        break;
		    case 'referrals':
		        $count = $this->User->Referred->find('count', array('conditions' => array('Referred.referrer_id' => $user_id), 'recursive' => -1));
				if($count >= 20) {
					return true;
				} else {
					return false;
				}
		        break;
		    default:
		    	return false;
		}

	}

	function admin_login() {
		$this->redirect('/users/login');
	}

	function admin_index() {
		$this->paginate = array('conditions' => array('User.autobidder' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'), 'contain' => array('Membership.name', 'Source'));
		$this->set('users', $this->paginate());
	}

	function admin_search(){
		if(!empty($this->data['User']['name']) ||
		   !empty($this->data['User']['email']) ||
		   !empty($this->data['User']['username'])){


			$email = $this->data['User']['email'];
			$username = $this->data['User']['username'];

			$conditions = array();

			if(!empty($this->data['User']['name'])){
				$conditions[] = 'User.first_name LIKE \'%'.$this->data['User']['name'].'%\' OR User.last_name LIKE \'%'.$this->data['User']['name'].'%\'';
			}

			if(!empty($this->data['User']['email'])){
				$conditions[] = array('User.email' => $this->data['User']['email']);
			}

			if(!empty($this->data['User']['username'])){
				$conditions[] = 'User.username LIKE \'%'.$this->data['User']['username'].'%\'';
			}

			$conditions[] = array('User.autobidder' => 0);

			$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'), 'contain' => array('Membership.name', 'Source'));
			$this->set('users', $this->paginate('User', $conditions));
		}else{
			$this->Session->setFlash(__('Please enter at least one search term', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}

		if(is_numeric($id)) {
			$user = $this->User->read(null, $id);
		} else {
			$user = $this->User->findbyUsername($id);
		}

		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $user);

		$this->User->Address->UserAddressType->recursive = -1;
		$addresses = $this->User->Address->UserAddressType->find('all');
		$userAddress = array();
		$addressRequired = 0;
		if(!empty($addresses)) {
			foreach($addresses as $address) {
				$userAddress[$address['UserAddressType']['name']] = $this->User->Address->find('first', array('conditions' => array('Address.user_id' => $id, 'Address.user_address_type_id' => $address['UserAddressType']['id'])));
			}
		}
		$this->set('address', $userAddress);

		if(!empty($user['Referral'])) {
			$this->set('referral', $this->User->Referral->find('first', array('conditions', array('Referral.user_id' => $user['User']['id']))));
		}
	}

    function admin_resend($id = null){
        if(empty($id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->User->recursive = -1;
		$user = $this->User->read(null, $id);

		if(!empty($user['User']['language_id'])) {
			$language = $this->Language->find('first', array('conditions' => array('Language.id' => $user['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
			Configure::write('Config.language', $language['Language']['code']);
		}

        $user['User']['activate_link'] = $this->appConfigurations['url'] . '/users/activate/' . $user['User']['key'];
        $user['to'] 				   = $user['User']['email'];
        $user['from'] 				   = $this->appConfigurations['name'].' <'.$this->appConfigurations['email'].'>';
        $user['subject'] 			   = sprintf(__('Account Activation - %s', true), $this->appConfigurations['name']);
        $user['template'] 			   = 'users/activate';

        if($this->_sendEmail($user)){
            $default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));
    		Configure::write('Config.language', $default['Language']['code']);

            $this->Session->setFlash(__('Activation email has been sent to user email address.', true), 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }else{
            $default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));
    		Configure::write('Config.language', $default['Language']['code']);

            $this->Session->setFlash(__('Activation email sending failed. Please try again.', true));
            $this->redirect(array('action' => 'index'));
        }
    }

	function admin_add() {
		if (!empty($this->data)) {
			$this->data['User']['before_password'] = $this->User->generateRandomPassword();
			if ($data = $this->User->register($this->data, true)) {
				$data['User']['password'] = $this->data['User']['before_password'];
				if($this->_sendEmail($data)){
					$this->Session->setFlash(__('The user has been added and their username and password details have been sent to them.', true), 'default', array('class' => 'success'));
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash(__('Email sending failed. Please try again or contact administrator.', true));
				}
			} else {
				$this->Session->setFlash(__('There was a problem adding the user please review the errors below and try again.', true));
			}
		}
		$this->set('genders', $this->User->Gender->find('list'));

		if($this->Setting->Module->enabled('memberships')) {
			$this->set('memberships', $this->User->Membership->find('list', array('order' => array('Membership.rank' => 'asc'))));
		}
	}

	function admin_edit($id = null) {
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('There user has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the users details please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->set('genders', $this->User->Gender->find('list'));

		if($this->Setting->Module->enabled('memberships')) {
			$this->set('memberships', $this->User->Membership->find('list', array('order' => array('Membership.rank' => 'asc'))));
		}
	}

	function admin_rights($id = null) {
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('There users admin rights has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the users details please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	function admin_delete($id = null, $autobid = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if($this->User->delete($id)) {
			$this->Session->setFlash(__('The user was successfully deleted.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting the user.', true));
		}
		if(!empty($autobid)) {
			$this->redirect(array('action' => 'autobidders'));
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}

	function admin_suspend($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}

		$user = $this->User->read(null, $id);
		$user['User']['active'] = 0;
		$this->User->save($user);

		$this->Session->setFlash(__('The user was successfully suspended.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action' => 'index'));
	}

	function admin_autobidders() {
		$this->paginate = array('contain' => array('Auction', 'Bid'), 'conditions' => array('User.autobidder' => 1), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('User.created' => 'desc'));
		$this->set('users', $this->paginate());
	}

	function admin_autobidder_add() {
		if (!empty($this->data)) {
			$this->data['User']['autobidder'] = 1;
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The auto bidder was added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'autobidders'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the autobidder please review the errors below and try again.', true));
			}
		} else {
			$this->data['User']['active'] = true;
		}
	}

	function admin_autobidder_edit($id = null) {
		if(!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
            $this->User->id = $id;
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The autobidder has been updated successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'autobidders'));
			} else {
				$this->Session->setFlash(__('There was a problem updating the autobidder please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
		}
	}

	function admin_online() {
		$dir   = TMP . DS . 'cache' . DS;

		$files = scandir($dir);
		$users = array();

		foreach($files as $filename){
			if(is_dir($dir . $filename)){
				continue;
			}

			if(substr($filename, 0, 16) == 'cake_user_count_') {
				$data = explode('_', $filename);
				$user = $this->User->find('first', array('conditions' => array('User.id' => $data[3]), 'contain' => ''));
				$user['User']['action'] = Cache::read('user_count_'.$data[3]);
				$users[] = $user;
			}
		}

		$this->set('users', $users);
	}
}
?>
