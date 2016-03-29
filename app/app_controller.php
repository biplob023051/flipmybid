<?php
class AppController extends Controller {
    var $helpers = array('Html', 'Form', 'Time', 'Number', 'Javascript', 'Text', 'Paypal', 'Session', 'Captcha');
    var $components = array('Auth', 'Email', 'Cookie', 'RequestHandler', 'Paypal', 'GeoIp', 'Session', 'Captcha');
    var $uses = array('Setting', 'Currency', 'Language', 'User');
    var $view = 'Theme';
    
   

    var $appConfigurations;

    function beforeFilter() {
	    // if you remove this, the script will no longer work!
	    // licenses can be purchased from www.pennyauctioncode.com
	    require 'config/license.php';

	    $this->disableCache();
            if(!empty($this->Auth)) {
		$this->Auth->allow('captcha');
            }

        /*
        if ($this->RequestHandler->isMobile()) {
            $this->is_mobile = true;
            $this->set('is_mobile', true );
            $this->autoRender = false;
         }
         */
        //write tru bids into session
        //$trueBids = $this->requestAction('/users/bids');
        $currentId = $this->Auth->user('id');
        if(!empty($currentId)) {
            $trueBids = $this->User->Bid->balance($this->Auth->user('id'));
            $lastBuy = $this->User->Bid->bought($this->Auth->user('id'));
        } else {
            $trueBids = 0;
            $lastBuy = 100;
            $this->fbLoadCheck();
        }
        $this->Session->write('true_bids', $trueBids);
        $this->Session->write('last_buy', $lastBuy);
    }

    function afterFilter() {
        // if in mobile mode, check for a valid view and use it
        if (isset($this->is_mobile) && $this->is_mobile) {
            $view_file = new File( VIEWS . $this->name . DS . 'mobile/' . $this->action . '.ctp' );
            $this->render($this->action, 'mobile', ($view_file->exists()?'mobile/':'').$this->action);
        }
     }

    private function fbLoadCheck()
    {


//        $fb = new Facebook();
//        $a = $fb->getAppId();
//        debug($a);die;
    }

	function _checkAuth() {
		// Setup the field for auth
		$this->Auth->fields = array(
			'username' => 'username',
			'password' => 'password'
		);


		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action'     => 'login'
		);

