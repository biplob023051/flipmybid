<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('Newsletter Preferences');?></h2>
		</div>
		<div class="auction-content">
			<div class="">
				<p><?php __('Sign up to the newsletter to receive special promotions and information about new auctions.');?></p>

				<?php echo $form->create('User', array('action' => 'newsletter'));?>
					<?php if(!empty($this->data['User']['newsletter'])) : ?>
							<p><?php __('You are currently set to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
							<p><?php echo $form->input('newsletter', array('div' => false, 'label' => false, 'after' => 'Untick the box to unsubscribe')); ?></p>
						<?php else : ?>
							<p><?php __('You are currently not signed up to the newsletter.  Tick the box before to receive the newsletter to the email address:');?> <strong><?php echo $this->data['User']['email']; ?></strong></p>
							<p><?php echo $form->input('newsletter', array('div' => false, 'label' => false, 'after' => 'Tick the box to subscribe to the newsletter')); ?></p>
						
						
						<?php endif;?>
						
						<input class="submit btn btn-register" type="submit" value="Save Changes" style="margin:0 auto;padding:12px !important;width:250px !important;">
						
						<?php echo $form->end();?>
						
						</div>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
