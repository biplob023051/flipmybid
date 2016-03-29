<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('My Bid Buddies');?></2>
		</div>
		<div class="account">
			<div class="">
				<?php if(!empty($bidbutlers)): ?>
					<div class="paging-auct">
							<?php echo $this->element('pagination'); ?>
						</div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td><?php echo $paginator->sort('Image', 'Product.title');?></td>
							<td><?php echo $paginator->sort('Auction', 'Product.title');?></td>
							<td><?php echo $paginator->sort('minimum_price');?></td>
							<td><?php echo $paginator->sort('maximum_price');?></td>
							<td><?php echo $paginator->sort('Bids Left', 'bids');?></td>
							<td><?php echo $paginator->sort('Date', 'created');?></td>
							<td class="actions"><?php __('Options');?></td>
						</tr>
					<?php
					$i = 0;
					foreach ($bidbutlers as $bidbutler):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td>
							<a href="/auction/<?php echo $bidbutler['Auction']['id']; ?>">
							<?php if(!empty($bidbutler['Auction']['Product']['Image'])):?>
								<?php echo $html->image('product_images/thumbs/'.$bidbutler['Auction']['Product']['Image'][0]['image']); ?>
							<?php else:?>
								<?php echo $html->image('product_images/thumbs/no-image.gif');?>
							<?php endif;?>
							</a>
							</td>
							<td>
								<?php echo $html->link($bidbutler['Auction']['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $bidbutler['Auction']['id'])); ?>

							</td>
							<td>
								<?php if(empty($bidbutler['Auction']['Product']['fixed'])) : ?>
									<?php echo $number->currency($bidbutler['Bidbutler']['minimum_price'], $appConfigurations['currency']); ?>
								<?php else : ?>
									<?php __('n/a'); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if(empty($bidbutler['Auction']['Product']['fixed'])) : ?>
									<?php echo $number->currency($bidbutler['Bidbutler']['maximum_price'], $appConfigurations['currency']); ?>
								<?php else : ?>
									<?php __('n/a'); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo $bidbutler['Bidbutler']['bids']; ?>
							</td>
							<td>
								<?php echo $time->niceShort($bidbutler['Bidbutler']['created']); ?>
							</td>
							<td class="actions">
								<?php echo $html->link(__('Delete', true), array('action'=>'delete', $bidbutler['Bidbutler']['id']), null, sprintf(__('Are you sure you want to delete this bid buddy?', true))); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>

					<div class="paging-auct">
							<?php echo $this->element('pagination'); ?>
						</div>

				<?php else:?>
					<p><?php __('You have no bid buddies at the moment.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>