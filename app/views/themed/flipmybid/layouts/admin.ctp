<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> -
        <?php echo $appConfigurations['name']; ?>
	</title>
	<?php
	 	echo $html->css('bootstrap.min');
		echo $html->meta('icon');
		echo $html->css('admin/style');
		//echo $html->css('bootstrap.adapt');
		echo $html->css('/theme/flipmybid/css/bootstrap.adapt_r35');
    ?>
        <!--[if lt IE 7]>
            <?php echo $html->css('admin-ie'); ?>
        <![endif]-->
    <?php
	//echo $javascript->link('jquery/jquery');
	echo $javascript->link('jquery-1.11.3.min');
        echo $javascript->link('jquery/ui');
        echo $javascript->link('admin');
		echo $javascript->link('bootstrap.min');
		echo $javascript->link('chart.min');
		echo $scripts_for_layout;
	?>

	<script type="text/javascript">
        sfHover = function() {
			if(document.getElementById("nav")){
				var sfEls = document.getElementById("nav").getElementsByTagName("LI");
				for (var i=0; i<sfEls.length; i++) {
					sfEls[i].onmouseover=function() {
						this.className+=" sfhover";
					}
					sfEls[i].onmouseout=function() {
						this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
					}
				}
			}
        }
        if (window.attachEvent) {
            window.attachEvent("onload", sfHover);
        }
    </script>

</head>
<body>
<!-- Full Width Header -->
<nav class="navbar navbar-default navbar-admin">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">
				<span id="logo-flip">flip</span>
				<span id="logo-my">my</span>
				<span id="logo-bid">bid</span>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php echo $this->element('admin/menu');?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php echo $this->element('admin/menu_top');?>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<!-- Page Content -->
<div class="container-fluid" id="content_content">
	<div class="col-sm-12">
		<?php
		if($session->check('Message.flash')){
			echo $session->flash();
		}

		if($session->check('Message.auth')){
			echo $session->flash('auth');
		}
		?>
	</div>

	<?php echo $content_for_layout; ?>
</div>
<!-- /.container -->

<!-- Full Width Footer -->
<footer class="full-width" id="footer">
	<?php echo $this->element('admin/footer'); ?>
</footer>

</body>
</html>
