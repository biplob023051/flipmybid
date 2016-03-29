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

	<?php
		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
		echo $javascript->link('default');
		echo $javascript->link('jquery.prettyPhoto.js');
	?>

    <script>
	$(function(){
		$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'facebook', slideshow:4000, social_tools: false, autoplay_slideshow: false});
	});
	</script>

</head>

<body>

	<noscript class="hide" id="noscript">
	<p>This site requires Javascript to function correctly.<br />
		Please <a target="_blank" href="http://enable-javascript.com/">enable Javascript in your browser!</a></p>
	</noscript>

	<div id="header">
		<div id="header-inner-big">
			<h1>flip <span id="my">my</span> <span id="bid">bid</span></h1>
		</div>
	</div>

	<div class="rounded offline">
        <div id="tabs">
            <h2>PayPal Test</h2>
        </div>
		
        <div class="o-content">
			<p>5 Bid Credits:
			<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=buchan.andrew.uk@gmail.com" 
    data-button="buynow" 
    data-name="5 Bid Credits" 
    data-quantity="1" 
    data-amount="5.00" 
    data-currency="GBP" 
    data-shipping="0.00" 
    data-tax="0.00"
	data-callback="http://www.flipmybid.com/paypaltest"
></script></p>
			
			
		</div>

	</div>

</body>
</html>