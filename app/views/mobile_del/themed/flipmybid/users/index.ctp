<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
	<!--/ sidebar -->
	<div class="g5">
		<div id="auctions" class="rounded">
			<div id="tabs">
				<h2>Dashboard</h2>
			</div>

			<?php $bidBalance = $this->requestAction('/bids/balance/'.$user['User']['id']); ?>
                  
			<div class="account">

				<div class="rounded" id="message">
					<p class="right">You have <span><?php echo $unpaidAuctions; ?></span> unpaid auction(s)</p>
					<p>You have <span><?php echo $bidBalance; ?></span> bid <?php if($bidBalance <= 1):?>credit<?php else:?>credits<?php endif;?> in your account</p>
				</div>

			<?php $purchasedBefore = $this->requestAction('/accounts/check/'.$session->read('Auth.User.id')); ?>
			<?php if($purchasedBefore == false) : ?>
				<div class="inner">
				<h3>New to the site?</h3>
				<ul>
					<?php if(empty($user['User']['active'])) : ?>
						<li>
							<?php $freebids = $this->requestAction('/settings/get/free_registration_bids'); ?>
							<?php if($freebids == 1) {
								__('Receive <a href="/users/resend">1</a> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.');
							} elseif($freebids > 1) {
								echo sprintf(__('Receive <a href="/users/resend">%s</a> free bid for confirming your email address. <a href="/users/resend">Click here to confirm</a>.', true), $freebids);
							} else {
								__('<a href="/users/resend">Click here to confirm</a>.');
							} ?>
							</li>
					<?php endif; ?>
				<li><?php __('Learn about <a href="/page/howitworks">how it works</a>.'); ?></li>
				<li class="info">
					<?php __('<a href="/packages">Top up your bid balance</a> now and view our bid packages.'); ?>
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
			<div class="inner">
			<h3>Your tasks</h3>
			<ul>
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
						<li><a href="/packages"><?php __('Top up your bid balance'); ?></a></li>
					<?php endif; ?>

					<?php if($unpaidAuctions > 0) : ?>
						<?php $count = 1; ?>
						<li><a href="/auctions/won"><?php __('Confirm a won auction'); ?></a></li>
					<?php endif; ?>

					<?php if(empty($count)) : ?>
						<li><?php __('You have no tasks at the moment!'); ?></li>
					<?php endif; ?>
					</ul>

			</ul>
			</div>
			
			<!-- Andrew Buchan change -->
			<div class="inner">
			<h3>Your Membership Rank</h3>
			<?php
				if(!empty($user['Membership']['name']))
				{
					echo "<p id='openrankdialog'>" . ucfirst(strtolower($user['Membership']['name'])) . "</p>";
					echo "<div id='rankdialog' title='" . ucfirst(strtolower($user['Membership']['name'])) . " Rank Explained' style='display: none;'>" . $user['Membership']['description'] . "</div>";
				}
				else
				{
					echo "<p>No membership rank set.</p>";
				}
			?>
			</div>
			<!-- End Change -->
			
			<!-- Andrew Buchan change, put bid points here -->
			<div class="inner">
			<h3>Your Accumulated Bid Points</h3>
			<?php
			if(!empty($bidPoints))
			{
				$description = $this->requestAction('/settings/get/bid_points_description');
				print("<p id='openbidpointsdialog'>Accumulated Bid Points: " . $bidPoints . "</p>");
				print("<div id='biddialog' title='Bid Points Explained' style='display:none;'>" . $description . "</div>");
			}
			else
			{
				print("<p>No accumulated bid points.</p>");
			}
			?>
			</div>
			<!-- End Change -->
			
			<div class="inner">
			<h3>Latest news</h3>
			<?php $news = $this->requestAction('/news/getlatest/1');?>

			<?php if(!empty($news)):?>
				<h4><?php echo $html->link($news['News']['title'], array('controller' => 'news', 'action'=>'view', $news['News']['id'])); ?></h4>
			    <p><?php echo $news['News']['brief'];?></p>
			<?php else:?>
				<p><?php __('There is no news at the moment.');?></p>
			<?php endif;?>
			</div>
			<?php if(!empty($auctions)):?>
				<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr class="headings">
						<td><?php __('Image');?></td>
						<td><?php __('Title');?></td>
						<td><?php __('Status');?></td>
						<td><?php __('Price');?></td>
						<td class="actions"><?php __('Actions');?></td>
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
		<!--/ Auctions -->
	</div>