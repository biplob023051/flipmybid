<?php
	Configure::write('log', true);
	define('LOG_ERROR', 2);

	// this is overwritten by the database settings
	Configure::write('debug', 2);

	Configure::write('Routing.prefixes', array('admin'));

	$session = array(
		'save' => 'php',
		'cookie' => 'AUCTION',
		'timeout' => '900',
		'start' => true,
		'checkAgent' => true,
		'table' => 'cake_sessions',
		'database' => 'default'
	);
	Configure::write('Session', $session);

	$security = array(
		'level' => 'medium',
		'salt' => '07a6b2214c954ba069dbf8196d315f83a30baef9',
		'cipherSeed' => '290586346792384390734907'
	);
	Configure::write('Security', $security);

	//Configure::write('Asset.filter.css', 'css.php');
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

	//Configure::write('Acl.classname', 'DbAcl');
	//Configure::write('Acl.database', 'default');

	//Cache::config('default', array('engine' => 'File'));

	// File engine caching
	// minute
	Cache::config('minute', array(
    	'engine' => 'File',
     	'duration'=> 60,
     	'probability'=> 100,
     	'path' => CACHE,
     	'prefix' => 'cake_',
     	'lock' => false,
     	'serialize' => true)
 	 );
 	 // short
	 Cache::config('short', array(
    	'engine' => 'File',
     	'duration'=> 600,
     	'probability'=> 100,
     	'path' => CACHE,
     	'prefix' => 'cake_',
     	'lock' => false,
     	'serialize' => true)
 	 );
 	 // hourly
 	 Cache::config('hourly', array(
    	'engine' => 'File',
     	'duration'=> '+1 hour',
     	'probability'=> 100,
     	'path' => CACHE,
     	'prefix' => 'cake_',
     	'lock' => false,
     	'serialize' => true)
 	 );
 	 // medium
 	 Cache::config('medium', array(
     	'engine' => 'File',
     	'duration'=> '+1 day',
     	'probability'=> 100,
     	'path' => CACHE,
     	'prefix' => 'cake_',
     	'lock' => false,
     	'serialize' => true)
 	);
 	// long
 	Cache::config('long', array(
    	'engine' => 'File',
     	'duration'=> '+1 week',
     	'probability'=> 100,
     	'path' => CACHE,
     	'prefix' => 'cake_',
     	'lock' => false,
     	'serialize' => true)
 	);
 	// default = medium
 	Cache::config('default', Cache::settings('minute'));
?>
