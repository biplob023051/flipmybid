<div id="right_bar">
	<div class="banners">
	<?php $banners = $this->requestAction('/banners/get/2'); ?>
	<?php if(!empty($banners)) : ?>
		<?php foreach ($banners as $banner) : ?>
			<?php if(!empty($banner['Banner']['url'])) : ?>
            	<a target="_blank" href="<?php echo $banner['Banner']['url']; ?>"><?php echo $banner['Banner']['code']; ?></a>
			<?php else : ?>
				<img src="/img/product_images/<?php echo $banner['Banner']['image']; ?>" />
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>

<div id="content_top_auc"><?php echo $auction['Product']['title']; ?></div>

<div id="content_bg_auc">
<div id="auction-details" class="boxed">
	<ul class="auction-details">
		<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
			<div class="content">
				<div class="bg-wrap">
<!-- Product Images -->
				<div class="thumb">
					<?php if(!empty($auction['Auction']['image'])):?>
						<?php echo $html->image($auction['Auction']['image'], array('class'=>'productImageMax'));?>
					<?php else:?>
						<?php echo $html->image('product_images/max/no-image.gif');?>
					<?php endif; ?>

					<div class="product-thumbs">
						<?php if(!empty($auction['Product']['Image']) && count($auction['Product']['Image']) > 1):?>
							<?php foreach($auction['Product']['Image'] as $image):?>
								<span><?php echo $html->link($html->image('product_images/thumbs/'.$image['image']), '/img/product_images/max/'.$image['image'], array('class' => 'productImageThumb', 'escape' => false));?></span>
							<?php endforeach;?>
						<?php endif;?>
					</div>
				</div>
