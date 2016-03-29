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
            <h2>Flip My Bid is Launching Soon!</h2>
        </div>
        <div class="o-content">

		<p>Enter your email address below to pre-register and qualify for free bid credits!</p>

		<div align="center">
			<?php echo $form->create('Page', array('url' => '/contact')); ?>
			<?php echo $form->input('name', array('type' => 'hidden', 'value' => 'Email Sign Up'));?>
			<?php echo $form->input('redirect', array('type' => 'hidden', 'value' => '/'));?>
			<?php echo $form->input('email', array('label' => false, 'before' => 'Email Address: ')); ?>
		    <?php echo $form->submit('Sign Up', array('class'=>'submit', 'div'=>false)); ?>
			<?php echo $form->end(); ?>
		</div>


		</div>

		</div>
</div>

</body>
</html>