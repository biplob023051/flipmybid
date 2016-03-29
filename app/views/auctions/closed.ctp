<h1><?php __('Closed Auctions'); ?></h1>

<?php if(!empty($auctions)) : ?>
	<?php if($this->requestAction('/settings/get/closed_ended_auctions')) : ?>
	<p><strong><?php __('Showing the last');?> <?php echo $this->requestAction('/settings/get/closed_ended_auctions'); ?> <?php __('auctions.');?></strong></p>
	<?php else : ?>
        <div class="paging-auct">
            <?php echo $this->element('pagination'); ?>
        </div>
	<?php endif; ?>

    <?php echo $this->element('banners'); ?>

	<div id="products">
		<?php echo $this->element('auctions'); ?>
	</div>

	<?php if($this->requestAction('/settings/get/closed_ended_auctions')) : ?>
        <div class="paging-auct">
            <?php echo $this->element('pagination'); ?>
        </div>
	<?php endif; ?>
<?php else: ?>
	<p><?php __('There are no closed auctions at the moment.');?></p>
<?php endif; ?>
