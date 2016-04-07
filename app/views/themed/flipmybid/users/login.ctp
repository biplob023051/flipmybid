<div class="clearfix"></div>
<div class="col-sm-6" style="padding-left:15px;padding-right:15px;">
    <div id="auctions" class="rounded" style="margin-bottom:20px;">
        <div id="tabs">
            <p role="button" data-toggle="collapse" href="#collapseLogin" aria-expanded="false"
               aria-controls="collapseLogin" class="visible-sm visible-xs">Login
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"
                      style="font-size:14px;margin:5px 0 0 10px;float:right;"></span>
            </p>
            <h2 class="visible-lg visible-md">Login</h2>
        </div>
        <div class="collapse in" id="collapseLogin">
            <?php echo $form->create('User', array('action' => 'login', 'style' => 'padding:0 20px;')); ?>
            <p>
                <?php echo $form->input('username', array('label' => 'Username <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
            </p>

            <p>
                <?php echo $form->input('password', array('label' => 'Password <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
            </p>

            <p>
                <label>&nbsp;</label>
                <?php echo $form->checkbox('remember_me', array('label' => false, 'style' => 'width: 20px;', 'div' => false)); ?>
                Remember me?
            </p>

            <p style="margin-bottom:2px;">
                <label>&nbsp;</label>
                <?php echo $form->submit('Login', array('label' => false, 'div' => false, 'class' => 'submit center-button')); ?>
            </p>

            <p style="font-size:16px; text-align: center;">
                <span class="font-size:16px !important;">Or<br/>
                    <!--                    <fb:login-button scope="public_profile,email"-->
                    <!--                                     size="large" onlogin="fbLogin();">Log-->
                    <!--                        in with Facebook-->
                    <!--                    </fb:login-button>-->
                </span>
                <a class="btn btn-primary fb-login-button loginpage-fb-button" scope="email,user_checkins">
                    <span>Log in with Facebook</span>
                </a>
            </p>
            <p>
                <label>&nbsp;</label>
                <?php echo $html->link('Forgotten your password?', array('action' => 'reset', 'class' => 'center-button')); ?>
            </p>
            <?php echo $form->end(); ?>
        </div>
    </div>
</div>
<div class="col-sm-6" style="padding-left:15px;padding-right:15px;">
    <div id="auctions" class="rounded">
        <div id="tabs">
            <p role="button" data-toggle="collapse" href="#collapseRegister" aria-expanded="false"
               aria-controls="collapseRegister" class="visible-sm visible-xs">Register
                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"
                      style="font-size:14px;margin:5px 0 0 10px;float:right;"></span>
            </p>
            <h2 class="visible-lg visible-md">Register</h2>
        </div>
        <div class="collapse in" id="collapseRegister">
            <?php echo $form->create('User', array('action' => 'register', 'style' => 'padding:0 20px;')); ?>
            <p>
                <?php echo $form->input('username', array('label' => 'Username <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
            </p>

            <p>
                <?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
            </p>

            <p>
                <?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
            </p>

            <p>
                <label>&nbsp;</label>
                <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style' => 'width: 20px;', 'div' => false, 'after' => ' Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
            </p>

            <p class="radio-group captcha-register">
                <?php //echo $this->Captcha->input();?>
            </p>

            <p style="margin: 0; padding: 0;">
                <label>&nbsp;</label>
                <?php echo $form->submit('Register', array('div' => false, 'class' => 'submit-fb-register center-button', 'style' => 'font-size:22px !important;')); ?>
            </p>

            <p style="font-size:16px; text-align: center;margin:20px 0 0 0;">
                <span class="font-size:16px !important;">Or
                    <br/>
                    <!--                    <fb:login-button scope="public_profile,email"-->
                    <!--                                                                                 size="large" onlogin="fbLogin();">Sign-->
                    <!--                        up with Facebook-->
                    <!--                    </fb:login-button>-->
                </span>
            <p style="padding: 0 20px">
                <label for="FacebookUsername">Username <span>*</span></label>
                <input name="username" type="text" class="form-control" maxlength="80" id="FacebookUsername">

            </p>
            <p style="text-align: center;">
                <a class="btn btn-primary fb-register-button loginpage-fb-button" scope="email,user_checkins">
                    <span>Register with Facebook</span>
                </a>
            </p>

            <?php echo $form->end(); ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12" style="margin-top:5px;">&nbsp;</div>

<!--/ Listing -->

