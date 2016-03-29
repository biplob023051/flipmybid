<div class="g6 reg rounded">
        <p>Register Now!</p>
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
            
            
            <p style="float: left; font-size: 14px; margin: 20px 0 0 0; width: 200px;">
                <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
             </p>   
             <p class="captcha">
                <?php //echo $this->Captcha->input();?>
            </p>    
            <p><label>&nbsp;</label>
                 <?php echo $form->submit('Sign up Now',array('div'=>false, 'class'=>'submit-fb-register'));?>
            </p>
            <p style="float: left; font-size:16px; width: 200px;">
                <span class="font-size:16px !important;">Or<br />
<!--                    <fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Sign up with Facebook</fb:login-button>-->
                </span>
                <a class="btn btn-primary fb-login-button">
                    <span>Sing up with Facebook</span>
                </a>
             </p>
			 <!--<p style="float: left; width: 200px;">Or<br /></p>
			 <p style="float: left; font-size:16px; width: 180px; height: 25px; text-align: center; background-color: #294F90;">
				<a href="#" class="fb-login" style="width: 180px !important; min-width: 180px; min-height: 150px; color: white; text-align: center;">Sign up with Facebook</a>
			 </p>-->
        <?php echo $form->end(); ?>
	</div>