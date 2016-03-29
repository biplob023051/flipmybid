<?php
	class User extends AppModel {

		var $name = 'User';

		var $actsAs = array('Containable');

		var $hasMany = array(
			'Address',
			'Bid' => array(
				'className'  => 'Bid',
				'limit' => 10
			),
			'Bidbutler',
			'Account',
			'Referral',
			'Referred' => array(
				'className'  => 'Referral',
				'foreignKey' => 'referrer_id'
			),

			'Auction' => array(
				'className'  => 'Auction',
				'foreignKey' => 'winner_id',
				'limit' => 10
			),

			'Watchlist' => array(
				'className'  => 'Watchlist',
				'foreignKey' => 'user_id',
				'limit' => 10
			),
			'Point',
			'Exchange',
			'Testimonial',
			'BuyItPackage'
		);

		var $belongsTo = array('Gender', 'Membership', 'Source', 'Currency');

		/**
		 * Constructor, redefine to use __() in validate message
		 */
		function __construct($id = false, $table = null, $ds = null){
			parent::__construct($id, $table, $ds);

			$this->validate = array(
				'username' => array(
					'checkUnique' => array(
						'rule' => array('checkUnique', 'username'),
						'message' => __('The username is already taken.', true)
					),
					'alphaNumeric' => array(
						'rule' => 'alphaNumeric',
						'message' => __('The username can contain letters and numbers only.', true)
					),
					'between' => array(
		        		'rule' => array('between', 3, 16),
		        		'message' => __('Username must be between 3 and 16 characters long.', true)
		        	),
					'minlength' => array(
						'rule' => array('minLength', '1'),
						'message' => __('A username is required.', true)
					)
				),

				'old_password' => array(
					'oldPass' => array(
		        		'rule' => array('oldPass'),
		           		'message' => 'The old password you entered is incorrect.'
		    		),
					'minlength' => array(
						'rule' => array('minLength', '1'),
						'message' => 'Please enter in your old password.'
					)
				),

				'before_password' => array(
					'between' => array(
						'rule' => array('between', 6, 20),
						'message' => __('Password must be between 6 and 20 characters long.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Password is a required field.', true)
					)
				),

				'retype_password' => array(
					'matchFields' => array(
						'rule' => array('matchFields', 'before_password'),
						'message' => __('Password and Retype Password do not match.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Retype Password is a required field.', true)
					)
				),

				'first_name' => array(
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('First name is required.', true)
					)
				),

				'last_name' => array(
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Last name is required.', true)
					)
				),

				'email' => array(
					'checkUnique' => array(
						'rule' => array('checkUnique', 'email'),
						'message' => __('The email address is already used by another user.', true)
					),
					'email' => array(
						'rule' => 'email',
						'message' => __('The email address you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Email address is required.', true)
					)
				),
				'confirm_email' => array(
					'matchFields' => array(
						'rule' => array('matchFields', 'email'),
						'message' => __('Email and confirm email do not match.', true)
					),
					'email' => array(
						'rule' => 'email',
						'message' => __('The confirm email you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Confirm email is required.', true)
					)
				),
				'referrer' => array(
					'referrer' => array(
						'rule' => array('referrer', 'referrer'),
						'message' => __('The referrer username or email address you entered does not exist.', true)
					)
				),
				'affiliate' => array(
					'affiliate' => array(
						'rule' => array('affiliate', 'affiliate'),
						'message' => __('The referrer code you entered does not exist.', true)
					)
				),
				'source_id' => array(
					'rule' => array('notEmpty'),
					'message' => __('Source is required.', true)
				),
				'source_extra' => array(
					'rule' => array('sourceNeedExtra'),
					'message' => __('Site name is required.', true)
				),
				'terms' => array(
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Please accept the terms and conditions.', true)
					)
				),
				'paypal' => array(
					'email' => array(
						'rule' => 'email',
						'message' => __('The PayPal email address you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('PayPal email address is required.', true)
					)
				),
				'amazon' => array(
					'email' => array(
						'rule' => 'email',
						'message' => __('The email address you entered is not valid.', true)
					),
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Email address is required.', true)
					)
				),
				'bank_transfer' => array(
					'minLength' => array(
						'rule' => array('notEmpty'),
						'message' => __('Bank Account Details are required.', true)
					)
				),
				'date_of_birth' => array(
					'rule' => array('date'),
					'message' => __('The date you entered is not valid.', true)
				)
			);
		}

		function sourceNeedExtra($data){
			if(!empty($this->data['User']['source_id'])){
				$source = $this->Source->findById($this->data['User']['source_id']);

				if(!empty($source)){
					if(empty($this->data['User']['source_extra']) && $source['Source']['extra'] == 1){
						return false;
					}
				}
			}

			return true;
		}

		/**
		 * Function to register a user. User will get an activation link by email.
		 *
		 * @param array $data An array which containing user information
		 * @return mixed User and email parameter array if success, false otherwise
		 */
		function register($data, $admin = false){
			if(is_array($data)){
				if(!empty($data['User'])){

					$data['User']['key'] = Security::hash(uniqid(rand(), true));
					$data['User']['ip']  = $_SERVER['REMOTE_ADDR'];

					if(!empty($data['User']['before_password'])) {
						$data['User']['password'] = Security::hash(Configure::read('Security.salt').$data['User']['before_password']);
					}

					// Saving user
					$this->create();
					if($this->save($data)) {
						// Get the last inserted user
						$user = $this->read(null, $this->getLastInsertID());

						// now lets check if there was a referred
						if(!empty($data['User']['referrer'])) {
							$referrer = $this->find('first', array('conditions' => array('or' => array('User.username' => $data['User']['referrer'], 'User.email' => $data['User']['referrer']))));
							if(!empty($referrer)) {
								$referralData['Referral']['user_id'] = $user['User']['id'];
								$referralData['Referral']['referrer_id'] = $referrer['User']['id'];
								$this->Referral->create();
								$this->Referral->save($referralData);
							}
						}

						// Formating the data for email sending
						// Put the reset link inside the user array
						$user['User']['username'] 		= $data['User']['username'];
						$user['User']['password'] 		= $data['User']['before_password'];
						$user['User']['activate_link'] 	= $this->appConfigurations['url'] . '/users/activate/' . $user['User']['key'];
						$user['to'] 				  	= $user['User']['email'];
						$user['from'] 					= $this->appConfigurations['name'].' <'.$this->appConfigurations['email'].'>';

						if($admin == true) {
							$user['subject'] 			= sprintf(__('Account Created by Admin - %s', true), $this->appConfigurations['name']);
						} else {
							$user['subject'] 			= sprintf(__('Welcome to %s', true), $this->appConfigurations['name']);
						}
						$user['template'] 			   	= 'users/welcome';

						return $user;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		/**
		 * Function to reset user password. User will get a new password by email.
		 *
		 * @param array $data Data containing user information which will be verified
		 * @return mixed User and email parameter array if success, false otherwise
		 */
		function reset($data, $newPasswordLength = 8){
			$conditions = array();

			if(is_array($data)){
				if(!empty($data['User'])){
					// Loop through given data array and put it as condition to check
					foreach($data['User'] as $key => $datum){
						if($this->hasField($key)){
							$conditions[$key] = $datum;
						}
					}

					// Find the user
					$user = $this->find('first', array('conditions' => $conditions, 'contain' => ''));
					if(!empty($user)){
						// Formating the data for email sending
						// Put the reset link inside the user array
						$user['User']['before_password'] = substr(sha1(uniqid(rand(), true)), 0, $newPasswordLength);
						$user['to'] 				     = $user['User']['email'];
						$user['from'] 					 = $this->appConfigurations['name'].' <'.$this->appConfigurations['email'].'>';
						$user['subject'] 			     = sprintf(__('Account Reset - %s', true), $this->appConfigurations['name']);
						$user['template'] 			     = 'users/reset';

						// Set the password
						$user['User']['password'] = Security::hash(Configure::read('Security.salt').$user['User']['before_password']);

						// Save the user info
						$this->save($user, false);

						return $user;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		/**
		 * Function to activate a user
		 *
		 * @param string $key Forty characters long key
		 * @return array User array who just been activated
		 */
		function activate($key){
			$user = $this->find('first', array('conditions' => array('User.key' => $key, 'User.active' => 0), 'contain' => '', 'fields' => array('User.id', 'User.username')));

			if(!empty($user)){
				$user['User']['active'] = true;
				$this->save($user, false);

				$referral = $this->Referral->find('first', array('conditions' => array('Referral.user_id' => $user['User']['id']), 'contain' => '', 'fields' => array('Referral.id', 'Referral.referrer_id')));

				if(!empty($referral)) {
					$referral['Referral']['verified'] = true;
					$this->Referral->save($referral);

					$setting = $this->SettingsController->get('free_referral_bids');

					if((is_numeric($setting)) && $setting > 0) {
						$bid['Bid']['user_id'] = $referral['Referral']['referrer_id'];
						$bid['Bid']['description'] = __('Free bids for referring the user:', true).' '.$user['User']['username'];
						$bid['Bid']['credit'] = $setting;
						$this->Bid->create();
						$this->Bid->save($bid);
					}

					// lets check for reward points also!
					if($this->SettingsController->enabled('reward_points') && $this->SettingsController->get('referral_points')) {
						$setting = $this->SettingsController->get('referral_points');
						if((is_numeric($setting)) && $setting > 0) {
							$point['Point']['user_id'] = $referral['Referral']['referrer_id'];
							$point['Point']['description'] = __('Reward points for referring the user:', true).' '.$user['User']['username'];
							$point['Point']['credit'] = $setting;
							$this->Point->create();
							$this->Point->save($point);
						}
					}
				}

				return $user;
			} else {
				return false;
			}
		}

		/**
		 * Function to check the users old password is correct
		 *
		 * @param array $data The users data
		 * @return booleen true is it's right, false otherwise
		 */
		function oldPass($data) {
			if(!empty($data['old_password'])) {
				$valid = false;
				$userData = $this->read();
				$oldPass = Security::hash(Configure::read('Security.salt') . $data['old_password']);
				if ($userData['User']['password'] == $oldPass) {
					$valid = true;
				}
				return $valid;
			} else {
				return true;
			}
		}

		/**
		 * Function to check if the referrer exists
		 *
		 * @param array $data The users data
		 * @return booleen true is it's right, false otherwise
		 */
		function referrer($data) {
			if(!empty($data['referrer'])) {
				$user = $this->find('count', array('conditions' => array('or' => array('User.username' => $data['referrer'], 'User.email' => $data['referrer']))));
				if($user > 0) {
					return 1 ;
				} else {
					return 0;
				}
			} else {
				return 1;
			}
		}

		/**
	     * This function generates random password for user
	     *
	     * @param int $length How long the new password will be
	     * @param string $random_string The string to be used when generate the password
	     * @return string New generated password
	     */
	    function generateRandomPassword($length = 8, $randomString = null) {
	        if(empty($randomString)){
	            $randomString = 'pqowieurytlaksjdhfgmznxbcv1029384756';
	        }
	        $newPassword = '';

	        for($i=0;$i<$length;$i++){
	            $newPassword .= substr($randomString, mt_rand(0, strlen($randomString)-1), 1);
	        }

	        return $newPassword;
	    }
	}
?>