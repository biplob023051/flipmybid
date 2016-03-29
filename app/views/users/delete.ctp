<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Delete Account');?></h1>
		<p><?php __('Are you sure you want to delete your account?');?></p>

		<p><?php __('This action cannot be undone and any remaining bids in your account will be lost.');?></p>

		<p><?php __('Please confirm your password to delete your account:');?></p>

		<fieldset>
			<?php echo $form->create('User', array('url' => '/users/delete'));?>
			<?php
				echo $form->input('old_password', array('value' => '', 'type' => 'password', 'label' => __('Confirm Password', true)));
				echo $form->end(__('Delete my account now >>', true));
			?>
		</fieldset>
	</div>
</div>