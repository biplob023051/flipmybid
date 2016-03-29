<?php echo $html->docType('xhtml-strict'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="initial-scale=1.0">
	<?php
	  echo $html->charset('UTF-8');
	  echo $html->meta('icon');
	  echo $html->css('mobile');
	?>
</head>

<body>
	<div><?php echo View::element('header'); ?></div>
	<div><?php echo $content_for_layout; ?></div>
	<div><?php echo View::element('footer'); ?></div>
</body>
</html>