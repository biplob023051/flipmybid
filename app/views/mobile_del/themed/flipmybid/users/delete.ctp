<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Delete Account');?></h2>
		</div>
		<div class="account">
			<div class="">
				<p><?php __('Are you sure you want to delete your account?');?></p>

				<p><?php __('This action cannot be undone and any remaining bids in your account will be lost.');?></p>

				<p><?php __('Please confirm your password to delete your account:');?></p>

				<fieldset>
					<?php echo $form->create('User', array('url' => '/users/delete'));?>
					<?php
						echo $form->input('old_password', array('value' => '', 'type' => 'password', 'label' => __('Confirm Password', true)));
						echo $form->submit(__('Delete my account', true), array('class' => 'submit', 'div' => false));
						echo $form->end();
					?>
				</fieldset>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>