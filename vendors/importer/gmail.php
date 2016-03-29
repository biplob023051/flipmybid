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
 *  gmail.com importer class
 */
class gmail extends Importer {
	
	function gmail () {
		$this->setEmailAddress('@gmail.com');
		$this->setName('GMail');
		$this->init();
		$this->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MEGAUPLOAD 2.0)";		
	}
	
	function run($login, $password) {

		$this->generateCookie ('gmail');
		$this->login = urlencode($login);
		$this->password = urlencode($password);
		
		$params = "accountType=HOSTED_OR_GOOGLE&Email=".$this->login."&Passwd=".$this->password."&service=cp&source=adluo.com";
		
		curl_setopt($this->curl, CURLOPT_URL,'https://www.google.com/accounts/ClientLogin');		
		curl_setopt($this->curl, CURLOPT_REFERER, "");
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($this->curl, CURLOPT_POST, 1);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS,  $params);
		curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);	
		$html = curl_exec($this->curl);	
		
		$auth=substr($html,strpos($html,'Auth=')+strlen('Auth='));
		if(strpos($auth, 'BadAuthentication')===false){			
			curl_setopt($this->curl, CURLOPT_URL,"http://www.google.com/m8/feeds/contacts/default/full?max-results=10000");
			curl_setopt($this->curl,CURLOPT_HTTPHEADER,array (
			"Authorization: GoogleLogin auth=".$auth.""
			));
			curl_setopt($this->curl, CURLOPT_POST,false);
			curl_setopt($this->curl, CURLOPT_HTTPGET ,true);
			curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($this->curl, CURLOPT_USERAGENT, $this->agent);
			curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie_file);
			curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie_file);	
		  	$feed = curl_exec($this->curl);
		  	curl_close ($this->curl);
			unlink($this->cookie_file);
		  	$contacts = array();  
			$doc = new DOMDocument(); 
			$doc->loadXML($feed); 
			$nodeList = $doc->getElementsByTagName( 'entry' );  
			foreach($nodeList as $node) {  
		                $entry_nodes    = $node->childNodes;  
		                $tempArray      = array();  
			        foreach($entry_nodes as $child) {  
					$domNodesName = $child->nodeName;  
					switch($domNodesName) {  
					case "title":  
		                          { $tempArray['fullName'] = $child->nodeValue; }  
		                        	break;  
		                        case "gd:email":  
		                            {  
		                           if (strpos($child->getAttribute('rel'),'home')!==false)  
		                                    $tempArray['email_1']=$child->getAttribute('address');  
		                           elseif(strpos($child->getAttribute('rel'),'work')!=false)  
		                                    $tempArray['email_2']=$child->getAttribute('address');  
		                            elseif(strpos($child->getAttribute('rel'),'other')!==false)  
		                                    $tempArray['email_3']=$child->getAttribute('address');  
		                            }  
		                        break;  
		                    }   //end of switch for nodeNames  
		                }   //end of foreach for entry_nodes child nodes  
		                if( !empty($tempArray['email_1'])) $contacts[$tempArray['email_1']] = $tempArray;  
		                if( !empty($tempArray['email_2'])) $contacts[$tempArray['email_2']] = $tempArray;  
		                if( !empty($tempArray['email_3'])) $contacts[$tempArray['email_3']] = $tempArray;  
	            	}
	            	$returnnames = array();
	            	$returnemails = array();
	            	foreach ($contacts as $email=>$name){
	            		$returnemails[]=$email;
	            		$returnnames[]=$name['fullName'];
	            	}
			return array($returnnames, $returnemails);
			
		}else{
			curl_close ($this->curl);
			unlink($this->cookie_file);
			return 1;
		}
		
	}
}
?>