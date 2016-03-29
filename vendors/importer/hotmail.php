<?php
/*=============================================================================
|| ##################################################################
||	contact importers 
|| ##################################################################
||	
||	Copyright		: (C) 2007-2008 adluo.com
||	Contact			: support@adluo.com
||
||	- all of source code and files are protected by Copyright Laws. 
||
|| ##################################################################
=============================================================================*/
/**
 *  hotmail.com importer class
 */
class hotmail extends Importer {
	var $curl_get;
	
	function hotmail () {
		$this->setEmailAddress('@hotmail.com');
		$this->setName('Hotmail');
		$this->init();	
	}
	
	function run($login, $password) {
		$this->generateCookie ('hotmail');
		$this->login = $login."@hotmail.com";
		$this->password = $password;
		
		curl_setopt($this->curl, CURLOPT_URL,"https://mid.live.com/si/login.aspx");
		curl_setopt($this->curl, CURLOPT_REFERER, "");
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);	
	  	$html = curl_exec($this->curl);	
	  	preg_match('/action="([^"]+)"/', $html, $matches);
		$opturl = $matches[1];
		
		curl_setopt($this->curl, CURLOPT_URL,"https://mid.live.com/si/".$opturl);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "__ET=&PasswordSubmit=Sign in&LoginTextBox=" . ($this->login) . "&PasswordTextBox=" . ($this->password) . "");
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		$html = curl_exec($this->curl);	
		
		if(!preg_match("/url=([^\"]*)\"/si", $html, $matches))
		{
			curl_close ($this->curl);
			unlink($this->cookie_file);
	  		return 1;
		}
		curl_setopt($this->curl, CURLOPT_URL,$matches[1]);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);	
	  	$html = curl_exec($this->curl);
		  
		curl_setopt($this->curl, CURLOPT_URL,"http://mail.live.com/mail/EditMessageLight.aspx?n=");
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);	
	  	$html = curl_exec($this->curl);
		$info = curl_getinfo($this->curl);
		
		$base_url = str_replace('mail/EditMessageLight.aspx?n=','',$info['url']);
		preg_match('/ContactList.aspx(.*?)\"/si', $html, $matches);
		
		if(isset($matches[1])){
			$url = $base_url.'/mail/ContactList.aspx'.$matches[1];
			curl_setopt($this->curl, CURLOPT_URL,$url);
			curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
			curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);		
			$html = curl_exec($this->curl);
			
			$url = $base_url.'/mail/logout.aspx';
			curl_setopt($this->curl, CURLOPT_URL,$url);
			curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
			curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);		
			curl_exec($this->curl);
			curl_close ($this->curl);
			unlink($this->cookie_file);
			
			$bulkStringArray=explode("['",$html);
			unset($bulkStringArray[0]);
			unset($bulkStringArray[count($bulkStringArray)]);
			$contacts=array();
			$name = '';
			foreach($bulkStringArray as $stringValue)
			{
					$stringValue=str_replace(array("']],","'","]]]]"),'',$stringValue);					
					if ((strpos($stringValue,'0,0,0,')!==false)|| (strpos($stringValue,'\x26\x2364\x3b')!==false))
					{
						if (strpos($stringValue,'0,0,0,')!==false) 
						{
							$tempStringArray=explode(',',$stringValue);
							if (!empty($tempStringArray[2])){ 
								$name=html_entity_decode(urldecode(str_replace('\x', '%', $tempStringArray[2])),ENT_QUOTES, "UTF-8");
							}
						}
						else
						{
								$emailsArray=array();
								$emailsArray=explode('\x26\x2364\x3b',$stringValue);
								
								if (count($emailsArray)>0) 
								{
									
									//get all emails
									$bulkEmails=explode(',',$stringValue);
									
									if (!empty($bulkEmails)) 
									foreach($bulkEmails as $valueEmail)
									{ 
										$email=html_entity_decode(urldecode(str_replace('\x', '%', $valueEmail))); 
										if(!empty($email)) 
										{ 
											$contacts[$email]=array('first_name'=>(!empty($name)?$name:""),'email_1'=>$email);
											$email=false; 
										} 
									}
									$name=false;	
								}	
						}
					}
			}
			foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
			$newemails = array();
			$newnames = array();
			foreach($contacts as $key=>$value)
			{
				$newemails[] = $key;	
				$newnames[] = $value['first_name'];
			}
			
	  		return array($newnames, $newemails);		
		}else{
			curl_close ($this->curl);
			unlink($this->cookie_file);
			return array();
		}		
		
	}
	function isEmail($email)
	{
		return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email);
	}		
}

?>