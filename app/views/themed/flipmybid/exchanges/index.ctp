<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Products Purchased'); ?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php if(!empty($exchanges)): ?>
					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td valign="top"><?php echo $paginator->sort('Image', 'Product.title');?></td>
							<td valign="top"><?php echo $paginator->sort('Title', 'Product.title');?></td>
							<td valign="top"><?php echo $paginator->sort('Date Exchanged', 'Exchange.created');?></td>
							<td valign="top"><?php echo $paginator->sort('Status', 'Status.name');?></td>
							<td valign="top"><?php __('Options');?></td>
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

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have not purchased any products yet.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>