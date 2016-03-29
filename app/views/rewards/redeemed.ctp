<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Rewards Redeemed'); ?></h1>

		<?php if(!empty($rewards)): ?>
			<?php echo $this->element('pagination'); ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th valign="top"><?php echo $paginator->sort('Image', 'Product.title');?></th>
					<th valign="top"><?php echo $paginator->sort('Title', 'Product.title');?></th>
					<th valign="top"><?php echo $paginator->sort('Date Redeemed', 'Reward.created');?></th>
					<th valign="top"><?php echo $paginator->sort('Status', 'Status.name');?></th>
					<th valign="top"><?php __('Options');?></th>
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

			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have not redeemed any rewards yet.');?></p>
		<?php endif;?>
	</div>
</div>