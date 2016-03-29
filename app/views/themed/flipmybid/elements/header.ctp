<script>

    $(function () {

        $('#a-user').click(function (e) {
            e.preventDefault();
            if ($('.user-down').css('display') == 'none') {
                $('#user').attr('class', 'active');
            }
            else {
                $('#user').attr('class', '');
            }

            $('.user-down').slideToggle();
        });
    });

</script>

<script>

</script>


<?php echo $html->image('menuarrowup.png', array('class' => 'hiddenpic')); ?>
<?php echo $html->image('menuarrowup2.png', array('class' => 'hiddenpic')); ?>

<div class="row" style="margin:0">
    <!--    <div class="col-sm-4" id="logo">-->
    <!--        <h1>-->
    <!--            <a href="/">-->
    <!--                <span id="logo-flip">flip</span>-->
    <!--                <span id="logo-my">my</span>-->
    <!--                <span id="logo-bid">bid</span>-->
    <!--            </a>-->
    <!--        </h1>-->
    <!--    </div>-->
    <div class="col-sm-12" style="padding:0;">
        <nav class="navbar navbar-default">
            <div class="container-fluid" style="padding:0;">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <span id="logo-flip">flip</span>
                        <span id="logo-my">my</span>
                        <span id="logo-bid">bid</span>
                    </a>
                </div>
                <script>
                    function showCollapseBidMenu() {
                        var max = <?php echo $session->read('last_buy') ?>;
                        var current = <?php echo $session->read('true_bids') ?>;
                        if (max <= current) {
                            max = 0;
                        } else {
                            max = max - current;
                        }

                        var options = {
                            segmentShowStroke: false,
                            percentageInnerCutout: 85,
                            responsive: false,
                            showTooltips: false,
                            labelFontFamily: "Arial",
                            labelFontStyle: "normal",
                            labelFontSize: 24,
                            labelFontColor: "#666",
                            labelAlign: 'center'
                        };
                        var data = [
                            {
                                value: current,
                                color: "#FFF",
                                highlight: "#FFE",
                                label: 'Bids',
                                labelColor: 'white',
                                labelFontSize: '16'
                            },
                            {
                                value: max,
                                color: "rgba(255,255,255,.3)",
                                highlight: "rgba(255,255,255,.3)",
                                label: ""
                            }
                        ];
                        if(document.getElementById("myChart") != null){
                            var ctx = document.getElementById("myChart").getContext("2d");
                            new Chart(ctx).Doughnut(data, options);
                        }

//                            var myDoughnut = new Chart(ctx).Doughnut(data,{
//                                animation:true,
//                                responsive: true,
//                                showTooltips: false,
//                                percentageInnerCutout : 70,
//                                segmentShowStroke : false,
//                                labelFontFamily : "Arial",
//                                labelFontStyle : "normal",
//                                labelFontSize : 24,
//                                labelFontColor : "#000",
//                                labelAlign: 'center',
//                                onAnimationComplete: function() {
//
//                                    var canvasWidthvar = $('#myChart').width();
//                                    var canvasHeight = $('#myChart').height();
//                                    //this constant base on canvasHeight / 2.8em
//                                    var constant = 114;
//                                    var fontsize = (canvasHeight/constant).toFixed(2);
//                                    ctx.font=fontsize +"em Verdana";
//                                    ctx.textBaseline="middle";
//                                    var total = 0;
//                                    $.each(data,function() {
//                                        total += parseInt(this.value,10);
//                                    });
//                                    console.log(data[0].value);
//                                    var tpercentage = ((data[0].value/total)*100).toFixed(2)+"%";
//                                    var textWidth = ctx.measureText(tpercentage).width;
//
//                                    var txtPosx = Math.round((canvasWidthvar - textWidth)/2);
//                                    ctx.fillText('aaa', txtPosx, canvasHeight/2);
//                                }
//                            });
                    }
                    $(document).ready(function () {
                        $('#bs-example-navbar-collapse-1').on('shown.bs.collapse', function () {
                            showCollapseBidMenu();
                        });
                    });
                </script>
                <?php if ($session->check('Auth.User')): ?>
                    <div
                        class="collapse navbar-collapse <?php if ($this->params['controller'] == 'users' && $this->params['action'] == 'index'): ?> in <?php endif; ?>"
                        id="bs-example-navbar-collapse-1">
                        <div style="float:left;min-width:100%;">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="menu-username">
                                    <?php echo $session->read('Auth.User.first_name'); ?>
                                    (<?php echo $session->read('Auth.User.username'); ?>)
                                </li>
                                <li>
                                    <div class="clearfix"></div>
                                </li>
                                <li class="center" style="display: inline-block;">
                                    <a class="no-margin" href="/" style="color:#FFF !important;">
                                        <span class="glyphicon menu-glyph glyphicon-home" aria-hidden="true"></span>
                                        Home
                                    </a>
                                </li>
                                <li class="center" style="display: inline-block;">
                                    <a class="no-margin" href="/users" style="color:#FFF !important;">
                                        <span class="glyphicon menu-glyph glyphicon-dashboard"
                                              aria-hidden="true"></span>
                                        Dashboard</a>
                                </li>
                                <li class="center" style="display: inline-block;">
                                    <a class="no-margin" href="/watchlists" style="color:#FFF !important;">
                                        <span class="glyphicon menu-glyph glyphicon-eye-open" aria-hidden="true"></span>
                                        Watchlist
                                    </a>
                                </li>
                                <li class="center" style="display: inline-block;">
                                    <a class="no-margin" href="/points" style="color:#FFF !important;">
                                        <span class="glyphicon menu-glyph glyphicon-gift" aria-hidden="true"></span>
                                        Rewards
                                    </a>
                                </li>
                                <li>
                                    <div class="clearfix"></div>
                                </li>

                                <li>
                                    <div class="col-xs-12" style="padding-bottom:20px;">
                                        <canvas id="myChart" width="270" height="270" style="padding:10px;"></canvas>
                                        <div class="donut-inner">
                                            <h5><?php //echo($session->read('Auth.User.bid_balance')); ?></h5>
                                            <h5><?php echo($session->read('true_bids')); ?></h5>

                                            <span>credits</span>
                                        </div>
                                    </div>
                                    <a><?php //print_r($session->read('Auth.User.bid_balance')); ?></a>
                                    <a><?php //print_r($session->read('Auth.User.membership_id')); ?></a>
                                </li>
                                <li>
                                    <div class="clearfix"></div>
                                </li>
                                <li><a href="/packages" class="green-puchase"
                                       style="color:#FFF !important;margin-bottom:20px;">
                                        Purchase bids</a></li>
                                <li>
                                    <div class="clearfix"></div>
                                </li>
                                <?php if(false && !$session->read('Auth.User.facebook_id')): ?>
                                    <li><a href="#" class="green-puchase fb-connect-button"
                                           style="color:#FFF !important;margin-bottom:20px;">
                                            Connect with facebook</a></li>
                                    <li>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php endif; ?>
                                <li><a href="/users/edit" style="color:#FFF !important;">Edit Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/help" style="color:#FFF !important;">Help</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/users/logout" style="color:#FFF !important;" class="fb-logout-button">Sign Out</a></li>
                            </ul>
                        </div>

                    </div><!-- /.navbar-collapse -->
                <?php if ($this->params['controller'] == 'users' && $this->params['action'] == 'index'): ?>
                    <script>
                        showCollapseBidMenu();
                    </script>
                <?php endif; ?>
                <?php else: ?>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div style="float:left;min-width:100%;">
                            <div class="col-md-5 col-lg-4 col-sm-12" id="hamburger-login">
                                <div class="col-sm-12 text-center" id="hamburger-login-text">
                                    <span >LOG IN TO YOUR ACCOUNT</span>
                                </div>
                                <div class="col-sm-12">
                                    <?php echo $form->create('User', array('action' => 'login')); ?>
                                    <?php echo $form->input('username', array(
                                        'id' => 'loginUsername',
                                        'error' => false,
                                        'div' => false,
                                        'label' => false,
                                        'placeholder' => 'Username',
                                        'class' => 'textbox nav-menu-link',
                                        'value' => __('username', true),
                                        'onclick' => 'this.value=\'\''));
                                    ?>
                                    <?php echo $form->input('password', array(
                                        'id' => 'loginPassword',
                                        'error' => false,
                                        'div' => false,
                                        'label' => false,
                                        'placeholder' => 'Password',
                                        'class' => 'textbox password nav-menu-link',
                                        'value' => __('password', true),
                                        'onclick' => 'this.value=\'\''));
                                    ?>
                                    <?php echo $form->submit('Login', array(
                                        'div' => false,
                                        'class' => 'nav-menu-link-submit btn btn-primary green-puchase',
                                        'style' => 'padding: 5px !important;font-size:22px!important;width: 300px;margin: 10px auto 0 auto;',
                                        'label' => false));
                                    ?>
                                    <?php echo $form->end(); ?>
                                </div>
                                <div class="col-sm-12 hamburger-or text-center text-capitalize">
                                    <span>Or</span>
                                </div>
                                <div class="col-sm-12 text-center" id="hamburger-fb-login">
