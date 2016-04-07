<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
            <h2><?php __('Add a Testimonial for auction:'); ?> <?php echo $auction['Product']['title']; ?></h2>
        </div>
		<div class="account">
		<p><?php __('Fill in the form below to add your testimonial.  Your testimonial will be reviewed by the staff and if approved will show on the website.'); ?></p>

		<?php $testimonialBids = $this->requestAction('/settings/get/testimonial_free_bids'); ?>
		<?php if($testimonialBids > 0) : ?>
			<?php if($testimonialBids == 1) : ?>
				<p><?php echo sprintf(__('You will receive %s free bid for each testimonial that is approved to show on the website.', true), $testimonialBids);?></p>
			<?php else : ?>
				<p><?php echo sprintf(__('You will receive %s free bids for each testimonial that is approved to show on the website.', true), $testimonialBids);?></p>
			<?php endif; ?>
		<?php endif; ?>
		<div class="">
			<?php echo $form->create(null, array('type' => 'file', 'url' => '/testimonials/add/'.$auction['Auction']['id'])); ?>
				<fieldset>
					<?php
					echo $form->input('name', array('label' => 'Name *', 'class' => 'form-control'));
					echo $form->input('location', array('label' => 'Location *', 'class' => 'form-control'));
					echo $form->input('testimonial', array('label' => 'Testimonial *', 'class' => 'form-control'));

					if($this->requestAction('/settings/get/testimonial_videos')) {
						echo $form->input('video', array('label' => 'Youtube Embedded HTML', 'class' => 'form-control'));
					}

					if($this->requestAction('/settings/get/testimonial_images')) {
						echo $form->input('image', array('type' => 'file', 'label' => __('Image', true), 'class' => 'form-control'));
					}
					echo $form->submit(__('Add Testimonial >>', true), array('class' => 'submit center-button', 'div' => false));
					echo $form->end();
					?>
				</fieldset>
			<p><?php echo $html->link(__('<< Back to own auctions', true), array('controller' => 'auctions', 'action' => 'won'), array('class' => 'backButton'));?></p>

			</div>
		</div>
	</div>
</div>
	