<?php
    uses('L10n');
    Configure::load('config');

    // lets check if the script has been installed!
	if(!Configure::read('Database')) {
		// if not, lets load the installer!!
		header("Location: installer.php");
		exit;
	}

	ini_set('memory_limit', '256M');
?>