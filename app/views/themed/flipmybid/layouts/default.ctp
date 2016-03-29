<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>
    <?php if (!empty($refresh) && !empty($appConfigurations['timeout'])) : ?>
        <?php if ($session->check('Auth.User')): ?>
            <meta http-equiv="refresh"
                  content="<?php echo $appConfigurations['timeout']; ?>;url=<?php echo $refresh; ?>"/>
        <?php else : ?>
            <meta http-equiv="refresh"
                  content="<?php echo $appConfigurations['timeout']; ?>;url=/auctions/timeout/<?php echo base64_encode($refresh); ?>"/>
        <?php endif; ?>
    <?php endif; ?>

    <link rel="shortcut icon" href="/theme/flipmybid/img/icons/favicon.ico"/>

    <?php
    if (!empty($meta_description)) :
        echo $html->meta('description', $meta_description);
    endif;
    if (!empty($meta_keywords)) :
        echo $html->meta('keywords', $meta_keywords);
    endif;
    ?>

    <?php echo $html->css('bootstrap.min'); ?>
    <?php echo $html->css('main_r30'); ?>
    <?php echo $html->css('prettyPhoto'); ?>
    <?php echo $html->css('cookiebar_r30'); ?>
    <?php echo $html->css('bootstrap.adapt_r35'); ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

    <!--[if IE 8]>
    <?php echo $html->css('ie8'); ?>
    <![endif]-->

    <?php
    //echo $javascript->link('jquery/jquery');
    echo $javascript->link('jquery-1.11.3.min');
    echo $javascript->link('jquery-ui.min');
    echo $javascript->link('default_r36');
    echo $javascript->link('jquery.prettyPhoto.js');
    echo $javascript->link('cookiebar_r30');
    echo $javascript->link('facebooklogin_r1');
    echo $javascript->link('bootstrap.min');
    echo $javascript->link('additional_r37');
    echo $javascript->link('chart.min');
    ?>
    <style>
        #rankdialog {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function () {
            $("#rankdialog").dialog({autoOpen: false, modal: false});

            $("#openrankdialog").on('click', function () {
                $("#rankdialog").dialog("open");
                return false;
            });

            $('#biddialog').dialog({autoOpen: false, modal: false});
            $('#openbidpointsdialog').on('click', function () {
                $('#biddialog').dialog("open");
                return false;
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            cookiebar();
        });
    </script>

    <script>
        $(function () {
            $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({
                animation_speed: 'normal',
                theme: 'facebook',
                slideshow: 4000,
                social_tools: false,
                autoplay_slideshow: false
            });
        });
    </script>

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-35208163-1']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>

<body style="width:100%;overflow:hidden;">
<noscript class="hide" id="noscript">
    <p>This site requires Javascript to function correctly.<br/>
        Please <a target="_blank" href="http://enable-javascript.com/">enable Javascript in your browser!</a></p>
</noscript>
<div id="fb-root"></div>
<!--<div id="loading-full" style="display: none;">-->
<!--    <div id="loading-text">If nothing happens, try to enable pop up windows in your browser</div>-->
<!--</div>-->
<div id="cBanner">This website uses cookies. By continuing to browse our site you accept our
    <a href="http://www.flipmybid.com/page/cookie-policy">Cookie Policy</a>
    <a href="#" style="float: right; color: white; font-size: 18px; margin-right: 10px;" onclick="allowCookie();">X</a>
</div>


<!-- Full Width Header -->
<header class="full-width">
    <div class="container-fluid" style="width:100%;padding:0;">
        <?php echo $this->element('header'); ?>
    </div>
</header>

<!-- Page Content -->
<div class="container-fluid" id="page-content">
    <div class="col-sm-12">
    <?php
    if ($session->check('Message.flash')) {
        echo $session->flash();
    }

    if ($session->check('Message.auth')) {
        echo $session->flash('auth');
    }
    ?>
    </div>

    <?php echo $content_for_layout; ?>
</div>
<!-- /.container -->

<!-- Full Width Footer -->
<footer class="full-width">
    <?php echo $this->element('footer'); ?>
</footer>
</body>
</html>