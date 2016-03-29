<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>

	<title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>

	<link rel="shortcut icon" href="/img/favicon.ico" />

	<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
	?>

	<?php echo $html->css('style'); ?>
	<?php echo $html->css('superfish'); ?>
	<?php echo $html->css('facebox'); ?>
	<?php echo $html->css('timeout'); ?>

	<?php
		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
		echo $javascript->link('default');
		echo $javascript->link('superfish');
		echo $javascript->link('cufon');
		echo $javascript->link('HelveticaNeue_LT_57_Cn_400.font');
		echo $javascript->link('facebox');
	?>

	<script type="text/javascript">
		Cufon.replace('#left h3, #right h1, #right h2, #right h3', { fontFamily: 'HelveticaNeue LT 57 Cn' });
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loadingImage : '/img/facebox/loading.gif',
			closeImage   : '/img/facebox/closelabel.gif'
		  })
		})
	</script>

	<?php echo $this->element('live_support'); ?>

    <!--[if lt IE 7]>
		<?php echo $html->css('ie6'); ?>
        <?php echo $javascript->link('DD_belatedPNG_0.0.7a'); ?>
        <script>
            DD_belatedPNG.fix('div, img, h3, li, a');
        </script>
    <![endif]-->
	<?php echo $scripts_for_layout; ?>

    <!-- Sliding Login Effects -->
	<script src="/js/slide.js" type="text/javascript"></script>
  	<link rel="stylesheet" href="/css/slide.css" type="text/css" media="screen" />
    <!-- Sliding effect -->
</head>

<body>
<?php echo $this->element('slider'); ?>
<div id="headerblock"></div><div id="wrap"><div id="header">
<h1><a href="/"><span><?php echo $appConfigurations['name']; ?></span></a></h1>
<?php echo $this->element('search'); ?>
</div>
<!-- header -->

<?php echo $this->element('menu_top'); ?>
		<center><?php
			if($session->check('Message.flash')){
				echo $session->flash();
			}

			if($session->check('Message.auth')){
				echo $session->flash('auth');
			}
		?></center>
<div id="adspace">
	<?php $banners = $this->requestAction('/banners/get/1'); ?>

	<?php if(!empty($banners)) : ?>
		<?php foreach ($banners as $banner) : ?>
			 <div class="fleft">
				<?php echo $banner['Banner']['code']; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
    <img src="/img/banner.png" width="983px" height="210px" />
</div> <!-- adspace -->

<div id="maincontent">
	<div id="content" class="container">
		<?php echo $content_for_layout; ?>
	</div>
</div></div></div>
<div id="footer">
<?php echo $this->element('footer'); ?>

</div>


</body>
</html>