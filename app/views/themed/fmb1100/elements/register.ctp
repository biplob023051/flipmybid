<div class="col-md-4 userform">
<p>Register Now!</p>
<form role="form">
<?php echo $form->create('User', array('action' => 'register'));?>
<div class="form-group"><?php echo $form->input('username', array('label'=>'Username <span>*</span>', 'div'=>false));?></div>
<div class="form-group"><?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div'=>false)); ?></div>
<div class="form-group"><?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div'=>false)); ?></div>
<div class="checkbox"><?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?></div> 
<?php echo $form->submit('Sign up Now',array('div'=>false, 'class'=>'btn btn-register'));?>
<?php echo $form->end(); ?>
</form>
</div>	