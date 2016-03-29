<li><?php echo $html->link(__('View', true), array('controller' => 'users', 'action' => 'view', $id)); ?></li>
<li><?php echo $html->link(__('Edit', true), array('controller' => 'users', 'action' => 'edit', $id)); ?></li>
<li><?php echo $html->link(__('Admin Rights', true), array('controller' => 'users', 'action' => 'rights', $id)); ?></li>
<li><?php echo $html->link(__('Bids', true), array('controller' => 'bids', 'action' => 'user', $id)); ?></li>

<?php if($this->requestAction('/settings/enabled/bid_butler')) : ?>
	<li><?php echo $html->link(__('Bid Buddies', true), array('controller' => 'bidbutlers', 'action' => 'user', $id)); ?></li>
<?php endif; ?>

<li><?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'user', $id)); ?></li>

<?php if($this->requestAction('/settings/enabled/reward_points')) : ?>
	<li><?php echo $html->link(__('Reward Points', true), array('controller' => 'points', 'action' => 'user', $id));?></li>
<?php endif; ?>

<?php if($this->requestAction('/settings/enabled/win_limits')) : ?>
	<li><?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'user', $id)); ?></li>
<?php endif; ?>

<?php if($this->requestAction('/settings/enabled/referrals')) : ?>
	<li><?php echo $html->link(__('Referred Users', true), array('controller' => 'referrals', 'action' => 'user', $id)); ?></li>
<?php endif; ?>

<li><?php echo $html->link(__('<< Back to users', true), array('controller' => 'users', 'action' => 'index')); ?></li>