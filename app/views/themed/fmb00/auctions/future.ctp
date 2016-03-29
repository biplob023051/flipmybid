<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
<div class="col-md-8 auctions">
	<ul class="nav nav-tabs nav-justified m-none">
		<li><a href="/">Home</a></li>
		<li><a href="/auctions">Live Auctions</a></li>
		<li><a href="/auctions/closed">Closed Auctions</a></li>
		<li class="menuactive"><a href="/auctions/future">Upcoming Auctions</a></li>
	</ul>
	<ul class="nav nav-tabs nav-justified d-none">
		<div class="col-xs-4"><li><a href="/auctions">Live</a></li></div>
		<div class="col-xs-4"><li><a href="/auctions/closed">Closed</a></li></div>
		<div class="col-xs-4"><li class="menuactive"><a href="/auctions/future">Upcoming</a></li></div>
	</ul>				
	<div class="auction-content">
		<?php if(!empty($auctions)) : ?>
		<div class="paging-auct col-md-12"><?php echo $this->element('pagination'); ?></div>
		<?php foreach ($auctions as $auction) : ?>
		<?php echo $this->element('auction', array('auction' => $auction)); ?>
		<?php endforeach; ?>
		<div class="paging-auct col-md-12"><?php echo $this->element('pagination'); ?></div>
		<?php else : ?>
		<div class="no-auction"><?php __('<h2>Check Again Soon</h2><p>There are no upcoming auctions at the moment.</p>');?></div>
		<?php endif; ?>
	</div>
</div>