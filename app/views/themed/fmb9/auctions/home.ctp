<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
<div class="pure-u-1 pure-u-md-3-4 auctions">
		
	<div class="pure-menu pure-menu-horizontal tabs">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="/" class="pure-menu-link mobi">Home</a></li>
			<li class="pure-menu-item"><a href="/auctions" class="pure-menu-link">Live <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/closed" class="pure-menu-link">Closed <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/future" class="pure-menu-link">Upcoming <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/easyview" class="pure-menu-link">Easy View</a></li>
		</ul>
	</div>
			
			
	<?php if(!empty($auctions_end_soon)) : ?>
		<?php foreach ($auctions_end_soon as $auction) : ?>
			<?php echo $this->element('auction', array('auction' => $auction)); ?>
		<?php endforeach; ?>
	<?php else : ?>
	
	<div class="c-content">
	<h2>Check Again Soon</h2>
	<p>There are currently no live auctions. Please check again soon.</p>
	</div>

	<?php endif; ?>

	<!--/ Listing -->
    <!--/ Auctions -->
</div>




