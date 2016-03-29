<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2>My Bid History</h2>
		</div>
		<div class="account">
			<div class="rounded" id="message">
				<?php echo sprintf(__('You currently have <span>%s</span> bid credits in your account.  <a href="/packages">Click here to purchase more bid credits</a>!', true), $bidBalance);?>
			</div>
			<?php if(!empty($credits)) : ?>
			<div class="inner alt">
			<?php if($this->requestAction('/settings/enabled/database_cleaner')) : ?>
				<h3><?php echo sprintf(__('Credits - Last  %s Days', true), $this->requestAction('/settings/get/bids_archive'));?></h3>
			<?php else : ?>
				<h3><?php __('Credits'); ?></h3>
			<?php endif; ?>

			<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="headings">
					<td><?php __('Date'); ?></td>
					<td><?php __('Description'); ?></td>
					<td><?php __('Bids'); ?></td>
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
			</div>
			<?php endif; ?>

		<?php if($this->requestAction('/settings/enabled/database_cleaner')) : ?>
			<h3><?php echo sprintf(__('Your Bids - Last  %s Days', true), $this->requestAction('/settings/get/bids_archive'));?></h3>
		<?php else : ?>
			<h3><?php __('Your Bids'); ?></h3>
		<?php endif; ?>

		<?php if(!empty($bids)): ?>
			<div class="inner alt">

			<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr class="headings">
					<td><?php __('Image'); ?></td>
					<td><?php __('Auction'); ?></td>
					<td><?php __('Number of Bids'); ?></td>
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
	</div>
	<!--/ Auctions -->
</div>