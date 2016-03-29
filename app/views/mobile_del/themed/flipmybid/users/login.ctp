<div class="g1">
        <div id="auctions-easyview" class="rounded">
            <div id="tabs">
                <h2>Login or Register!</h2>
            </div>
            <div class="g2 left">
                <?php echo $form->create('User', array('action' => 'login'));?>
                    <p>
                        <?php echo $form->input('username', array('label' => 'Username <span>*</span>', 'div'=>false)); ?>
                    </p>
                    <p>
                        <?php echo $form->input('password', array('label' => 'Password <span>*</span>', 'div'=>false)); ?>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <?php echo $form->checkbox('remember_me', array('label' => false, 'style'=>'width: 20px;', 'div'=>false)); ?>
                        Remember me?
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <?php echo $form->submit('Login',array('label' => false, 'div'=>false, 'class'=>'submit'));?>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <?php echo $html->link('Forgotten your password?', array('action' => 'reset')); ?>
                    </p>
                <?php echo $form->end(); ?>
            </div>
            <div class="g2">
                <?php echo $form->create('User', array('action' => 'register'));?>
                    <p>
                        <?php echo $form->input('username', array('label'=>'Username <span>*</span>', 'div'=>false));?>
                    </p>
                    <p>
                        <?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div'=>false)); ?>
                    </p>
                    <p>
                        <?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div'=>false)); ?>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => ' Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
                        </p>
                        <p class="radio-group captcha-register">
                            <?php //echo $this->Captcha->input();?>     
                        </p>
                    <p style="margin: 0; padding: 0;">
                        <label>&nbsp;</label>
                        <?php echo $form->submit('Register',array('div'=>false, 'class'=>'submit-fb-register'));?>
                    </p>
					<p style="font-size:16px; width: 114%; text-align: center;">
						<span class="font-size:16px !important;">Or<br /><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Sign up with Facebook</fb:login-button></span>
					 </p>
                <?php echo $form->end(); ?>
            </div>
        </div>
        <!--/ Auctions -->
    </div>
