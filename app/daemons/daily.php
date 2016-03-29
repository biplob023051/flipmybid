<?php
$start = microtime();

ini_set('memory_limit', '256M');

// lets get the directory
if(defined('STDIN')) {
	$dir = str_replace('/daemons/daily.php', '', $_SERVER['SCRIPT_FILENAME']);
} else {
	if(substr($_SERVER['DOCUMENT_ROOT'], -12) == '/app/webroot') {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('/app/webroot', '', $_SERVER['DOCUMENT_ROOT']);
	}
	$dir = $_SERVER['DOCUMENT_ROOT'].'/app';
}

// Include the config file
require_once $dir.'/config/config.php';

// call the database
require_once $dir.'/database.php';

// Include the functions
require_once $dir.'/daemons_functions.php';

// Include some get status functions
require_once $dir.'/getstatus_functions.php';

// Setup the timezone
$timezone = get('time_zone');
if(!empty($timezone)){
	date_default_timezone_set($timezone);
}

// get the cron time
$cronTime = get('cron_time');

session_start();

// Get the peak
$isPeakNow = 1;

if(cacheRead('cake_daily.pid')) {
	return false;
} else {
	cacheWrite('cake_daily.pid', microtime(), 86000);
}

ini_set('max_execution_time', 0);

$return = null;

$tables  = array('auctions', 'users', 'products', 'bids', 'bidbutlers');
foreach ($tables as $table) {
	$result = mysql_query('SELECT * FROM '.$table);
	$num_fields = mysql_num_fields($result);
	$return.= 'DROP TABLE '.$table.';';
	$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
	$return.= "\n\n".$row2[1].";\n\n";
	for ($i = 0; $i < $num_fields; $i++)  {
		while($row = mysql_fetch_row($result)) {
			$return.= 'INSERT INTO '.$table.' VALUES(';
			for($j=0; $j<$num_fields; $j++) {
				$row[$j] = addslashes($row[$j]);
				$row[$j] = ereg_replace("\n","\\n",$row[$j]);
				if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
				if ($j<($num_fields-1)) { $return.= ','; }
			}
			$return.= ");\n";
		}
	}
	$return.="\n\n\n";
}

$handle = fopen($dir.'/tmp/backups/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
fwrite($handle,$return);
fclose($handle);

if(isset($db)) {
	mysql_close($db);
}
?>