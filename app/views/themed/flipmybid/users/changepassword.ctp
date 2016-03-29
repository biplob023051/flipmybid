<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Change Password');?></h2>
		</div>
		<div class="account">
			<div class="">
				<fieldset>
					<?php echo $form->create('User', array('url' => '/users/changepassword'));?>
					<p><?php echo __('To change your password enter in your old password and your new password twice.'); ?></p>
					<?php
						echo $form->input('old_password', array('value' => '', 'type' => 'password', 'class' => 'form-control'));
						echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => __('New Password', true), 'class' => 'form-control'));
						echo $form->input('retype_password', array('value' => '', 'type' => 'password', 'class' => 'form-control'));
						echo $form->submit(__('Change Password', true), array('class' => 'submit center-button', 'div' => false));
						echo $form->end();
					?>
				</fieldset>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
