<div id="contact-page" class="boxed">
	<div class="content">
		<h1><?php __('Reply to the thread:'); ?> <?php echo $thread['Post']['title']; ?></h1>

		<?php echo $form->create(null, array('url' => '/posts/reply/'.$thread['Post']['id'])); ?>

		<fieldset>
			<legend></legend>

			<?php
			echo $form->input('content', array('label' => __('Content *', true)));
			echo $form->end(__('Post Reply >>', true));
			?>
		</fieldset>
	</div>
</div>