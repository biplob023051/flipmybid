<div class="boxed">
	<div class="content">
		<h1><?php __('Categories'); ?></h1>
		<?php if(!empty($categories)) : ?>
			<?php echo $this->element('pagination'); ?>
			<?php echo $this->element('categories'); ?>
			<?php echo $this->element('pagination'); ?>
		<?php else: ?>
			<p><?php __('There are no categories at the moment.');?></p>
		<?php endif; ?>
	</div>
</div>
