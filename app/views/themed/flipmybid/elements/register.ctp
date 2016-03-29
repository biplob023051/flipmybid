<div class="g6 reg rounded col-sm-12 col-md-3 top-margin-sm">
    <p>Register Now!</p>
    <?php echo $form->create('User', array('action' => 'register')); ?>
    <p>
        <?php echo $form->input('username', array('label' => 'Username <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
    </p>

    <p>
        <?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
    </p>

    <p>
        <?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div' => false, 'class' => 'form-control')); ?>
    </p>


    <p style="font-size: 14px; margin: 10px 0 0 0; ">
        <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style' => 'width: 20px;', 'div' => false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
    </p>

    <p class="captcha">
        <?php //echo $this->Captcha->input();?>
    </p>
    <div class="clearfix"></div>
    <p>
        <?php echo $form->submit('Sign up Now', array('div' => false, 'class' => 'submit-fb-register center-button', 'style' => 'font-size:22px;')); ?>
    </p>

    <p style="margin: 15px 0 0 0;">
        <span class="font-size:16px !important;">Or</span>
    </p>
    <p>
        <span class="font-size:16px !important;">
<!--        <fb:login-button scope="public_profile,email" size="large"-->
<!--                         onlogin="fbLogin();">Sign up with Facebook-->
<!--        </fb:login-button>-->
        </span>
        <p style="padding: 0 0 20px 0;">
        <label for="FacebookUsername">Username <span>*</span></label>
        <input name="username" type="text" class="form-control" maxlength="80" id="FacebookUsername">
        </p>
        <a class="btn btn-primary fb-register-button" id="fb-login-button" scope="email,user_checkins">
            <span>Register with Facebook</span>
        </a>
    </p>
    <!--<p style="float: left; width: 200px;">Or<br /></p>
    <p style="float: left; font-size:16px; width: 180px; height: 25px; text-align: center; background-color: #294F90;">
       <a href="#" class="fb-login" style="width: 180px !important; min-width: 180px; min-height: 150px; color: white; text-align: center;">Sign up with Facebook</a>
    </p>-->
    <?php echo $form->end(); ?>
</div>