		// Where the auth will redirect user after logout
		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action'     => 'login'
		);

		// Set to off since we do something inside login
		$this->Auth->autoRedirect = false;

		// Set the error message
		$this->Auth->loginError = sprintf(__('Invalid %s or %s. Please try again.', true),
										  $this->Auth->fields['username'],
										  $this->Auth->fields['password']);

		// Set the type of authorization
		$this->Auth->authorize = 'controller';

		// Check if user has a remember me cookie
		if(!$this->Auth->user()) {
			if(!empty($_COOKIE['CakeCookie']['User']['id'])) {
				$user = $this->User->find('first', array('conditions' => array('User.id' => $_COOKIE['CakeCookie']['User']['id']), 'contain' => ''));
				if($this->Auth->login($user)) {
					$this->Session->delete('Message.Auth');

					$this->Session->setFlash(__('You have been automatically logged in.', true), 'default', array('class' => 'success'));
					//$this->redirect('/'.$this->params['url']['url']);
				} else {
					$this->Cookie->delete('User.id');
				}
			}
		}

		if($this->Auth->user()) {
			 if($this->Auth->user('deleted')) {
				// Deleting remember me cookie if it exists
				if(!empty($_COOKIE['CakeCookie']['User']['id'])) {
					$this->Cookie->delete('User.id');
				}
				$this->Auth->logout();
			}

			// online users stuff
			if(!Cache::read('user_count_'.$this->Auth->user('id'))) {
				// lets set the cache to 10 mintes for the online user
			 	Cache::write('user_count_'.$this->Auth->user('id'), true, 'short');
			}
		} elseif(!Cache::read('visitor_count_'.$_SERVER['REMOTE_ADDR']) && !$this->Cookie->read('visitor')) {
			// lets set the cache to 10 mintes for the online user
			$this->Cookie->write('visitor', 1, false, 600);
			Cache::write('visitor_count_'.$_SERVER['REMOTE_ADDR'], true, 'short');
		}

		if(!empty($_SERVER['HTTP_REFERER']) && empty($this->params['requested'])) {
			// doing a double if statement here just to use less resources
			if($this->Setting->get('registration_tracking') && !$this->Cookie->read('registerTracking')) {
				$this->Cookie->write('registerTracking', $_SERVER['HTTP_REFERER'], true, '30 Day');
	    	}
		}
	}

    function isAuthorized(){
        if(!empty($this->params['admin']) && $this->Auth->user('admin') != 1){
            return false;
        }

        return true;
    }

    /**
     * Function to send email
     *
     * @param array $data An array containing smtp parameter including body
     * @return boolean Return true if success, false otherwise
     */
    function _sendEmail($data) {

        $emailConfigurations['delivery'] 	= $this->Setting->get('email_delivery');
        $emailConfigurations['sendAs'] 		= $this->Setting->get('email_send_as');
        $emailConfigurations['host'] 		= $this->Setting->get('email_host');
        $emailConfigurations['port'] 		= $this->Setting->get('email_port');
        $emailConfigurations['timeout'] 	= $this->Setting->get('email_timeout');
        $emailConfigurations['username'] 	= $this->Setting->get('email_username');
        $emailConfigurations['password'] 	= $this->Setting->get('email_password');

        if(!empty($data)) {
            // Array for configurations
            $configurations = array();

            // Optional, I will use main configuraiton or mail if empty
            if(!empty($data['delivery'])){
                $this->Email->delivery = $data['delivery'];
            } else {
            	$this->Email->delivery = $emailConfigurations['delivery'];
            }

            // If the delivery is smtp, then put the smtp configurations
            if($this->Email->delivery == 'smtp') {
				// Check configurations
	            foreach($emailConfigurations as $name => $value){
	            	if(!empty($value)){
	                	$configurations[$name] = $value;
	                }
	           	}
	           	// Put email options
            	$this->Email->smtpOptions = $configurations;
            }

            // Required parameter, will use app default if not set
            if(!empty($data['from'])){
                $this->Email->from = trim($data['from']);
            } else {
                $this->Email->from = $this->appConfigurations['name'].' <'.$this->appConfigurations['email'].'>';
            }

            // Required parameter, will return false if not set
            if(!empty($data['to'])){
                $this->Email->to = trim($data['to']);
                $this->set('recipient', $this->Email->to);
            }else{
                $this->log('_sendMail(), the \'to\' parameter cannot be empty');
                return false;
            }

            // Required parameter, will return false if not set
            if(!empty($data['subject'])){
                $this->Email->subject = trim($data['subject']);
            }else{
                $this->log('_sendMail(), the \'subject\' parameter cannot be empty');
                return false;
            }

            // Required parameter, will return false if not set
            if(!empty($data['template'])){
                $this->Email->template = $data['template'];
            }else{
                $this->log('_sendMail(), the \'template\' parameter cannot be empty');
                return false;
            }

            // Optional, I will use both if main conf/passed data empty
            if(!empty($data['sendAs'])){
                $this->Email->sendAs = $data['sendAs'];
            }else{
                if(!empty($emailConfigurations['sendAs'])){
                    $this->Email->sendAs = $emailConfigurations['sendAs'];
                }else{
                    $this->Email->sendAs = 'both';
                }
            }

            // Optional, I will use default if empty
            if(!empty($data['layout'])){
                $this->Email->layout = $data['layout'];
            }else{
                if(!empty($emailConfigurations['layout'])) {
                    $this->Email->layout = $emailConfigurations['layout'];
                }else{
                    $this->Email->layout = 'default';
                }
            }

            // Optional, can be empty
            if(!empty($data['cc'])){
                if(is_array($data['cc'])){
                    foreach($data['cc'] as $key => $address){
                        // Trim address from any whitespace
                        $data['cc'][$key] = trim($address);
                    }
                }else{
                    $this->Email->cc = trim($data['cc']);
                }
            }

            // Optional, can be empty
            if(!empty($data['bcc'])){
                if(is_array($data['bcc'])){
                    foreach($data['bcc'] as $key => $address){
                        $data['bcc'][$key] = trim($address);
                    }
                }else{
                    $this->Email->cc = trim($data['bcc']);
                }
            }

            // Set the data to template
            $this->set('data', $data);
            // Send the email
            if($this->Email->send()){
				// Reset email after sending
				$this->Email->reset();
                return true;
            }else{
                if($this->Email->delivery == 'smtp'){
                    $this->log(sprintf('_sendMail(), sending email failed. %s', $this->Email->smtpError));
                }else{
                    $this->log('_sendMail(), sending email failed.');
                }
                return false;
            }
        }else{
            $this->log('_sendMail(), data parameter required.');
            return false;
        }
    }

    function _sendBulkEmail($data, $delay = 100){
        if(!empty($data)){
            // If the to is array then loop through recipient
            if(is_array($data['to'])){
                $recipients = $data['to'];

                // Loop through recipient
                foreach($recipients as $recipient){
                    // Trim the data, remove the whitespace
                    $data['to'] = trim($recipient);

                    // Send the email
                    $this->_sendEmail($data);

                    // Reseting email before sending again
                    $this->Email->reset();

                    // Delay the email sending
                    usleep($delay);
                }
            }else{
                // Put in to temporary variable
                $recipients = $data['to'];

                // Split up the recipient in case user enter
                // the recipient as comma separated value
                $recipients = preg_split('/[\s,]/', $recipients);

                // Loop through recipient after split
                foreach($recipients as $key => $recipient){

                    // Remove the whitespace from recipient address, if any
                    $recipients[$key] = trim($recipient);
                }

                // Put back the recipient as an array
                $data['to'] = $recipients;

                // Recursive call
                $this->_sendBulkEmail($data);
            }
        }else{
            return false;
        }
    }

	/**
	 * Function to get price rate used for beforeSave and afterFind
	 *
	 * @return float The rate which user choose
	 */
	function _getRate(){
		$currency = strtolower($this->appConfigurations['currency']);
		$rate = Cache::read('currency_'.$currency.'_rate');

		if(!empty($rate)){
			return $rate;
		} else {
			$country = $this->Currency->find('first', array('fields' => 'rate', 'conditions' => array('Currency.currency' => $currency)));

			if(!empty($country)){
				Cache::write('currency_'.$currency.'_rate', $country['Currency']['rate']);
				return $country['Currency']['rate'];
			} else {
				return 1;
			}
		}
	}
        
    function captcha(){
            //comment out the code below if the captcha doesn't render on localhost,For Unix/Linux Servers it works fine.
            $this->Captcha->configCaptcha(array(
             'pathType'=>2,
              'quality'=>3,
                'maxLength'=>5,//min. word length
                'minLength'=>5,//min. word length
             ));
        $this->Captcha->getCaptcha();
    }
}
?>
