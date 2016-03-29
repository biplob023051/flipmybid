<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Won Auctions');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php $testimonialBids = $this->requestAction('/settings/get/testimonial_free_bids'); ?>
				<?php if($testimonialBids > 0 && $this->requestAction('/settings/enabled/testimonials')) : ?>
					<?php if($testimonialBids == 1) : ?>
						<p><?php echo sprintf(__('Testimonials can be submitted on non free bid auctions and beginner auctions. Receive %s free bid credits when you submit a testimonial for a won auction!  The bid credits will be given once the testimonial is approved.', true), $testimonialBids);?></p>
					<?php else : ?>
						<p><?php echo sprintf(__('Testimonials can be submitted on non free bid auctions and beginner auctions. Receive %s free bid credits when you submit a testimonial for a won auction!  The bid credits will be given once the testimonial is approved.', true), $testimonialBids);?></p>
					<?php endif; ?>
				<?php endif; ?>

				<?php if(!empty($auctions)): ?>
					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td><?php echo $paginator->sort('Image', 'title');?></td>
							<td><?php echo $paginator->sort('title');?></td>
							<td><?php __('Price');?></td>
							<td><?php echo $paginator->sort('Date Won', 'end_time');?></td>
							<td><?php echo $paginator->sort('Status', 'Status.name');?></td>
							<td><?php __('Options');?></td>
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
								<?php elseif(!empty($auction['Auction']['reverse']) && $auction['Auction']['price'] < 0 && empty($auction['Auction']['price_past_zero'])) : ?>
									<?php echo $number->currency(0, $appConfigurations['currency']); ?>
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

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have not won any auctions yet.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>