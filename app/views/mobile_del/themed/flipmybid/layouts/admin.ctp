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
		echo $html->meta('icon');
		echo $html->css('admin/style');
    ?>
        <!--[if lt IE 7]>
            <?php echo $html->css('admin-ie'); ?>
        <![endif]-->
    <?php
        echo $javascript->link('jquery/jquery');
        echo $javascript->link('jquery/ui');
        echo $javascript->link('admin');
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
	<div id="container">
		<div id="header" class="clearfix">
			<div class="container">
				<div class="logo">
                	<a href="/admin">
                    	flip
						<span id="my">my</span>
						<span id="bid">bid</span>
                    </a>
				</div>

				<div class="top-links">
						<?php echo $this->element('admin/menu_top');?>
				</div>

				<?php echo $this->element('admin/menu');?>
			</div>
		</div>

		<div id="content">
            <div id="content_content">
			<?php
				if($session->check('Message.flash')){
					echo $session->flash();
				}

				if($session->check('Message.auth')){
					echo $session->flash('auth');
				}
			?>
			<?php echo $content_for_layout; ?>
            <div class="clearfix"></div>
            </div>
		</div>
		<div id="footer" class="clearfix">&nbsp;</div>
	</div>
</body>
</html>
