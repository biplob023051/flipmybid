<div class="rounded contact">

	<?php $page = $this->requestAction('/pages/getpage/contact-us'); ?>
	
	<?php if(!empty($page)) : ?>
        <div id="tabs">
            <h2><?php echo $page['Page']['title']; ?></h2>
        </div>
        <div class="c-content">
        <?php echo $page['Page']['content']; ?>
    <?php else: ?>
		<div class="c-content">
    <?php endif;?>
	<?php if($this->requestAction('/settings/enabled/contact_form')) : ?>
		<h2><?php __('Contact Form');?></h2>

		<p><strong><?php __('Use the form below to contact us and we will reply to your message within one working day.');?></strong></p>

		<?php echo $form->create(null, array('url' => '/contact')); ?>

		<fieldset>
			<?php echo $form->input('name', array('label' => 'Full Name <span class="required">*</span>', 'class' => 'form-control'));?>
			<?php echo $form->input('email', array('label' => 'Email Address<span class="required">*</span>', 'class' => 'form-control')); ?>
			<?php
			if(!empty($departments)) :
				echo $form->input('department_id', array('label' => 'Department *', 'empty' => 'Select', 'class' => 'form-control' ));
			endif;
			?>
			<?php echo $form->input('phone', array('label' => 'Phone Number', 'class' => 'form-control')); ?>
			<?php echo $form->input('subject', array('label' => 'Subject', 'class' => 'form-control')); ?>
			<?php echo $form->input('message', array('label' => 'Your Message <span class="required">*</span>', 'class' => 'form-control', 'type' => 'textarea'));?>
            <?php echo $form->submit('Contact Us', array('class'=>'submit center-button', 'div'=>false)); ?>
			<?php echo $form->end(); ?>
		</fieldset>
	<?php endif; ?>

	</div>
</div>