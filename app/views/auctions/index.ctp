<h1><?php __('Live Auctions'); ?></h1>


<?php if(!empty($auctions)) : ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>

	<?php echo $this->element('banners'); ?>

	<div id="products">
		<?php echo $this->element('auctions'); ?>
	</div>

	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>

	<?php echo $this->element('timeout'); ?>
<?php else: ?>
	<p><?php __('There are no live auctions at the moment.');?></p>
<?php endif; ?>