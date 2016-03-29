<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('My Watchlist');?></h1>
		<?php if($paginator->counter() > 0):?>
			<?php echo $this->element('pagination'); ?>
			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Image');?></th>
					<th><?php echo $paginator->sort(__('Title', true), 'Product.title');?></th>
					<th><?php echo $paginator->sort(__('Status', true), 'end_time');?></th>
					<th><?php echo $paginator->sort(__('Price', true), 'price');?></th>
					<th class="actions"><?php __('Actions');?></th>
				</tr>
				<?php
				$i = 0;
				foreach ($watchlists as $watchlist): ?>
				<tr class="auction-item" title="<?php echo $watchlist['Auction']['id'];?>" id="auction_<?php echo $watchlist['Auction']['id'];?>">
					<td>
						<a href="/auction/<?php echo $watchlist['Auction']['id']; ?>">
					<?php if(!empty($watchlist['Auction']['image'])):?>
						<?php echo $html->image($watchlist['Auction']['image']); ?>
					<?php else:?>
						<?php echo $html->image('product_images/thumbs/no-image.gif');?>
					<?php endif;?>
					</a>
					</td>
					<td>
						<?php echo $html->link($watchlist['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $watchlist['Auction']['id'])); ?>
					</td>
					<td>
						<?php if(!empty($watchlist['Auction']['isFuture'])) : ?>
							<div><?php echo $html->image('icon-future.png');?></div>
						 <?php elseif(!empty($watchlist['Auction']['isClosed'])) : ?>
							<div><?php echo $html->image('icon-closed.png');?></div>
						<?php else : ?>
							<div id="timer_<?php echo $watchlist['Auction']['id'];?>" class="bid-status countdown" title="<?php echo $watchlist['Auction']['end_time'];?>">--:--:--</div>
						<?php endif; ?>
					</td>
					<td>
						<span class="bid-price"><?php echo $number->currency($watchlist['Auction']['price'], $appConfigurations['currency']); ?></span>
					</td>
					<td class="actions">
						<?php echo $html->link(__('Delete', true), array('action'=>'delete', $watchlist['Watchlist']['id']), null, sprintf(__('Are you sure you want to delete this auction from your watchlist?', true), $watchlist['Watchlist']['id'])); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php else:?>
			<?php __('You are not watching any auctions at the moment.');?>
		<?php endif;?>
	</div>