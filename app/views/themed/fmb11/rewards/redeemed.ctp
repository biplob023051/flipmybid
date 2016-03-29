<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Rewards Redeemed'); ?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php if(!empty($rewards)): ?>
					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td valign="top"><?php echo $paginator->sort('Image', 'Product.title');?></td>
							<td valign="top"><?php echo $paginator->sort('Title', 'Product.title');?></td>
							<td valign="top"><?php echo $paginator->sort('Date Redeemed', 'Reward.created');?></td>
							<td valign="top"><?php echo $paginator->sort('Status', 'Status.name');?></td>
							<td valign="top"><?php __('Options');?></td>
						</tr>
					<?php
					$i = 0;
					foreach ($rewards as $reward):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
					?>
						<tr<?php echo $class;?>>
							<td>
								<a href="/rewards/view/<?php echo $reward['Reward']['id']; ?>">
								<?php if(!empty($reward['Product']['Image'][0]['image'])):?>
									<?php echo $html->image('product_images/thumbs/'.$reward['Product']['Image'][0]['image']); ?>
								<?php else:?>
									<?php echo $html->image('product_images/thumbs/no-image.gif');?>
								<?php endif;?>
								</a>
							</td>
							<td>
								<?php echo $html->link($reward['Product']['title'], array('controller' => 'rewards', 'action' => 'view', $reward['Reward']['id'])); ?>
							</td>
							<td>
								<?php echo $time->niceShort($reward['Reward']['created']); ?>
							</td>
							<td>
								<?php if(!empty($reward['Status']['name'])) : ?>
									<?php echo $reward['Status']['name']; ?>
								<?php else : ?>
									<?php __('Processing'); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php echo $html->link(__('View', true), array('controller' => 'rewards', 'action' => 'view', $reward['Reward']['id'])); ?>
								<?php if($reward['Reward']['status_id'] == 1) : ?>
									| <?php echo $html->link(__('Confirm Details', true), array('action' => 'confirm', $reward['Reward']['id'])); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
			  </table>

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have not redeemed any rewards yet.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>