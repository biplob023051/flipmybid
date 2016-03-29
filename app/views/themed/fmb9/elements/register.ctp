<div class="pure-u-1 pure-u-md-1-4 userform">
<form class="pure-form pure-form-stacked reg">
	<p>Register Now!</p>
	<?php echo $form->create('User', array('action' => 'register'));?>
    <fieldset>

		<?php echo $form->input('username', array('label'=>'Username <span>*</span>', 'div'=>false));?>
		<?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div'=>false)); ?>
		<?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div'=>false)); ?>
		<?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
		<?php echo $form->submit('Sign up Now',array('div'=>false, 'class'=>'submit-fb-register pure-button pure-button-primary'));?>
		<span class="font-size:16px !important;">Or<br /><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Sign up with Facebook</fb:login-button></span>
		<a href="#" class="fb-login" style="width: 180px !important; min-width: 180px; min-height: 150px; color: white; text-align: center;">Sign up with Facebook</a>

    </fieldset>
	<?php echo $form->end(); ?>
</form>
		
</div>