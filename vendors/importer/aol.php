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
 *  aol.com importer class
 */
class aol extends Importer {
	
	function aol () {
		$this->setEmailAddress('@aol.com');
		$this->setName('AOL');
		$this->init();
		
		$this->agent = 'Mozilla/4.1 (compatible; MSIE 5.0; Symbian OS; Nokia 3650;424) Opera 6.10  [en]';	
	}
	
	function run($login, $password) {
		$this->generateCookie ('aol');
		$this->login = $login;
		$this->password = $password;
		
		$this->login=(strpos($this->login,'@aol')!==false?str_replace('@aol.com','',$this->login):$this->login);
		
		curl_setopt($this->curl, CURLOPT_URL,"https://my.screenname.aol.com/_cqr/login/login.psp?sitedomain=sns.webmail.aol.com&lang=en&locale=us&authLev=0&uitype=mini&siteState=ver%3a4|rt%3aSTANDARD|at%3aSNS|ld%3awebmail.aol.com|uv%3aAOL|lc%3aen-us|mt%3aAOL|snt%3aScreenName|sid%3a22e31aa7-4747-4133-9015-842e000780b6&seamless=novl&loginId=&_sns_width_=174&_sns_height_=196&_sns_fg_color_=373737&_sns_err_color_=C81A1A&_sns_link_color_=0066CC&_sns_bg_color_=FFFFFF&redirType=js&xchk=false");
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_REFERER, "");
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		$html = curl_exec($this->curl);	
	
		preg_match('/<form name="AOLLoginForm".*?action="([^"]*).*?<\/form>/si', $html, $matches);
		$opturl = $matches[1];
		$hiddens = array();
		preg_match_all('/<input type="hidden" name="([^"]*)" value="([^"]*)".*?>/si', $matches[0], $hiddens);
		$hiddennames = $hiddens[1];
		$hiddenvalues = $hiddens[2];
		$hcount = count($hiddennames);
		$params = "";
		for($i=0; $i<$hcount; $i++)
		{
			$params .= $hiddennames[$i]."=".($hiddenvalues[$i])."&";
		}		
		curl_setopt($this->curl, CURLOPT_URL, "https://my.screenname.aol.com/_cqr/login/login.psp");
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params . "loginId=".($this->login)."&password=".($this->password) );
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);		
		$html = curl_exec($this->curl);
		
		if(!preg_match("/'false', '([^']*)'/si", $html, $matches))
		{
			curl_close ($this->curl);
		    	unlink($this->cookie_file);	
		    	return 1;
		}
		curl_setopt($this->curl, CURLOPT_URL,$matches[1]);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		$html = curl_exec($this->curl);	
		$info = curl_getinfo($this->curl);		
		curl_close ($this->curl);
		
		preg_match('/<input type="hidden" name="user" value="(.*?)" \/>/si', $html, $matches);
		$userId = $matches[1];		
		preg_match("/http:\/\/mail.aol.com\/([^']*)\/en-us\//si", $info['url'], $matches);
		$baseUrl = 'http://mail.aol.com/'.$matches[1].'/en-us/';	//33912-111/aol-6
		
		$this->curl = curl_init();		
		curl_setopt($this->curl, CURLOPT_URL,$baseUrl."AB/addresslist-print.aspx?command=all&sort=FirstLastNick&sortDir=Ascending&nameFormat=FirstLastNick&user=".$userId);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);
		$html = curl_exec($this->curl);	
		$info = curl_getinfo($this->curl);
		
		curl_close ($this->curl);
		unlink($this->cookie_file);				
		preg_match_all('/<span class="fullName">(.*?)<\/span>/', $html, $matches);
		$names = $matches[1];		
		preg_match_all('/<span>Email 1:<\/span> <span>(.*?)<\/span>/', $html, $matches);
		$emails = $matches[1];	
	  	return array($names, $emails);
		
	}
		
}


?>