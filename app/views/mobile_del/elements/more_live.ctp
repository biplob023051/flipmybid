<div class="mid">
	<ul id="sortable2" class="connectedSortable">
<?php if(!empty($auctions)) : ?>    
			<?php foreach($auctions as $auctionItem):
				if($auctionItem['Product']['bids'] >= 1) :
					$strClass = "blu-fuel-box";
					$strTypeIcon = 'B';
					$iconClass = 'blue';
				elseif($auctionItem['Auction']['reverse'] == 1) :
					$strClass = "orng-fuel-box";
					$strTypeIcon = "R";
					$iconClass = 'orange';
				else :
					$strClass = "grn-fuel-box";
					$strTypeIcon = "T";
					$iconClass = 'green';
				endif;
			?> 	
		<li class="auction-item" title="<?php echo $auctionItem['Auction']['id'];?>" id="auction_<?php echo $auctionItem['Auction']['id'];?>">
			<div class="frst <?php //echo $strClass;?>"><?php echo $html->image('fuel-box-img6.jpg'); ?><span class="<?php echo $iconClass;?>"><?php echo $strTypeIcon;?></span></div>
			<div class="scnd">
				<h5><?php echo $html->link($text->truncate($auctionItem['Product']['title'], 35), array('controller' => 'auctions', 'action' => 'view', $auctionItem['Auction']['id']));?></h5>
				<p><?php echo $auctionItem['Product']['brief'];?></p>
				<p>16 second Timer</p>
			</div>
			<div class="thrd">
				<h5>
					<?php if (!empty($auctionItem['Product']['fixed'])): ?>
						<?php echo $number->currency($auctionItem['Product']['fixed_price'], $appConfigurations['currency']); ?>
						<span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?></span>
					<?php else: ?>
						<span class="bid-price">
							<?php echo $number->currency($auctionItem['Auction']['price'], $appConfigurations['currency']); ?>
						</span>
					<?php endif; ?>
				</h5>
				<p>compare to:<br /><?php echo $number->currency($auctionItem['Auction']['rrp'], $appConfigurations['currency']); ?></p>
			</div>
			<div class="frth">
				<h5><span class="bid-bidder"><?php __('username');?></span></h5>
			</div>
			<div class="ffth">
				<h5>
					<?php if (!empty($auctionItem['Auction']['isClosed'])) : ?>
						<label class="timer_10togo time-leftending"><?php __('Ended'); ?></label>
					<?php elseif (!empty($auctionItem['Auction']['isFuture'])) : ?>
						<label class="timer_10togo time-leftending"><?php __('Coming soon'); ?></label>
					<?php else: ?>
						<div id="timer_<?php echo $auctionItem['Auction']['id']; ?>" class="countdown endingtimer timer_10togo time-leftending" title="<?php echo $auctionItem['Auction']['end_time']; ?>">--:--:--</div>
					<?php endif; ?>
				</h5>
						<?php if ($session->check('Auth.User')): ?>
							<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif'); ?></div>
							<div class="bid-button">
								<a href="<?php echo '/bid.php?id=' . $auctionItem['Auction']['id']; ?>" class="bid-button-link" title='<?php echo $auctionItem['Auction']['id']; ?>'>Bid</a>
							</div>
						<?php else: ?>
							<div class="bid-button">
								<a href="/users/login" class="loginfirst">Login</a>
							</div>
						<?php endif; ?>
				<a href="#" class="drag-link"><span>&nbsp;</span></a>
			</div>
			<div class="clr"></div>
			<div class="bid-message" style="display: none;color:red; text-align:center;">bid-message</div>
			
		</li>
		<?php endforeach;?>
		<?php endif;?>
	</ul>
</div>