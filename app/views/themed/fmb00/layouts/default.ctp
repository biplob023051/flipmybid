<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>

	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="shortcut icon" href="/theme/fmb00/img/icons/favicon.ico">
	
    <link href="/theme/fmb00/css/bootstrap.min.css" rel="stylesheet">
    <link href="/theme/fmb00/css/slider-pro.min.css" rel="stylesheet">
    <link href="/theme/fmb00/css/style.css" rel="stylesheet">
    <script data-cfasync="false" src="/theme/fmb00/js/jquery.min.js"></script>
    <script data-cfasync="false" src="/theme/fmb00/js/bootstrap.min.js"></script>
    <script data-cfasync="false" src="/theme/fmb00/js/cookiebar.js"></script>
    <script data-cfasync="false" src="/theme/fmb00/js/jquery.sliderPro.min.js"></script>
    <script data-cfasync="false" src="/theme/fmb00/js/scripts.js"></script>
	<script data-cfasync="false" type="text/javascript">
		$(document).ready(function(){
			cookiebar({});
			$('.stop-propagation').on('click', function (e) {e.stopPropagation();});
		});
	</script>
<script data-cfasync="false" type="text/javascript">
    jQuery( document ).ready(function( $ ) {
        $( '#my-slider' ).sliderPro({
		autoplay: true,
		width: '100%',
		height: 250,
		});
    });
</script>
</head>
<body>
<div class="container-fluid cc">

<div id="cBanner">This website uses cookies. By continuing to browse our site you accept our <a href="http://www.flipmybid.com/page/cookie-policy">Cookie Policy</a><a href="#" style="float: right; color: white; font-size: 18px; margin-right: 10px;margin-top:-4px;" onclick="allowCookie();">X</a></div>

<!-- navbar start -->
<?php echo $this->element('header'); ?>
<!-- navbar end -->

<!-- main start -->
<div class="row cc">
<div class="container">
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
<!-- main end -->

<!-- footer start -->
<?php echo $this->element('footer'); ?>
<!-- footer end -->
</div>


</body>
</html>


