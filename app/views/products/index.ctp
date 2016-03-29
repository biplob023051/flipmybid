<?php echo $this->element('banners'); ?>

<h1><?php __('Products for Sale'); ?></h1>

<?php if(!empty($products)) : ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
	<?php echo $this->element('products'); ?>
	<div class="paging-auct">
		<?php echo $this->element('pagination'); ?>
	</div>
<?php else: ?>
	<p><?php __('There are no products for sale at the moment.');?></p>
<?php endif; ?>