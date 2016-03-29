<h1><?php __('Your Search for:'); ?> <?php echo $search; ?></h1>


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
<?php else: ?>
	<p><?php __('Your search returned no results, please try again.');?></p>
<?php endif; ?>