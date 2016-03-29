<?php if(empty($auction['Auction']['isClosed'])) : ?>
	<?php if(empty($auction['Auction']['id'])) {
		$auction['Auction']['id'] = 0;
	} ?>
	<?php $auctions_end_soon = $this->requestAction('/auctions/endingsoon/'.$auction['Auction']['id'].'/0/0/5'); ?>
<?php else : ?>
	<?php $auctions_end_soon = $this->requestAction('/auctions/endingsoon/'.$auction['Auction']['id'].'/'.$auction['Auction']['product_id'].'/1/5'); ?>
	<?php if(empty($auctions_end_soon)) : ?>
		<?php $auctions_end_soon = $this->requestAction('/auctions/endingsoon/'.$auction['Auction']['id'].'/0/0/5'); ?>
	<?php endif; ?>

	<?php if(!$session->check('Auth.User')) : ?>
		<div>&nbsp;</div>
	<?php endif; ?>
<?php endif; ?>
<br />
<?php if(!empty($auctions_end_soon)) : ?>
<div id="ending-soon">
	<ul class="horizontal-auctions"><div id="content_top_auc"><?php __('Ending Soon');?></div>
    <div id="content_bg_auc">
		<?php foreach($auctions_end_soon as $auctionItem):?>
		<li class="auction-item" title="<?php echo $auctionItem['Auction']['id'];?>" id="auction_<?php echo $auctionItem['Auction']['id'];?>">
			<div class="content">
				<h3><?php echo $html->link($text->truncate($auctionItem['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auctionItem['Auction']['id']));?></h3>
				<div class="wrapper">
					<div class="thumb">
						<a href="/auction/<?php echo $auctionItem['Auction']['id']; ?>">
						<?php if(!empty($auctionItem['Auction']['image'])):?>
							<?php echo $html->image($auctionItem['Auction']['image'], array('border' => 0)); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif', array('border' => 0));?>
						<?php endif;?>
						</a>
					</div>
					<div class="info">
						<div id="timer_<?php echo $auctionItem['Auction']['id'];?>" class="timer countdown" title="<?php echo $auctionItem['Auction']['end_time'];?>">--:--:--</div>
					</div>
						<div class="price">
							<?php if(!empty($auctionItem['Product']['fixed'])):?>
								<?php echo $number->currency($auctionItem['Product']['fixed_price'], $appConfigurations['currency']);?>
								<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span>
							<?php else: ?>
								<span class="bid-price">
									<?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?>
								</span>
							<?php endif; ?>
						</div>
						<div class="username"><span class="bid-bidder"><?php __('username');?></span></div>
					<div class="bid-now">
					<?php if(!empty($auctionItem['Auction']['isFuture'])) : ?>
						<div><?php echo $html->image('b-soon.gif', array('alt' => __('Coming Soon', true), 'title' => __('Coming Soon', true)));?></div>
					 <?php elseif(!empty($auctionItem['Auction']['isClosed'])) : ?>
						<div><?php echo $html->image('b-closed.gif', array('alt' => __('Auction Closed', true), 'title' => __('Auction Closed', true)));?></div>
					 <?php else:?>
						 <?php if($session->check('Auth.User')):?>
							<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
							 <div class="bid-button">
								<?php echo $html->link($html->image('bid_now.png', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true))), '/bid.php?id='.$auctionItem['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auctionItem['Auction']['id'], 'escape' => false));?>
							 </div>
						<?php else:?>
							<div class="bid-button"><?php echo $html->link($html->image('bid_login.png', array('alt' => __('Login', true), 'title' => __('Login', true))), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
						<?php endif;?>

						<?php if(!empty($auctionItem['Auction']['beginner'])) : ?>
							<div class="beginner"><?php __('Beginner Auction'); ?></div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="bid-message" style="display: none;">&nbsp;</div>

				</div> <!-- .wrapper-->
			</div>
		</li>
		<?php endforeach; ?>
	</div></ul><div id="content_bottom"></div>
</div>
<?php endif;?>