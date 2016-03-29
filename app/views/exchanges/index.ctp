<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Products Purchased'); ?></h1>

		<?php if(!empty($exchanges)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th valign="top"><?php echo $paginator->sort('Image', 'Product.title');?></th>
					<th valign="top"><?php echo $paginator->sort('Title', 'Product.title');?></th>
					<th valign="top"><?php echo $paginator->sort('Date Exchanged', 'Exchange.created');?></th>
					<th valign="top"><?php echo $paginator->sort('Status', 'Status.name');?></th>
					<th valign="top"><?php __('Options');?></th>
				</tr>
			<?php
			$i = 0;
			foreach ($exchanges as $exchange):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td>
						<a href="/auction/<?php echo $exchange['Auction']['id']; ?>">
						<?php if(!empty($exchange['Auction']['Product']['Image'][0]['image'])):?>
							<?php echo $html->image('product_images/thumbs/'.$exchange['Auction']['Product']['Image'][0]['image']); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
					</td>
					<td>
						<?php echo $html->link($exchange['Auction']['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $exchange['Auction']['id'])); ?>
					</td>
					<td>
						<?php echo $time->niceShort($exchange['Exchange']['created']); ?>
					</td>
					<td>
						<?php if(!empty($exchange['Status']['name'])) : ?>
							<?php echo $exchange['Status']['name']; ?>
						<?php else : ?>
							<?php __('Processing'); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $html->link(__('View', true), array('controller' => 'auctions', 'action' => 'view', $exchange['Auction']['id'])); ?>
						<?php if($exchange['Exchange']['status_id'] == 1) : ?>
							| <?php echo $html->link(__('Confirm Details', true), array('action' => 'confirm', $exchange['Exchange']['id'])); ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
	  </table>

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have not purchased any products yet.');?></p>
		<?php endif;?>
	</div>
</div>