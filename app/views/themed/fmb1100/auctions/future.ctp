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
	<ul class="nav nav-tabs nav-justified d-none" style="border-bottom: 2px solid #08afd8;border-top: 2px solid #08afd8;     margin-top: 5px; background-color:#08afd8; border-radius:0;">
		<div class="col-xs-4" style="width:20%; text-align:center; font-size: 18px;"><li style="padding:5px 0 3px 0; text-align:right;"><a href="/auctions" style="color:#fff;">Live</a></li></div>
		<div class="col-xs-4" style="width: 1px; padding-left: 0 !important;   padding-right: 0 !important;     height: 30px;     margin: 4px 0;     padding-top: 0;     font-size: 25px;color:#fff;">|</div>
		<div class="col-xs-4" style="width:26%; text-align:center; font-size: 18px;"><li style="padding:5px 0 3px 0;"><a href="/auctions/closed" style="color:#fff;">Closed</a></li></div>
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