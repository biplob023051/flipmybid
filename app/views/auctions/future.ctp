<h1><?php __('Future Auctions'); ?></h1>

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
	<p><?php __('There are no future auctions at the moment.');?></p>
<?php endif; ?>
