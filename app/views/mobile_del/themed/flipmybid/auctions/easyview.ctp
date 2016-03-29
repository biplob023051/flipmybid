<div class="g1">
	<div id="auctions-easyview" class="rounded">
		<div id="tabs">
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="/auctions">Live Auctions</a></li>
				<li><a href="/auctions/closed">Closed Auctions</a></li>
				<li><a href="/auctions/future">Upcoming Auctions</a></li>
				<li class="menuactive"><a href="/auctions/easyview">Easy View</a></li>
			</ul>
		</div>
		
		<?php if(!empty($auctions)) : ?>
			<div class="paging-auct">
				<?php echo $this->element('pagination'); ?>
			</div>

			<?php foreach ($auctions as $auction) : ?>
				<?php echo $this->element('auction', array('auction' => $auction)); ?>
			<?php endforeach; ?>

			<div class="paging-auct">
				<?php echo $this->element('pagination'); ?>
			</div>
		<?php else : ?>
			<p class="no-auction"><?php __('There are no live auctions at the moment.');?></p>
		<?php endif; ?>
		
	</div>
</div>	