<!-- END Product Images -->
<!-- Bid / Time Box -->
				<div class="data">
				<div class="info">

					<div class="left-data">
						<div class="timer-stat">
						<?php if(!empty($auction['Auction']['isClosed'])) : ?>
							<div class="b-closed"><?php echo $html->image('b-closed.png');?></div>
						<?php else: ?>
							<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>"><?php __('Loading...'); ?></div>
						<?php endif; ?>
					</div>
					<?php if(empty($auction['Auction']['closed'])) : ?>
						<div class="price">
							<?php if(!empty($auction['Product']['fixed'])):?>
								<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
								<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
								<?php else: ?>
								<span class="bid-price">
									<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="username"><span class="bid-bidder"><?php __('username');?></span></div>
					<?php endif; ?>
					<div class="bid-now">
						<?php if(!empty($auction['Auction']['isFuture'])) : ?>
							<div><?php echo $html->image('b-soon2.gif');?></div>
						 <?php else:?>
							 <?php if($session->check('Auth.User')):?>
								<?php if(empty($auction['Auction']['isClosed']) && $exchanged == 0) : ?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
								 	<div class="bid-button">
								 		<?php echo $html->link($html->image('bid_now.png'), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
								 	</div>
								 	<div class="bid-message clearfix" style="display: none;">&nbsp;</div>

								 	<?php if(!empty($auction['Auction']['beginner'])) : ?>
										<div class="beginner"><?php __('Beginner Auction'); ?></div>
									<?php endif; ?>

									<?php if(!empty($auction['Auction']['penny'])) : ?>
										<div class="beginner"><?php __('This is a Penny Auction'); ?></div>
									<?php endif; ?>
								<?php endif;?>
							<?php else:?>
								<?php if(empty($auction['Auction']['isClosed'])) : ?>
									<div class="bid-button"><?php echo $html->link($html->image('b-login.gif'), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
								<?php endif;?>
							<?php endif;?>
						<?php endif; ?>
					</div>
<!-- END Bid / Time Box -->
<!-- Watchlist -->
					<div class="watchlist">
						<?php if($session->check('Auth.User') && empty($auction['Auction']['closed'])):?>
							<?php if(!empty($watchlist)):?>
								<?php echo $html->link(__('Remove from Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete', $watchlist['Watchlist']['id']), null, sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?><br />
							<?php else:?>
								<?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']));?><br />
							<?php endif;?>
						<?php endif; ?>
					</div>

					<?php if(!empty($auction['Auction']['closed'])) : ?>
						<div class="winner">
							<?php if(!empty($auction['Winner']['id'])):?>
								<div class="text"><?php echo sprintf(__('Congratulations to %s', true), $auction['Winner']['username']);?></div>
								<div class="saving"><?php __('A saving of');?> <span class="bid-savings-price"><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?></span></div>
							<?php elseif(!empty($auction['Auction']['reserve'])):?>
								<?php __('The reserve was not met on this auction. Bids were refunded on this action and a further 50% of the bids placed were credited as a bonus to bidders. This auction has now been relisted.');?><br />
							<?php else:?>
							<?php __('There was no winner');?><br />
						<?php endif;?>
						</div>
					<?php endif; ?>
					</div> <!-- leftdata -->
<!-- END Watchlist -->

<!-- Savings -->
					<div class="middle-data">
					<div class="count-saving">
						<h3 class="heading"><?php __('Savings:');?></h3>
						<?php if(!empty($auction['Product']['rrp'])) : ?>
							<label><?php __('Worth up to');?></label> : <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?> <br />
						<?php endif; ?>
						<label><?php __('Price');?></label> :

						<?php if(!empty($auction['Product']['fixed'])):?>
							<span><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></span>
                            <span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
						<?php else: ?>
							<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
						<?php endif; ?>

						</span>
						<div class="total-savings">
							<label><?php __('Total Savings');?></label> : <span class="bid-savings-price"><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?></span>
						</div>

						<?php if($auction['Product']['exchange'] > 0 && $exchanged == 0) : ?>
							<label><?php __('Bid Savings');?></label> :
							<?php $bidSavings = $this->requestAction('/bids/total/'.$auction['Auction']['id'].'/'.$session->read('Auth.User.id'));?>
							<span><?php echo $number->currency($bidSavings, $appConfigurations['currency']); ?></span>
							<div class="total-savings">
								<label><a href="/exchanges/add/<?php echo $auction['Auction']['id']; ?>"><?php __('Buy Now');?></a></label> :
								<?php if($auction['Product']['exchange'] < $bidSavings) {
									$auction['Product']['exchange'] = 0;
								} else {
									$auction['Product']['exchange'] = $auction['Product']['exchange'] - $bidSavings;
								} ?>

								<span><a href="/exchanges/add/<?php echo $auction['Auction']['id']; ?>"><?php echo $number->currency($auction['Product']['exchange'], $appConfigurations['currency']); ?></a></span>
                                <p class="buy-now">
									<a href="/exchanges/add/<?php echo $auction['Auction']['id']; ?>"><?php echo $html->image('buy_now.png', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true)), null, false);?></a>
                                </p>
							</div>
						<?php endif; ?>

						<?php if(!empty($auction['Auction']['reverse'])) : ?>
							<p><?php __('This is a reverse auction!'); ?></p>
						<?php endif; ?>
					</div>

				</div>
<!-- END Savings -->

<!-- Bid History -->
                    <div class="right-data">
						<div class="bid-histories" id="bidHistoryTable<?php echo $auction['Auction']['id'];?>" title="<?php echo $auction['Auction']['id'];?>">
						<div class="content">
							<h3><?php __('Bidding History');?></h3>
							<table width="100%" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th><?php __('TIME');?></th>
									<th><?php __('BIDDER');?></th>
									<th><?php __('TYPE');?></th>
								</tr>
							</thead>
							<?php if(!empty($bidHistories)):?>
								<tbody>
								<?php foreach($bidHistories as $bid):?>
								<tr>
									<td><?php echo $time->niceShort($bid['Bid']['created']);?></td>
									<td><?php echo $bid['User']['username'];?></td>
									<td><?php echo $bid['Bid']['description'];?></td>
								</tr>
								<?php endforeach;?>
								</tbody>
							<?php elseif(!empty($auction['Winner']['id'])): ?>
								<tr><td colspan="3"><?php __('The bidding history is no longer available for this auction.');?></td></tr>
							<?php else: ?>
								<tr><td colspan="3"><?php __('No bids have been placed yet.');?></td></tr>
							<?php endif;?>
						</table>
						</div>
					</div>
					</div> <!-- right data -->
					<div style="clear: both;"></div>
<!-- END Bid History -->

<!-- Bid Buddy -->  					<?php if($session->check('Auth.User') && empty($auction['Auction']['closed']) && empty($auction['Auction']['nail_biter']) && $exchanged == 0 && $this->requestAction('/settings/enabled/bid_butler')):?>
						<?php $bidbutler = $this->requestAction('/bidbutlers/check/'.$auction['Auction']['id'].'/'.$session->read('Auth.User.id'));?>
						<?php if(!empty($bidbutler)) : ?>
							<p><?php echo sprintf(__('You currently have a bid buddy on this auction.  You have <strong>%s</strong> remaining bids left on the bid buddy.', true), $bidbutler['Bidbutler']['bids']);?></p>

							<?php if(empty($auction['Product']['fixed'])) : ?>
								<p><?php echo sprintf(__('The minimum price is <strong>%s</strong> and the maximum price is <strong>%s</strong>.', true), $number->currency($bidbutler['Bidbutler']['minimum_price'], $appConfigurations['currency']), $number->currency($bidbutler['Bidbutler']['maximum_price'], $appConfigurations['currency']));?></p>
							<?php endif; ?>

							<p><?php echo $html->link(__('Delete this Bid Buddy >>', true), array('controller' => 'bidbutlers', 'action' => 'delete', $bidbutler['Bidbutler']['id'], true), null, sprintf(__('Are you sure you want to delete this bid buddy?', true))); ?></p>

							<div class="bid-butler">
								<p><?php __('Replace your Bid Buddy'); ?></p>
						<?php else : ?>
							<div class="bid-butler">
								<p><?php __('Add a Bid Buddy'); ?></p>
						<?php endif; ?>

						<?php echo $form->create('Bidbutler', array('url' => '/bidbuddies/add/'.$auction['Auction']['id']));?>
							<?php if(empty($auction['Product']['fixed'])) : ?>
								<input name="data[Bidbutler][minimum_price]" type="text" style="width: 70px;" value="min price" onFocus=this.value=''>&nbsp;
								<input name="data[Bidbutler][maximum_price]" type="text" style="width: 70px;" value="max price" onFocus=this.value=''>&nbsp;
							<?php endif; ?>
							<input name="data[Bidbutler][bids]" type="text" style="width: 60px;" value="bids" onFocus=this.value=''>
							<p class="auto-bid">
								<?php echo $form->submit('b-add-auto.gif', array('div' => false));?>
							</p>
							<?php echo $form->end();?>
							<p><?php echo $html->link(__('Learn how the Bid Buddy works >>', true), array('controller' => 'bidbutlers', 'action' => 'add', $auction['Auction']['id'])); ?><br />
						</div>
					<?php endif; ?>

				</div>
<!-- END Bid Buddy -->

<!-- Win Limits -->
				<?php if(!empty($limit) && $this->requestAction('/settings/enabled/win_limits')) : ?>
					<div class="savings">
						<div class="count-saving">
							<h3><?php echo sprintf(__('Win Limits - %s', true), $limit['Limit']['name']);?></h3>

							<?php echo sprintf(__('Win limits apply to this auction. You can win %s auctions within %s days.', true), $limit['Limit']['limit'], $limit['Limit']['days']);?>

						</div>
					</div>
				<?php endif; ?>
<!-- END Win Limits -->

<!-- Memberships -->
				<?php if(!empty($auction['Membership']['name']) && $this->requestAction('/settings/enabled/memberships')) : ?>
					<div class="savings">
						<div class="count-saving">
							<h3><?php echo sprintf(__('Membership Restrictions - %s', true), $auction['Membership']['name']);?></h3>

							<?php echo sprintf(__('Your membership level must be at least level \'%s\' in order to bid on this auction.', true), $auction['Membership']['name']);?>
						</div>
					</div>
				<?php endif; ?>
<!-- END Memberships -->

<!-- Rewards Points -->
				<?php if(!empty($auction['Product']['win_points']) && $this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/win_points')) : ?>
					<div class="savings">
						<div class="count-saving">

							<?php echo sprintf(__('Earn %s Reward Points when you win this auction!', true), '<strong>'.$auction['Product']['win_points'].'</strong>');?>

						</div>
					</div>
				<?php endif; ?>
<!-- END Rewards Points -->
				<?php if(!empty($increments) && $this->requestAction('/settings/enabled/auction_increments')) : ?>
					<div class="savings">
						<div class="count-saving">
							<h2><?php __('Auction Increments'); ?></h2>

							<table width="100%" class="table" cellpadding="0" cellspacing="0">
								<tr>
									<th><?php __('Price Range'); ?></th>
									<th><?php __('Bid Increment'); ?></th>
									<th><?php __('Price Increment'); ?></th>
									<th><?php __('Time Increment'); ?></th>
								</tr>
							<?php
							$i = 0;
							foreach ($increments as $increment):
								$class = null;
								if ($i++ % 2 == 0) {
									$class = ' class="altrow"';
								}
							?>
								<tr<?php echo $class;?>>
									<td>
										<?php if($increment['Increment']['low_price'] == '0.00' && $increment['Increment']['high_price'] == '0.00') : ?>
											<?php __('Auction Wide'); ?>
										<?php else : ?>
											<?php echo $number->currency($increment['Increment']['low_price'], $appConfigurations['currency']); ?>
											-
											<?php if($increment['Increment']['high_price'] > 0) : ?>
												<?php echo $number->currency($increment['Increment']['high_price'], $appConfigurations['currency']); ?>
											<?php elseif(!empty($auction['Auction']['reverse'])) : ?>
												<?php echo $number->currency($auction['Product']['start_price'], $appConfigurations['currency']); ?>
											<?php else : ?>
												<?php __('Final Price'); ?>
											<?php endif; ?>
										<?php endif; ?>
									</td>
									<td>
										<?php if($increment['Increment']['bid'] > 1) : ?>
											<?php echo $increment['Increment']['bid']; ?> <?php __('bids'); ?>
										<?php else : ?>
											<?php echo $increment['Increment']['bid']; ?> <?php __('bid'); ?>
										<?php endif; ?>
									</td>
									<td><?php echo $number->currency($increment['Increment']['price'], $appConfigurations['currency']); ?></td>
									<td><?php echo $increment['Increment']['time']; ?> <?php __('seconds'); ?></td>
								</tr>
							<?php endforeach; ?>
							</table>
						</div>
					</div>
				<?php endif; ?>

				</div> <!-- data -->
				<div style="clear: both"></div>
				</div> <!-- .bg-wrap -->

			</div>
		</li>
	</ul>
</div>
</div><!-- content_bg -->

<div id="content_top_auc"><?php __('Product Description');?></div>
<div id="content_bg_auc">
<?php echo $auction['Product']['description'];?></div>

<?php if(!empty($auction['Product']['delivery_information'])) : ?>
	<div id="content_top_auc"><?php __('Delivery Information');?></div>
	<div id="content_bg_auc"> <?php echo nl2br($auction['Product']['delivery_information']); ?></div>
<?php endif; ?>

<div id="content_bottom"></div>

<?php echo $this->element('ending_soon'); ?>

<?php echo $this->element('timeout'); ?>