<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Referrals');?></h1>
		<h3><?php __('How it Works');?></h3>

		<?php if($this->requestAction('/settings/enabled/reward_points') && ($this->requestAction('/settings/get/referral_points') || $this->requestAction('/settings/get/referral_purchase_points'))) : ?>
			<?php if($this->requestAction('/settings/get/free_referral_bids')) : ?>
				<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s free bids and %s reward points.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/free_referral_bids').'</strong>', '<strong>'.$this->requestAction('/settings/get/referral_points').'</strong>');?></p>
			<?php else : ?>
				<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s reward points.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/referral_points').'</strong>');?></p>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/get/free_purchase_bids')) : ?>
				<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s free bids and %s reward points.', true), '<strong>'.$this->requestAction('/settings/get/free_purchase_bids').'</strong>', '<strong>'.$this->requestAction('/settings/get/referral_purchase_points').'</strong>');?></p>
			<?php else : ?>
				<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s reward points.', true), '<strong>'.$this->requestAction('/settings/get/referral_purchase_points').'</strong>');?></p>
			<?php endif; ?>

		<?php else : ?>
			<?php if($this->requestAction('/settings/get/free_referral_bids')) : ?>
				<p><?php echo sprintf(__('For every user that you refer to %s, you earn %s free bids.', true), $appConfigurations['name'], '<strong>'.$this->requestAction('/settings/get/free_referral_bids').'</strong>');?></p>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/get/free_purchase_bids')) : ?>
				<p><?php echo sprintf(__('For every user who purchases a bid pack, you receive an extra %s free bids.', true), '<strong>'.$this->requestAction('/settings/get/free_purchase_bids').'</strong>');?></p>
			<?php endif; ?>
		<?php endif; ?>

		<p style="word-break: break-all;word-wrap:break-word;">
			<?php __('Use the following link to refer users:');?><br/>
		<strong><?php echo $appConfigurations['url']; ?>/referral/<?php echo $session->read('Auth.User.username'); ?></strong>
		</p>

		<h3><?php __('Your Referrals');?></h3>

		<?php if(!empty($referrals)) : ?>
			<p><?php __('You have referred and received free bids for signing up the following users. Free bids are only issued when a user is verified by confirming there email address.');?></p>

			<?php echo $this->element('pagination'); ?>
		<div class="table-responsive">
			<table width="100%" class="table table-striped" cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $paginator->sort(__('Username', true), 'User.username');?></th>
					<th><?php echo $paginator->sort(sprintf(__('Joined %s', true), $appConfigurations['name']), 'Referral.created');?></th>
					<th><?php echo $paginator->sort(__('Verified', true), 'Referral.verified');?></th>
					<th><?php echo $paginator->sort(__('Purchased Bid Pack', true), 'Referral.purchased');?></th>
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
		</div>
			<?php echo $this->element('pagination'); ?>

		<?php else:?>
			<p><?php __('You have not referred any members yet.');?></p>
		<?php endif;?>
	</div>
</div>
