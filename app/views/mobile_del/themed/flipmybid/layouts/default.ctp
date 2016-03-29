<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $html->charset(); ?>

	<title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>

	<?php if(!empty($refresh) && !empty($appConfigurations['timeout'])) : ?>
		<?php if($session->check('Auth.User')):?>
			<meta http-equiv="refresh" content="<?php echo $appConfigurations['timeout']; ?>;url=<?php echo $refresh; ?>" />
		<?php else : ?>
			<meta http-equiv="refresh" content="<?php echo $appConfigurations['timeout']; ?>;url=/auctions/timeout/<?php echo base64_encode($refresh); ?>" />
		<?php endif; ?>
	<?php endif; ?>

	<link rel="shortcut icon" href="/theme/flipmybid/img/icons/favicon.ico" />

	<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
	?>

	<?php echo $html->css('main'); ?>
    <?php echo $html->css('prettyPhoto'); ?>
	<?php echo $html->css('cookiebar'); ?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

	<!--[if IE 8]>
		<?php echo $html->css('ie8'); ?>
    <![endif]-->

	<?php
		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
		echo $javascript->link('default');
		echo $javascript->link('jquery.prettyPhoto.js');
		echo $javascript->link('cookiebar');
		echo $javascript->link('facebooklogin');
	?>
	<style>
		#rankdialog
		{
			display: none;
		}
	</style>
	<script>
		$(document).ready(function()
		{
			$("#rankdialog").dialog({autoOpen : false, modal : false});
			
			$("#openrankdialog").on('click', function()
			{
				$("#rankdialog").dialog("open");
				return false;
			});
			
			$('#biddialog').dialog({autoOpen : false, modal : false});
			$('#openbidpointsdialog').on('click', function()
			{
				$('#biddialog').dialog("open");
				return false;
			});
		});
	</script>
	
	<script>
		$(document).ready(function()
		{
			cookiebar();
		});
	</script>

    <script>
	$(function(){
		$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook', slideshow:4000, social_tools: false, autoplay_slideshow: false});
	});
	</script>

	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-35208163-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
</head>

<body>
<div id="fb-root"></div>
<div id="cBanner">
	This website uses cookies. By continuing to browse our site you accept our <a href="http://www.flipmybid.com/page/cookie-policy">Cookie Policy</a><a href="#" style="float: right; color: white; font-size: 18px; margin-right: 10px;" onclick="allowCookie();">X</a>
</div>

<noscript class="hide" id="noscript">
<p>This site requires Javascript to function correctly.<br />
	Please <a target="_blank" href="http://enable-javascript.com/">enable Javascript in your browser!</a></p>
</noscript>

<?php echo $this->element('header'); ?>

<div class="container clearfix">
	<div class="content">

		<?php
			if($session->check('Message.flash')){
				echo $session->flash();
			}

			if($session->check('Message.auth')){
				echo $session->flash('auth');
			}
		?>
		<?php echo $content_for_layout; ?>
    </div>
</div>

<?php echo $this->element('footer'); ?>

</body>
</html>