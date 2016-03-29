<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Change Password');?></h1>
		<fieldset>
			<?php echo $form->create('User', array('url' => '/users/changepassword'));?>
			<p><?php echo __('To change your password enter in your old password and your new password twice.'); ?></p>
			<?php
				echo $form->input('old_password', array('value' => '', 'type' => 'password'));
				echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => __('New Password', true)));
				echo $form->input('retype_password', array('value' => '', 'type' => 'password'));
				echo $form->end('Change Password');
			?>
		</fieldset>
	</div>
</div>
