<div id="products">
	<div class="col1">
		<?php if(!empty($featured)) : ?>
			<?php
			// lets see if only one featured auction is selected
			if(!empty($featured['Auction'])) {
				$feature = $featured;
				unset($featured);
				$featured[0] = $feature;
			} ?>
        	<ul class="horizontal-auctions"><div id="content_top_featured"><?php __('Featured Auctions');?></div>
			<div id="content_bg_featured">
		<?php foreach($featured as $auction):?>
		<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">

			<div class="content">
				<h3><?php echo $html->link($text->truncate($auction['Product']['title'], 35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></h3>
				<div class="wrapper">
					<div class="thumb">
						<a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
					</div>
					<div class="info">
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>"><?php __('Loading...'); ?></div>
					</div>
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
					<div class="bid-now">
					<?php if(!empty($auction['Auction']['isFuture'])) : ?>
						<div><?php echo $html->image('b-soon.gif', array('alt' => __('Coming Soon', true), 'title' => __('Coming Soon', true)));?></div>
					 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
						<div><?php echo $html->image('b-closed.gif', array('alt' => __('Auction Closed', true), 'title' => __('Auction Closed', true)));?></div>
					 <?php else:?>
						 <?php if($session->check('Auth.User')):?>
							 <div class="bid-button">
							 	<?php echo $html->link($html->image('bid_now.png', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true))), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
							 	<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
							 	<div class="bid-message" style="display: none;">&nbsp;</div>
							</div>
						<?php else:?>
							<div class="bid-button"><?php echo $html->link($html->image('bid_login.png', array('alt' => __('Login', true), 'title' => __('Login', true))), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
						<?php endif;?>


					<?php endif; ?>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
	</ul>
	 </div><div id="content_bottom"></div><?php endif; ?>

	<div id="right_ads">
    </div>
	<?php if(!empty($auctions_end_soon)) : ?>
	<ul class="horizontal-auctions"><div id="content_top"><?php __('Ending Soon');?></div>
<div id="content_bg">
		<?php foreach($auctions_end_soon as $auction):?>
		<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">

<div class="content">
				<h3><?php echo $html->link($text->truncate($auction['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></h3>
				<div class="wrapper">
					<div class="thumb">
						<a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
					</div>
					<div class="info">
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>"><?php __('Loading...'); ?></div>
					</div>
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
					<div class="bid-now">
					<?php if(!empty($auction['Auction']['isFuture'])) : ?>
						<div><?php echo $html->image('b-soon.gif', array('alt' => __('Coming Soon', true), 'title' => __('Coming Soon', true)));?></div>
					 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
						<div><?php echo $html->image('b-closed.gif', array('alt' => __('Auction Closed', true), 'title' => __('Auction Closed', true)));?></div>
					 <?php else:?>
						 <?php if($session->check('Auth.User')):?>
							 <div class="bid-button">
							 	<?php echo $html->link($html->image('bid_now.png', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true))), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
							 	<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
							 	<div class="bid-message" style="display: none;">&nbsp;</div>
							</div>
						<?php else:?>
							<div class="bid-button"><?php echo $html->link($html->image('bid_login.png', array('alt' => __('Login', true), 'title' => __('Login', true))), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
						<?php endif;?>


					<?php endif; ?>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
	</ul></div><div id="content_bottom"></div>
	<?php endif; ?>
</br>
		<?php if(!empty($auctions_coming_soon)) : ?>
	<ul class="horizontal-auctions-later"><div id="content_top"><?php __('Coming Soon');?></div>
<div id="content_bg">
		<?php foreach($auctions_coming_soon as $auction):?>
		<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">

<div class="content">
				<h3><?php echo $html->link($text->truncate($auction['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></h3>
				<div class="wrapper">
					<div class="thumb">
						<a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
					</div>

					<div class="price">
							<?php if(!empty($auction['Product']['fixed'])):?>
								<?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
								<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php else: ?>
								<span class="bid-price">
									<?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
								</span>
							<?php endif; ?>
						</div><div class="info">
						<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>"><?php __('Loading...'); ?></div>
					</div>
					<div class="username"><?php __('');?> <span class="bid-bidder"><?php __('username');?></span></div>
					<div class="bid-now">
					<?php if(!empty($auction['Auction']['isFuture'])) : ?>
						<div><?php echo $html->image('b-soon.gif', array('alt' => __('Coming Soon', true), 'title' => __('Coming Soon', true)));?></div>
					 <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
						<div><?php echo $html->image('b-closed.gif', array('alt' => __('Auction Closed', true), 'title' => __('Auction Closed', true)));?></div>
					 <?php else:?>
						 <?php if($session->check('Auth.User')):?>
							 <div class="bid-button">
							 	<?php echo $html->link($html->image('bid_now.png', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true))), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
							 	<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
							 	<div class="bid-message" style="display: none;">&nbsp;</div>
							</div>
						<?php else:?>
							<div class="bid-button"><?php echo $html->link($html->image('bid_login.png', array('alt' => __('Login', true), 'title' => __('Login', true))), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
						<?php endif;?>


					<?php endif; ?>
				</div>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
	</ul><div id="content_bottom"></div>
	<?php endif; ?>

<?php echo $this->element('timeout'); ?>