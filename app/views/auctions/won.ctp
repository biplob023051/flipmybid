<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Won Auctions');?></h1>

		<?php $testimonialBids = $this->requestAction('/settings/get/testimonial_free_bids'); ?>
		<?php if($testimonialBids > 0 && $this->requestAction('/settings/enabled/testimonials')) : ?>
			<?php if($testimonialBids == 1) : ?>
				<p><?php echo sprintf(__('Testimonials can be submitted on non free bid auctions and beginner auctions. Receive %s free bid when you submit a testimonial for a won auction!  The bids will be given once the testimonial is approved.', true), $testimonialBids);?></p>
			<?php else : ?>
				<p><?php echo sprintf(__('Testimonials can be submitted on non free bid auctions and beginner auctions. Receive %s free bids when you submit a testimonial for a won auction!  The bids will be given once the testimonial is approved.', true), $testimonialBids);?></p>
			<?php endif; ?>
		<?php endif; ?>

		<?php if(!empty($auctions)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th valign="top"><?php echo $paginator->sort('Image', 'title');?></th>
					<th valign="top"><?php echo $paginator->sort('title');?></th>
					<th valign="top"><?php __('Price');?></th>
					<th valign="top"><?php echo $paginator->sort('Date Won', 'end_time');?></th>
					<th valign="top"><?php echo $paginator->sort('Status', 'Status.name');?></th>
					<th valign="top"><?php __('Options');?></th>
				</tr>
			<?php
			$i = 0;
			foreach ($auctions as $auction):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td>
						<a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Product']['Image'][0]['image'])):?>
							<?php echo $html->image('product_images/thumbs/'.$auction['Product']['Image'][0]['image']); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
					</td>
					<td>
						<?php echo $html->link($auction['Product']['title'], array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id'])); ?>
					</td>
					<td>
						<?php if(!empty($auction['Product']['fixed'])) : ?>
							<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
						<?php else: ?>
							<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $time->niceShort($auction['Auction']['end_time']); ?>
					</td>
					<td>
						<?php if(!empty($auction['Status']['name'])) : ?>
							<?php echo $auction['Status']['name']; ?>
						<?php else : ?>
							<?php __('Processing'); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php echo $html->link(__('View', true), array('action' => 'view', $auction['Auction']['id'])); ?>
						<?php if($auction['Auction']['status_id'] == 1) : ?>
							<?php if(!empty($auction['Auction']['free']) || $auction['Auction']['price'] <= 0) : ?>
								| <?php echo $html->link(__('Confirm', true), array('action' => 'pay', $auction['Auction']['id'])); ?>
							<?php else : ?>
								| <?php echo $html->link(__('Pay', true), array('action' => 'pay', $auction['Auction']['id'])); ?>
							<?php endif; ?>
						<?php elseif($testimonialBids > 0 && $this->requestAction('/settings/enabled/testimonials')) : ?>
							<?php if(!empty($auction['Testimonial']['id'])) : ?>
								<?php if(!empty($auction['Testimonial']['approved'])) : ?>
									| <?php __('Testimonial Approved'); ?>
								<?php else : ?>
									| <?php __('Testimonial Submitted'); ?>
								<?php endif; ?>
							<?php else : ?>
								<?php if(empty($auction['Product']['bids']) || $auction['Auction']['beginner']) : ?>
									| <?php echo $html->link(__('Submit Testimonial', true), array('controller' => 'testimonials', 'action' => 'add', $auction['Auction']['id'])); ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
	  </table>

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have not won any auctions yet.');?></p>
		<?php endif;?>
        <div class="clear"></div>
	</div>
</div>