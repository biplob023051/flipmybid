<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Referrals');?></h2>
		</div>
		<div class="account">
			<div class="">
				<h3><?php __('How it Works');?></h3>

				<?php if($this->requestAction('/settings/enabled/reward_points') && ($this->requestAction('/settings/get/referral_points') || $this->requestAction('/settings/get/referral_purchase_points'))) : ?>
					<?php if($this->requestAction('/settings/get/free_referral_bids')) : ?>
						<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s free bid credits and %s reward points.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/free_referral_bids').'</strong>', '<strong>'.$this->requestAction('/settings/get/referral_points').'</strong>');?></p>
					<?php else : ?>
						<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s reward points.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/referral_points').'</strong>');?></p>
					<?php endif; ?>

					<?php if($this->requestAction('/settings/get/free_purchase_bids')) : ?>
						<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s free bid credits and %s reward points.', true), '<strong>'.$this->requestAction('/settings/get/free_purchase_bids').'</strong>', '<strong>'.$this->requestAction('/settings/get/referral_purchase_points').'</strong>');?></p>
					<?php else : ?>
						<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s reward points.', true), '<strong>'.$this->requestAction('/settings/get/referral_purchase_points').'</strong>');?></p>
					<?php endif; ?>

				<?php else : ?>
					<?php if($this->requestAction('/settings/get/free_referral_bids')) : ?>
						<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s free bid credits.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/free_referral_bids').'</strong>');?></p>
					<?php endif; ?>

					<?php if($this->requestAction('/settings/get/free_purchase_bids')) : ?>
						<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s free bid credits.', true), '<strong>'.$this->requestAction('/settings/get/free_purchase_bids').'</strong>');?></p>
					<?php endif; ?>
				<?php endif; ?>

				<p style="word-break: break-all;word-wrap:break-word;"><?php __('Use the following link to refer users:');?><br/>
				<strong><?php echo $appConfigurations['url']; ?>/referral/<?php echo $session->read('Auth.User.username'); ?></strong>
				</p>

				<h3><?php __('Your Referrals');?></h3>

				<?php if(!empty($referrals)) : ?>
					<p><?php __('You have referred and received free bids for signing up the following users. Free bid credits are only issued when a user is verified by confirming there email address.');?></p>

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

					<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
							<td><?php echo $paginator->sort(__('Username', true), 'User.username');?></td>
							<td><?php echo $paginator->sort(sprintf(__('Joined %s', true), $appConfigurations['name']), 'Referral.created');?></td>
							<td><?php echo $paginator->sort(__('Verified', true), 'Referral.verified');?></td>
							<td><?php echo $paginator->sort(__('Purchased Bid Pack', true), 'Referral.purchased');?></td>
						</tr>
						<?php
						$i = 0;
						foreach ($referrals as $referral):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
						<tr<?php echo $class;?>>
							<td>
								<?php echo $referral['User']['username']; ?>
							</td>
							<td>
								<?php echo $html->image('tick.png'); ?>
							</td>
							<td>
								<?php if(!empty($referral['Referral']['verified'])) : ?>
									<?php echo $html->image('tick.png'); ?>
								<?php else : ?>
									<?php echo $html->image('cross.png'); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if(!empty($referral['Referral']['purchased'])) : ?>
									<?php echo $html->image('tick.png'); ?>
								<?php else : ?>
									<?php echo $html->image('cross.png'); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</table>

					<div class="paging-auct">
						<?php echo $this->element('pagination'); ?>
                    </div>

				<?php else:?>
					<p><?php __('You have not referred any members yet.');?></p>
				<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>