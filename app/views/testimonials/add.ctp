<div id="contact-page" class="boxed">
	<div class="content">
		<h1><?php __('Add a Testimonial for auction:'); ?> <?php echo $auction['Product']['title']; ?></h1>

		<p><?php __('Fill in the form below to add your testimonial.  Your testimonial will be reviewed by the staff and if approved will show on the website.'); ?></p>

		<?php $testimonialBids = $this->requestAction('/settings/get/testimonial_free_bids'); ?>
		<?php if($testimonialBids > 0) : ?>
			<?php if($testimonialBids == 1) : ?>
				<p><?php echo sprintf(__('You will receive %s free bid for each testimonial that is approved to show on the website.', true), $testimonialBids);?></p>
			<?php else : ?>
				<p><?php echo sprintf(__('You will receive %s free bids for each testimonial that is approved to show on the website.', true), $testimonialBids);?></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php echo $form->create(null, array('type' => 'file', 'url' => '/testimonials/add/'.$auction['Auction']['id'])); ?>

		<fieldset>
			<legend></legend>

			<?php
			echo $form->input('name', array('label' => 'Name *'));
			echo $form->input('location', array('label' => 'Location *'));
			echo $form->input('testimonial', array('label' => 'Testimonial *'));

			if($this->requestAction('/settings/get/testimonial_videos')) {
				echo $form->input('video', array('label' => 'Youtube Embedded HTML'));
			}

			if($this->requestAction('/settings/get/testimonial_images')) {
				echo $form->input('image', array('type' => 'file', 'label' => __('Image', true)));
			}

			echo $form->end('Add Testimonial >>');
			?>
		</fieldset>
	</div>
</div>