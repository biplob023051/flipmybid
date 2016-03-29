<?php echo $this->element('banners'); ?>

<div id="content_top"></div>
<div id="content_bg">
<div id="login-page" class="boxed">
	<div class="content">
		<h1><?php __('Login');?></h1>
		<fieldset>
			<legend></legend>
			<?php echo $form->create('User', array('action' => 'login'));?>
			<?php
				echo $form->input('username', array('label' => 'Username'));
				echo $form->input('password', array('label' => 'Password'));
				echo '<div class="checkbox">';
				echo $form->checkbox('remember_me');
				echo $form->label('remember_me', __(' Remember Me', true), array('class' => 'nofloat'));
				echo '</div>';
				echo $form->end(__('Login', true));
			?>
			<?php if($this->requestAction('/settings/enabled/facebook_login') && $this->requestAction('/settings/get/facebook_app_id')) : ?>
				<?php __('OR'); ?> <a href="/users/facebook"><?php echo $html->image('facebook-icon.gif'); ?></a>
			<?php endif; ?>

		</fieldset>

		<p>
			<?php echo sprintf(__('%s ', true), $html->link(__('Register now', true), array('action'=>'register')));?>
			<?php echo sprintf(__('or %s if you have forgotten your login details.', true), $html->link(__('reset your password', true), array('action'=>'reset')));?>
		</p>
	</div>
</div>
</div>
<div id="content_bottom"></div>
