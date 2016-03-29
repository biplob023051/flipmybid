<div>
	<h3><?php __('My Account');?></h3>
		<ul class="menu">
			<li><?php echo $html->link(__('My Dashboard', true), array('controller' => 'users', 'action' => 'index'));?></li>
			<li><?php echo $html->link(__('Purchase Bids', true), array('controller' => 'packages', 'action' => 'index'));?></li>
			<li><?php echo $html->link(__('My Bids', true), array('controller' => 'bids', 'action' => 'index'));?></li>

			<?php if($this->requestAction('/settings/enabled/bid_butler')) : ?>
				<li><?php echo $html->link(__('My Bid Buddies', true), array('controller' => 'bidbutlers', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<li><?php echo $html->link(__('My Reward Points', true), array('controller' => 'points', 'action' => 'index'));?></li>
			<?php endif; ?>

			<li><?php echo $html->link(__('My Watchlist', true), array('controller' => 'watchlists', 'action' => 'index'));?></li>
			<li><?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'won'));?></li>

			<?php if($this->requestAction('/settings/enabled/buy_now')) : ?>
				<li><?php echo $html->link(__('Products Purchased', true), array('controller' => 'exchanges', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<li><?php echo $html->link(__('Redeemded Rewards', true), array('controller' => 'rewards', 'action' => 'redeemed'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/referrals')) : ?>
				<li><?php echo $html->link(__('Referrals', true), array('controller' => 'referrals', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/referrals') && $this->requestAction('/settings/get/user_invite_message')) : ?>
				<li><?php echo $html->link(__('Invite My Friends', true), array('controller' => 'invites', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/win_limits')) : ?>
				<li><?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'index'));?></li>
			<?php endif; ?>
		</ul>

	<h3><?php __('My Details');?></h3>
		<ul class="menu">
			<li><?php echo $html->link(__('Edit Profile', true), array('controller' => 'users', 'action' => 'edit'));?></li>
			<li><?php echo $html->link(__('Change Password', true), array('controller' => 'users', 'action' => 'changepassword'));?></li>
			<li><?php echo $html->link(__('Addresses', true), array('controller' => 'addresses', 'action' => 'index'));?></li>
			<li><?php echo $html->link(__('Account History', true), array('controller' => 'accounts', 'action' => 'index'));?></li>
			<?php if($this->requestAction('/settings/enabled/newsletters')) : ?>
				<li><?php echo $html->link(__('Newsletter', true), array('controller' => 'users', 'action' => 'newsletter'));?></li>
			<?php endif; ?>

			<li><?php echo $html->link(__('Delete Account', true), array('controller' => 'users', 'action' => 'delete'));?></li>
		</ul>
</div>