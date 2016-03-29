<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Newsletter Preferences');?></h1>

		<p><?php __('Sign up to the newsletter to receive special promotions and information about new auctions.');?></p>

		<?php echo $form->create('User', array('action' => 'newsletter'));?>
			<?php if(!empty($this->data['User']['newsletter'])) : ?>
					<p><?php __('You are currently set to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
					<p><?php echo $form->input('newsletter', array('div' => false, 'label' => 'Untick the box to unsubscribe')); ?></p>
				<?php else : ?>
					<p><?php __('You are currently not signed up to the newsletter.  Tick the box before to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
					<p><?php echo $form->input('newsletter', array('div' => false, 'label' => 'Tick the box to subscribe to the newsletter')); ?></p>
				<?php endif;
				echo $form->end('Update Preferences');
			?>
	</div>
</div>
