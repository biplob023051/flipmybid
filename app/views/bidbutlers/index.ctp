<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('My Bid Buddies');?></h1>
		<?php if(!empty($bidbutlers)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $paginator->sort('Image', 'Product.title');?></th>
					<th><?php echo $paginator->sort('Auction', 'Product.title');?></th>
					<th><?php echo $paginator->sort('minimum_price');?></th>
					<th><?php echo $paginator->sort('maximum_price');?></th>
					<th><?php echo $paginator->sort('Bids Left', 'bids');?></th>
					<th><?php echo $paginator->sort('Date', 'created');?></th>
					<th class="actions"><?php __('Options');?></th>
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

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have no bid buddies at the moment.');?></p>
		<?php endif;?>
	</div>
</div>