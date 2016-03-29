<div id="contact-page" class="boxed">
	<div class="content">
		<h1><?php __('Create a new thread in the topic:'); ?> <?php echo $topic['Topic']['name']; ?></h1>

		<?php echo $form->create(null, array('url' => '/posts/add/'.$topic['Topic']['id'])); ?>

		<fieldset>
			<legend></legend>

			<?php
			echo $form->input('title', array('label' => __('Title *', true)));
			echo $form->input('content', array('label' => __('Content *', true)));
			echo $form->input('auction_id', array('label' => __('Relates to Auction', true), 'empty' => __('Not Applicable', true)));

			echo $form->end(__('Create Thread >>', true));
			?>
		</fieldset>
	</div>
</div>