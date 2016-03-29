<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
 	   <h1><?php echo sprintf(__('My Dashboard', true)); ?></h1>

		<?php if(!empty($paymentMessage)) : ?>
			<div id="flashMessage" class="message"><?php __('Your payment has been processed, however your bids are not yet in your account.  Very rarely our payment processor will hold a payment temporarily before approving it.  If you do not receive your bids within the next 5 minutes please <a href="/contact">contact us</a> so we can manually approve the transaction and credit your bids.  We apologise for any inconvenience this may have caused.'); ?></div>
		<?php endif; ?>

		<?php $bidBalance = $this->requestAction('/bids/balance/'.$user['User']['id']); ?>

		<div class="account-info">
			<p class="info"><?php echo sprintf(__('You have <span class="total">%s</span> bid(s) in your account. You have <strong>%s</strong> unpaid auction(s).', true), $bidBalance, $unpaidAuctions);?></p>
			<p><a class="won" href="/auctions/won"><?php __('Click here to view your won auctions >>'); ?></a></p>
		</div>

		<?php $purchasedBefore = $this->requestAction('/accounts/check/'.$session->read('Auth.User.id')); ?>
		<?php if($purchasedBefore == false) : ?>
			<div class="attentions">
				<h3><?php __('New to the site?');?></h3>
				<ul>
				<?php if(empty($user['User']['active'])) : ?>
					<li class="info">
					<?php $freebids = $this->requestAction('/settings/get/free_registration_bids'); ?>
					<?php if($freebids == 1) {
						__('Receive <span class="total">1</span> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.');
					} elseif($freebids > 1) {
						echo sprintf(__('Receive <span class="total">%s</span> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.', true), $freebids);
					} else {
						__('<a href="/users/resend">Click here to confirm</a>.');
					} ?>
					</li>
				<?php endif; ?>
				<li><?php __('Learn about <a href="/page/how-it-works">how it works</a>.'); ?></li>
				<li class="info">
					<?php __('<a href="/packages">Purchase some bids now</a> and view our bid packages.'); ?>
					<?php
						$bonusBids = $this->requestAction('/settings/get/free_bid_packages_bids');
						if(!empty($bonusBids)) {
							echo sprintf(__('Get <span class="total">%s</span> free bids on your first purchase.', true), $bonusBids);
						}
					?>
				</li>
				<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
					<li><?php __('Still confused?  Find the answers to common questions in our <a href="/help">help section</a>.'); ?></li>
				<?php endif; ?>

				<li><?php __('View our <a href="/auctions">live auctions</a>.'); ?></li>
				<?php if($this->requestAction('/settings/enabled/testimonials')) : ?>
					<li><?php __('Read about what our <a href="/testimonials">winners have to say</a>.'); ?></li>
				<?php endif; ?>
				<li><a href="/contact"><?php __('Contact us.'); ?></a></li>
				</ul>
			</div>
		<?php endif; ?>

		<div class="attentions">
			<h3><?php __('Your Tasks!');?></h3>
			<ul>
			<?php if(empty($user['User']['active'])) : ?>
				<li>
				<?php $freebids = $this->requestAction('/settings/get/free_registration_bids'); ?>
					<?php if($freebids == 1) {
						__('Receive <span class="total">1</span> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.');
					} elseif($freebids > 1) {
						echo sprintf(__('Receive <span class="total">%s</span> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.', true), $freebids);
					} else {
						__('<a href="/users/resend">Click here to confirm</a>.');
					} ?>
				</li>
				<?php $count = 1; ?>
			<?php endif; ?>

			<?php if(!empty($userAddress)) : ?>
				<?php foreach($userAddress as $name => $address) : ?>
					<?php if(empty($address['Address']['id'])) : ?>
						<?php $count = 1; ?>
						<li><a href="/addresses/add/<?php echo $address['Address']['user_address_type_id']; ?>"><?php echo sprintf(__('Add a %s Address', true), $name); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if($bidBalance == 0) : ?>
				<?php $count = 1; ?>
				<li><a href="/packages"><?php __('Purchase some bids'); ?></a></li>
			<?php endif; ?>

			<?php if($unpaidAuctions > 0) : ?>
				<?php $count = 1; ?>
				<li><a href="/auctions/won"><?php __('Confirm a won auction'); ?></a></li>
			<?php endif; ?>

			<?php if(empty($count)) : ?>
				<li><?php __('You have no tasks at the moment!'); ?></li>
			<?php endif; ?>
			</ul>
		</div>

		<?php if($this->requestAction('/settings/enabled/memberships') && !empty($user['User']['membership_id'])) : ?>
			<div class="attentions">
				<h3><?php __('Current Membership:'); ?> <?php echo $user['Membership']['name']; ?></h3>

				<p><?php echo nl2br($user['Membership']['description']); ?></p>

				<?php $nextMembership = $this->requestAction('/memberships/getnext/'.$user['Membership']['id']); ?>

				<?php if(!empty($nextMembership)) : ?>
					<h3><?php __('What is the next membership level?'); ?></h3>

					<p><?php __('Next Membership:'); ?> <strong><?php echo $nextMembership['Membership']['name']; ?></strong></h3>

					<p><?php echo nl2br($nextMembership['Membership']['description']); ?></p>

					<?php if($this->requestAction('settings/enabled/reward_points')) : ?>
						<p><?php __('Current Points:'); ?> <strong><?php echo $this->requestAction('/users/points/'.$session->read('Auth.User.id')); ?></strong><br />
						<?php __('Reward Points Needed:'); ?> <strong><?php echo $nextMembership['Membership']['points']; ?></strong></p>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="attentions">
			<h3><?php __('Latest News'); ?></h3>

			<?php $news = $this->requestAction('/news/getlatest/1');?>

			<?php if(!empty($news)):?>
				<h4><?php echo $html->link($news['News']['title'], array('controller' => 'news', 'action'=>'view', $news['News']['id'])); ?></h4>
			    <p><?php echo $news['News']['brief'];?></p>
			<?php else:?>
				<p><?php __('There is no news at the moment.');?></p>
			<?php endif;?>
		</div>

		<div class="attentions">
			<h3><?php __('Auctions you\'re bidding on!'); ?></h3>

			<?php if(!empty($auctions)):?>
				<table width="100%" class="table" cellpadding="0" cellspacing="0">
					<tr>
						<th><?php __('Image');?></th>
						<th><?php __('Title');?></th>
						<th><?php __('Status');?></th>
						<th><?php __('Price');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					<?php
					$i = 0;
					foreach ($auctions as $auction): ?>
					<tr class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
						<td>
							<a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image']); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
						</td>
						<td>
							<?php echo $html->link($auction['Product']['title'], array('controller'=> 'auctions', 'action'=>'view', $auction['Auction']['id'])); ?>
						</td>
						<td>
							<?php if(!empty($auction['Auction']['isFuture'])) : ?>
								<div><?php echo $html->image('icon-future.png');?></div>
							 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
								<div><?php echo $html->image('icon-closed.png');?></div>
							<?php else : ?>
								<div id="timer_<?php echo $auction['Auction']['id'];?>" class="bid-status countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
							<?php endif; ?>
						</td>
						<td>
							<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
						</td>
						<td class="actions">
							<?php echo $html->link('View', array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?>
						</td>
					</tr>
				<?php endforeach; ?>
				</table>
			<?php else:?>
				<p><?php __('You are not bidding on any auctions at the moment.');?></p>
			<?php endif;?>
		</div>
	</div>
</div>