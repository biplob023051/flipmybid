<div class="rounded contact">
        <div id="tabs">
            <h2><?php __('Password Reminder');?></h2>
        </div>
        <div class="c-content">
        <p><?php __('If you have forgotten your username or password simply enter in your email address below.');?></p>

		<p><?php __('We will email your username and a new password to you.');?></p>

		<?php echo $form->create('User', array('action' => 'reset'));?>
			<fieldset>
				<?php echo $form->input('email', array('label' => __('Email Address', true), 'class' => 'form-control')); ?>
				<?php echo $form->submit(__('Retrieve Password', true), array('div' => false, 'class' => 'submit', 'style' => 'margin:0 auto;')); ?>
			</fieldset>
		<?php echo $form->end();?>

		<p>
			<?php echo sprintf(__('%s ', true), $html->link(__('Register now', true), array('action'=>'register')));?>
			<?php echo sprintf(__('or %s.', true), $html->link(__('login to the website', true), array('action'=>'login')));?>
		</p>

	</div>
</div>