<!--                                    <a class="btn btn-primary" id="fb-login-button" onclick="fb_login();">-->
<!--                                        <img src="/img/fblogo.png" alt="fb-flipmybid"/>-->
<!--                                        <span>Sign up with Facebook</span>-->
<!--                                    </a>-->
                                    <a class="btn btn-primary fb-login-button green-puchase"
                                       style="padding: 5px !important;font-size:22px!important;cursor: pointer;margin:0 auto;" scope="email,user_checkins">
                                        <span>Log in with Facebook</span>
                                    </a>

                                </div>
                                <div class="col-sm-12 hamburger-or text-center text-capitalize">
                                    <span>Or</span>
                                </div>
                                <div class="col-sm-12 text-center" id="hamburger-fb-login">
                                    <!--                                    <a class="btn btn-primary" id="fb-login-button" onclick="fb_login();">-->
                                    <!--                                        <img src="/img/fblogo.png" alt="fb-flipmybid"/>-->
                                    <!--                                        <span>Sign up with Facebook</span>-->
                                    <!--                                    </a>-->
                                    <input name="username" type="text" class="form-control" maxlength="80"
                                           id="FacebookUsernameMenu" placeholder='Username' style="margin:0 0 10px 0">
                                    <a class="btn btn-primary fb-register-button-menu green-puchase"
                                       style="padding: 5px !important;font-size:22px!important;cursor: pointer;margin:0 auto;" scope="email,user_checkins">
                                        <span>Register with Facebook</span>
                                    </a>

                                </div>


                                <div class="col-sm-12">
                                    <hr/>
                                </div>
                                <div class="col-sm-12 text-center" id="hamburger-login-text">
                                    <span >MENU</span>
                                </div>
                                <div class="col-sm-12 hamburger-link">
                                    <a href="/users/register">Register Account</a>
                                </div>
                                <div class="col-sm-12 hamburger-link">
                                    <a href="/users/login">Login Page</a>
                                </div>
                                <div class="col-sm-12 hamburger-link">
                                    <a href="/auctions">Live Auctions</a>
                                </div>
                                <?php $pages = $this->requestAction('/pages/getpages/top'); ?>
                                <?php if (!empty($pages)): ?>
                                    <?php foreach ($pages as $page): ?>
                                        <div class="col-sm-12 hamburger-link">
                                            <?php echo $html->link($page['Page']['name'], array(
                                                'controller' => 'pages',
                                                'action' => 'view', $page['Page']['slug'])); ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ($this->requestAction('/settings/enabled/reward_points')) : ?>
                                    <div class="col-sm-12 hamburger-link">

                                        <?php echo $html->link(__('Rewards', true), array(
                                            'controller' => 'rewards', 'action' => 'index')); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if ($this->requestAction('/settings/enabled/help_section')) : ?>
                                    <div class="col-sm-12 hamburger-link">
                                        <a href="/help">Help</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div><!-- /.navbar-collapse -->
                <?php endif; ?>

            </div><!-- /.container-fluid -->
        </nav>
    </div>
</div>
