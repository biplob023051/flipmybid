<?php
if(empty($_GET['switch'])) {
	$_GET['switch'] = 'intro';
}

switch($_GET['switch']) {
	case 'intro':
		?>
		<h1>Welcome to the Penny Auction Code Installer!</h1>

		<p>This guide will help you through installing the Penny Auction Code script!  If you need any assistance please visit our website at <a href="http://www.innosoft.co.nz" target="_blank">www.innosoft.co.nz</p>

		<p><a href="installer.php?switch=requirements">Lets start by checking the requirements >></a></p>
		<?php
	break;

	case 'requirements':
		?>
		<h1>Server Requirements!</h1>

		<p>The following are required in order to run this script successfully:</p>
		<ul>
			<li>PHP 5</li>
			<li>MYSQL 5</li>
			<li>Curl Installed</li>
			<li>Cron Jobs</li>
			<li>Ideally CPANEL as the control panel</li>
		</ul>

		<p><a href="installer.php?switch=license">Next Step >></a></p>
		<?php
	break;

	case 'license':
		?>
		<h1>License Agreement</h1>

		<p>Please ensure you have read and accept the terms and conditions before you continue from this point.</p>

		<p><a href="installer.php?switch=database">You have read and agree to our terms and conditions >></a></p>
		<?php
	break;

	case 'database':
		?>
		<h1>Creating the Database</h1>

		<p>The SQL for the database is located at <strong>app/config/sql/sql.sql</strong></p>

		<p>Simply dump this SQL file into your database.  Ensure you remember your database name, username and password.</p>

		<p>Once your database is installed click continue below.</p>

		<p><a href="installer.php?switch=config">Continue >></a></p>
		<?php
	break;

	case 'config':
		?>
		<h1>Creating the Config File</h1>

		<?php if(!empty($_GET['error'])) : ?>
			<strong>There is a problem!  You have pressed continue below however your config.php file does not exist!</strong>
		<?php endif; ?>

		<p>The config file is located at <strong>app/config/config.default.php</strong></p>

		<p>You need to rename this file to <strong>app/config/config.php</strong> and enter add in the variables for your website.</p>

		<p>This includes the database details from your newly created database above.</p>

		<p>Once the config file is click created continue below.</p>

		<p><a href="installer.php?switch=chmod">Continue >></a></p>
		<?php
	break;

	case 'chmod':
		// lets check that the config file now exists!
		if(!file_exists('../config/config.php')) {
			// if not, lets load the installer!!
			header("Location: installer.php?switch=config&error=1");
			exit;
		}
		?>
		<h1>File Permissions</h1>

		<p>Please set the permissions of the following files to <strong>777</strong></p>

		<p>/app/tmp<br />
		/app/tmp/cache<br />
		/app/tmp/cache/models<br />
		/app/tmp/cache/persistant<br />
		/app/tmp/cache/views<br />
		/app/tmp/logs<br />
		/app/webroot/img/files<br />
		/app/webroot/img/category_images<br />
		/app/webroot/img/category_images/max<br />
		/app/webroot/img/category_images/thumbs<br />
		/app/webroot/img/product_images<br />
		/app/webroot/img/product_images/max<br />
		/app/webroot/img/product_images/thumbs</p>

		<p>Under the folder app/locale for each language, e.g. eng, spa, fre etc click on the folder and set the permissions of the LC_MESSAGES folder to <strong>777</strong>.<br />
		e.g. app/locale/eng/LC_MESSAGES
		</p>

		<p>Once done click continue below.</p>

		<p><a href="installer.php?switch=crons">Continue >></a></p>
		<?php
	break;

	case 'crons':
		?>
		<h1>Cron Jobs</h1>

		<p>Please set the following cron jobs to run every minute.</p>

		<?php
		if(substr($_SERVER['DOCUMENT_ROOT'], -12) == '/app/webroot') {
			$_SERVER['DOCUMENT_ROOT'] = str_replace('/app/webroot', '', $_SERVER['DOCUMENT_ROOT']);
		}

		//1 min:
		// php /home3/flipmybi/public_html/app/daemons/bidbutler.php
		// php /home3/flipmybi/public_html/app/daemons/close.php
		// curl -s -o /dev/null http://www.flipmybid.com/daemons/cleaner
		// curl -s -o /dev/null http://www.flipmybid.com/daemons/winner

		//5min:
		//curl -s -o /dev/null http://www.flipmybid.com/daemons/newsletter

		//daily:
		//php /home3/flipmybi/public_html/app/daemons/daily.php

		?>

		<p>php <?php echo $_SERVER['DOCUMENT_ROOT']; ?>/app/daemons/bidbutler.php<br />
		php <?php echo $_SERVER['DOCUMENT_ROOT']; ?>/app/daemons/close.php<br />
		curl -s -o /dev/null http://<?php echo $_SERVER['HTTP_HOST']; ?>/daemons/cleaner<br />
		curl -s -o /dev/null http://<?php echo $_SERVER['HTTP_HOST']; ?>/daemons/winner</p>

		<p>php <?php echo $_SERVER['DOCUMENT_ROOT']; ?>/app/daemons/daily.php (only needs to be run once a day!)</p>

		<p>curl -s -o /dev/null http://<?php echo $_SERVER['HTTP_HOST']; ?>/daemons/newsletter (run every 5 minutes)</p>

		<p>The following cron jobs are for testing mode only:</p>

		<p>
		php <?php echo $_SERVER['DOCUMENT_ROOT']; ?>/app/daemons/extend.php (run every minute)<br />
		</p>



		<p>Once done click continue below.</p>

		<p><a href="installer.php?switch=complete">Continue >></a></p>
		<?php
	break;

	case 'complete':
		?>
		<h1>Install Complete!</h1>

		<p>The installation is complete!  You can now login using:</p>

		<p>Username: <strong>admin</strong><br />
		   Password: <strong>password</strong>
		</p>

		<p>This is an Admin account.  Once you have logged in please change the password for security reasons.</p>

		<p>We recommend for security reasons that you now delete the file <strong>app/webroot/installer.php</strong>.  It is no longer required</p>

		<p><a href="/">Visit the website >></a></p>
		<?php
	break;
}
?>