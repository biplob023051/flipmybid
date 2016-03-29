<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('My Bids');?></h1>
		<p>
		<?php echo sprintf(__('You currently have <strong>%s</strong> bids in your account.  <a href="/packages">Click here to purchase more bids</a>!', true), $bidBalance);?>

		<?php if(!empty($credits)) : ?>
			<?php if($this->requestAction('/settings/enabled/database_cleaner')) : ?>
				<h3><?php echo sprintf(__('Credits - Last  %s Days', true), $this->requestAction('/settings/get/bids_archive'));?></h3>
			<?php else : ?>
				<h3><?php __('Credits'); ?></h3>
			<?php endif; ?>

			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Date'); ?></th>
					<th><?php __('Description'); ?></th>
					<th><?php __('Bids'); ?></th>
				</tr>

				<?php
				$i = 0;
				foreach ($credits as $bid):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
				?>
					<tr<?php echo $class;?>>
						<td>
							<?php echo $time->niceShort($bid['Bid']['created']); ?>
						</td>
						<td>
							<?php echo $bid['Bid']['description']; ?>
						</td>
						<td>
							<?php echo $bid['Bid']['credit']; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>

			<?php endif; ?>

		<?php if($this->requestAction('/settings/enabled/database_cleaner')) : ?>
			<h3><?php echo sprintf(__('Your Bids - Last  %s Days', true), $this->requestAction('/settings/get/bids_archive'));?></h3>
		<?php else : ?>
			<h3><?php __('Your Bids'); ?></h3>
		<?php endif; ?>

		<?php if(!empty($bids)): ?>
			<table width="100%" class="table" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Image'); ?></th>
					<th><?php __('Auction'); ?></th>
					<th><?php __('Number of Bids'); ?></th>
				</tr>
			<?php
			$i = 0;
			foreach ($bids as $bid):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
				<tr<?php echo $class;?>>
					<td>
					<a href="/auction/<?php echo $bid['Auction']['id']; ?>">
					<?php if(!empty($bid['Auction']['Product']['Image'][0]['image'])):?>
						<?php echo $html->image('product_images/thumbs/'.$bid['Auction']['Product']['Image'][0]['image']); ?>
					<?php else:?>
						<?php echo $html->image('product_images/thumbs/no-image.gif');?>
					<?php endif;?>
					</a>
					</td>
					<td>
						<?php echo $html->link($bid['Auction']['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $bid['Auction']['id'])); ?>
					</td>
					<td>
						<?php $count = $this->requestAction('/bids/count/'.$bid['Auction']['id'].'/'.$session->read('Auth.User.id')); ?>
						<?php echo $count; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php else:?>
			<p><?php echo sprintf(__('You have had no bids in the last %s days.', true), $this->requestAction('/settings/get/bids_archive'));?></p>
		<?php endif;?>
	</div>
</div>