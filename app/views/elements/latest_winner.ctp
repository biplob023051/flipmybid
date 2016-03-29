<div class="latest-winner">
	<?php $latestWinner = $this->requestAction('/auctions/latestwinner'); ?>
	<p><?php echo $html->image('h-latest-winner.png', array('alt' => __('Latest Winner', true), 'title' => __('Latest Winner', true))); ?></p>
	<?php if(!empty($latestWinner)) : ?>
		<div class="thumb">
			<a href="/auction/<?php echo $latestWinner['Auction']['id']; ?>">
			<?php if(!empty($latestWinner['Auction']['image'])):?>
				<?php echo $html->image($latestWinner['Auction']['image']); ?>
			<?php else:?>
				<?php echo $html->image('product_images/thumbs/no-image.gif');?>
			<?php endif;?>
			</a>
		</div>
		<div class="info">
			<h3><?php echo $html->link($latestWinner['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $latestWinner['Auction']['id']));?></h3>
			<p><?php __('Won by:'); ?> <strong><?php echo $text->truncate($latestWinner['Winner']['username'], 15); ?></strong> <?php __('for'); ?> <span class="price">
			<?php if(!empty($latestWinner['Product']['fixed'])) : ?>
				<?php echo $number->currency($latestWinner['Product']['fixed_price'], $appConfigurations['currency']); ?>
			<?php else: ?>
				<?php echo $number->currency($latestWinner['Auction']['price'], $appConfigurations['currency']); ?>
			<?php endif; ?></span>
			</p>
		</div>
	<?php else : ?>
		<p><?php __('There are no winners yet!');?></p>
	<?php endif;?>
</div>