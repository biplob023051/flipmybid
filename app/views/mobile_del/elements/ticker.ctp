<?php $tickerAuctions = $this->requestAction('/auctions/gettickerauctions');?>
<?php if(!empty($tickerAuctions)) : ?>
	<marquee direction="left" width="445">
		<?php __('Latest winners');?>
		<?php foreach($tickerAuctions as $auction) : ?>
			<strong><?php echo $time->format('h:ia', $auction['Auction']['end_time']); ?></strong> -
			<?php echo $auction['Winner']['username']; ?> -
			<a href="/auction/<?php echo $auction['Auction']['id']; ?>"><?php echo $auction['Product']['title']; ?></a>
			<?php if($auction['Product']['fixed']) : ?>
				<?php __('End Price:'); ?> <strong><?php echo $auction['Product']['fixed_price']; ?></strong>
			<?php else : ?>
				<?php __('End Price:'); ?> <strong><?php echo $auction['Auction']['price']; ?></strong>
			<?php endif; ?>
		<?php if(!empty($auction['Product']['rrp'])) : ?>
			<?php if($auction['Product']['fixed']) : ?>
				- <?php __('Savings');?>: <strong><?php echo $number->toPercentage(($auction['Product']['rrp'] - $auction['Product']['fixed_price']) / $auction['Product']['rrp'] * 100); ?></strong>
			<?php else : ?>
				- <?php __('Savings');?>: <strong><?php echo $number->toPercentage(($auction['Product']['rrp'] - $auction['Auction']['price']) / $auction['Product']['rrp'] * 100); ?></strong>
			<?php endif; ?>
		<?php endif; ?>
		...
		<?php endforeach; ?>
	</marquee>
<?php else : ?>
	<?php __('No Auctions have ended yet, be the first one to win!');?>
<?php endif; ?>
