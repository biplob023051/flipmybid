<?php
App::uses('Controller', 'Controller');
//App::import('Vendor', 'Facebook',array('file'=>'Facebook'.DS.'facebook.php'));

//App::import('Vendor', 'facebook-php-sdk-v4-5.0.0', array(
//		'file' => 'facebook-php-sdk-v4-5.0.0'.DS.'src'.DS.'Facebook'.DS.'Facebook.php')
//);

class FacebookController extends AppController {
 
	public $name = 'Facebook';
	public $uses=array();
 
	public function index(){
		$this->layout=false;
	}
 
	function login()
	{
		echo 'aaa';die;
//		Configure::load('facebook');
//		$appId=Configure::read('Facebook.appId');
		$appId= '449785581872611';
//		$app_secret=Configure::read('Facebook.secret');
		$app_secret='40e2db874aade9a488839c875115097c';
//		$fb = new Facebook\Facebook(array(
//			'app_id' => '449785581872611',
//			'app_secret' => '40e2db874aade9a488839c875115097c',
//			'default_graph_version' => 'v2.5'));

//		$helper = $fb->getRedirectLoginHelper();

//		$loginUrl = $helper->getLoginUrl('http://{your-website}/login-callback.php', $permissions);


//		$facebook = new Facebook(array(
//				'appId'		=>  $appId,
//				'secret'	=> $app_secret,
//				));
//		$loginUrl = $facebook->getLoginUrl(array(
//			'scope'			=> 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
//			'redirect_uri'	=> BASE_URL.'facebook_cps/facebook_connect',
//			'display'=>'popup'
//			));
//		$this->redirect($loginUrl);
   	}
 
	function facebook_connect()
	{
	    Configure::load('facebook');
//		$appId=Configure::read('Facebook.appId');
		$appId= '449785581872611';
//		$app_secret=Configure::read('Facebook.secret');
		$app_secret='40e2db874aade9a488839c875115097c';
 
	   	 $facebook = new Facebook(array(
		'appId'		=>  $appId,
		'secret'	=> $app_secret,
		));
 
	    $user = $facebook->getUser();
		if($user){
			try{
				$user_profile = $facebook->api('/me');
				$params=array('next' => BASE_URL.'facebook_cps/facebook_logout');
				$logout =$facebook->getLogoutUrl($params);
				$this->Session->write('User',$user_profile);
				$this->Session->write('logout',$logout);
			}
			catch(FacebookApiException $e){
				error_log($e);
				$user = NULL;
			}
		}
	   else
	   {
		    $this->Session->setFlash('Sorry.Please try again','default',array('class'=>'msg_req'));
		    $this->redirect(array('action'=>'index'));
	   }
   }
 
   function facebook_logout(){
		$this->Session->delete('User');
		$this->Session->delete('logout');
		$this->redirect(array('action'=>'index'));
   }
}
?>