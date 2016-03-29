<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('My Watchlist');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php if($paginator->counter() > 0):?>
					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>
					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td><?php __('Image');?></td>
							<td><?php echo $paginator->sort(__('Title', true), 'Product.title');?></td>
							<td><?php echo $paginator->sort(__('Status', true), 'end_time');?></td>
							<td><?php echo $paginator->sort(__('Price', true), 'price');?></td>
							<td class="actions"><?php __('Actions');?></td>
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
		</div>
	</div>
	<!--/ Auctions -->
</div>