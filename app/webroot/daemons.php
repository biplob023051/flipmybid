<?php
// use this file if the normal cron jobs don't work

switch($_GET['type']){
	case 'bidbutler':
		require '../daemons/bidbutler.php';
	break;

	case 'extend':
		require '../daemons/extend.php';
	break;

	case 'close':
		require '../daemons/close.php';
	break;

	case 'daily':
		require '../daemons/daily.php';
	break;
}
?>
