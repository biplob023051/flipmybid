<h1><?php __('Beginner Auctions'); ?></h1>

<?php if(!empty($auctions)) : ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
	<?php echo $this->element('auctions'); ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
<?php else: ?>
	<p><?php __('There are no beginner auctions at the moment.');?></p>
<?php endif; ?>