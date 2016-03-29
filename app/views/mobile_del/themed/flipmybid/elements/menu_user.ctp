<div class="inner rounded">
		<p>My Account</p>
		<ul>
			<li<?php if($this->params['url']['url'] == 'users') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('My Dashboard', true), array('controller' => 'users', 'action' => 'index'));?></li>
			<li<?php if($this->params['controller'] == 'packages') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Purchase Bids', true), array('controller' => 'packages', 'action' => 'index'));?></li>
			<li<?php if($this->params['controller'] == 'bids') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('My Bid History', true), array('controller' => 'bids', 'action' => 'index'));?></li>

			<?php if($this->requestAction('/settings/enabled/bid_butler')) : ?>
				<li<?php if($this->params['controller'] == 'bidbutlers') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('My Bid Buddies', true), array('controller' => 'bidbutlers', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<li<?php if($this->params['controller'] == 'points') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('My Reward Points', true), array('controller' => 'points', 'action' => 'index'));?></li>
			<?php endif; ?>

			<li<?php if($this->params['controller'] == 'watchlists') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('My Watchlist', true), array('controller' => 'watchlists', 'action' => 'index'));?></li>
			<li<?php if($this->params['action'] == 'won' || $this->params['action'] == 'pay') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'won'));?></li>

			<?php if($this->requestAction('/settings/enabled/buy_now')) : ?>
				<li<?php if($this->params['controller'] == 'exchanges') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Products Purchased', true), array('controller' => 'exchanges', 'action' => 'index'));?></li>
			<?php endif; ?>
			
			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<li<?php if($this->params['controller'] == 'rewards' && $this->params['action'] == 'explained') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Membership Levels', true), array('controller' => 'rewards', 'action' => 'explained'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
				<li<?php if($this->params['controller'] == 'rewards' && $this->params['action'] != 'explained') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Redeemded Rewards', true), array('controller' => 'rewards', 'action' => 'redeemed'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/referrals')) : ?>
				<li<?php if($this->params['controller'] == 'referrals') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Referrals', true), array('controller' => 'referrals', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/referrals') && $this->requestAction('/settings/get/user_invite_message')) : ?>
				<li<?php if($this->params['controller'] == 'invites') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Invite My Friends', true), array('controller' => 'invites', 'action' => 'index'));?></li>
			<?php endif; ?>

			<?php if($this->requestAction('/settings/enabled/win_limits')) : ?>
				<li<?php if($this->params['controller'] == 'limits') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'index'));?></li>
			<?php endif; ?>
			
			<li<?php if($this->params['controller'] == 'buy_it_packages') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Buy It Products', true), array('controller' => 'buy_it_packages', 'action' => 'index'));?></li>
			
		</ul>
	</div>
	<div class="inner rounded">
		<p>My Details</p>
		<ul>
			<li<?php if($this->params['url']['url'] == 'users/edit') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Edit Profile', true), array('controller' => 'users', 'action' => 'edit'));?></li>
			<li<?php if($this->params['url']['url'] == 'users/changepassword') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Change Password', true), array('controller' => 'users', 'action' => 'changepassword'));?></li>
			<li<?php if($this->params['controller'] == 'addresses') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Addresses', true), array('controller' => 'addresses', 'action' => 'index'));?></li>
			<li<?php if($this->params['controller'] == 'accounts') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Account History', true), array('controller' => 'accounts', 'action' => 'index'));?></li>
			<?php if($this->requestAction('/settings/enabled/newsletters')) : ?>
				<li<?php if($this->params['url']['url'] == 'users/newsletter') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Newsletter', true), array('controller' => 'users', 'action' => 'newsletter'));?></li>
			<?php endif; ?>

			<li<?php if($this->params['url']['url'] == 'users/delete') : ?> id="menuactive-g7"<?php endif; ?>><?php echo $html->link(__('Delete Account', true), array('controller' => 'users', 'action' => 'delete'));?></li>
		</ul>
	</div>