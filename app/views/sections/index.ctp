<div id="lefthelp">
	<h3><?php __('Help Topics'); ?></h3>
   <?php echo $this->element('menu_help', array('id' => $id, 'question_id' => $question_id));?>
</div>
<div id="middle" class="boxed">
	<div class="content">
		<?php if(!empty($question)) : ?>
			<h1><?php echo $question['Question']['question']; ?></h1>

			<?php echo $question['Question']['answer']; ?>
		<?php else : ?>
			<h1><?php __('Help Section'); ?></h1>

			<?php if(!empty($page['Page']['content'])) : ?>
				<?php echo $page['Page']['content']; ?>
			<?php endif; ?>
		<?php endif; ?>
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
	</div>
</div>

<div id="right-quicklinks">
	<h3><?php __('Quick Links'); ?></h3>
	<?php echo $this->element('menu_quicklinks');?>
</div>
