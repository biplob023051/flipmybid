<?php
    // Include the config
    require_once '../config/config.php';

	// Include the functions
	require_once '../getstatus_functions.php';

    // Setup the timezone
	$timezone = get('time_zone');
	if(!empty($timezone)){
		date_default_timezone_set($timezone);
	}

    $format = "F d, Y H:i:s";
    if(!empty($_GET['format'])){
        $format = strip_tags($_GET['format']);
    }
    echo date($format);
?>