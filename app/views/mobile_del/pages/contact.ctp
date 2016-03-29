<div id="content_top"></div>
<div id="content_bg">
<div id="contact-page" class="boxed">
	<div class="content">

	<?php $page = $this->requestAction('/pages/getpage/contact-us'); ?>

	<?php if(!empty($page)) : ?>
		<h1><?php echo $page['Page']['title']; ?></h1>
		<?php echo $page['Page']['content']; ?>
	<?php endif; ?>

	<?php if($this->requestAction('/settings/enabled/contact_form')) : ?>
		<h1><?php __('Contact Form');?></h1>

		<p><strong><?php __('Use the form below to contact us and we will reply to your message within one working day.');?></strong></p>

		<?php echo $form->create(null, array('url' => '/contact')); ?>

		<fieldset>
			<?php echo $form->input('name', array('label' => 'Full Name <span class="required">*</span>'));?>
			<?php echo $form->input('email', array('label' => 'Email Address<span class="required">*</span>')); ?>
			<?php
			if(!empty($departments)) :
				echo $form->input('department_id', array('label' => 'Department *', 'empty' => 'Select', ));
			endif;
			?>
			<?php echo $form->input('phone', array('label' => 'Phone Number')); ?>
			<?php echo $form->input('subject', array('label' => 'Subject')); ?>
			<?php echo $form->input('message', array('label' => 'Your Message <span class="required">*</span>', 'type' => 'textarea'));?>
			<?php echo $form->end(__('Contact Us', true)); ?>
		</fieldset>
	<?php endif; ?>

	</div>
</div>
</div>
<div id="content_bottom"></div>