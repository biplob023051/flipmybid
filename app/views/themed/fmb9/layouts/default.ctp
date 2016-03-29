<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>
	<link rel="shortcut icon" href="/theme/flipmybid/img/icons/favicon.ico" />
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
    <!--<![endif]-->	
	<?php echo $html->css('styles'); ?>
	<?php echo $html->css('hamburger'); ?>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <script data-cfasync="false" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script data-cfasync="false" src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script data-cfasync="false" src="http://www.flipmybid.com/theme/fmb9/js/hamburger.js"></script>
	 <link rel="stylesheet" type="text/css" media="screen and (min-device-width: 500px)" href="http://www.flipmybid.com/theme/fmb9/css/desktop.css" />
	 <link rel="stylesheet" type="text/css" media="screen and (min-width: 1px) and (max-width: 499px)" href="css/hamburger.css" />
</head>

<body>
<div class="pure-g header">
<div id="center">
<?php echo $this->element('header'); ?>
</div>
</div>
<div class="pure-g container">
<div id="center">
<?php echo $content_for_layout; ?>
</div>
</div>

<?php echo $this->element('footer'); ?>




</body>
</html>