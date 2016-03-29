<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Newsletter Preferences');?></h2>
		</div>
		<div class="account">
			<div class="">
				<p><?php __('Sign up to the newsletter to receive special promotions and information about new auctions.');?></p>

				<?php echo $form->create('User', array('action' => 'newsletter'));?>
					<?php if(!empty($this->data['User']['newsletter'])) : ?>
							<p><?php __('You are currently set to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
							<p><?php echo $form->input('newsletter', array('div' => false, 'label' => false, 'after' => 'Untick the box to unsubscribe')); ?></p>
						<?php else : ?>
							<p><?php __('You are currently not signed up to the newsletter.  Tick the box before to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
							<p><?php echo $form->input('newsletter', array('div' => false, 'label' => false, 'after' => 'Tick the box to subscribe to the newsletter')); ?></p>
						<?php endif;
						echo $form->submit(__('Save Changes', true), array('class' => 'submit', 'div' => false));
						echo $form->end();
					?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
