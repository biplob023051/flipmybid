<?php $menuCategories = $this->requestAction('/categories/getlist/parent/all/count'); ?>
<?php $liveCount = $this->requestAction('/auctions/getcount/live'); ?>
<?php $beginnerCount = $this->requestAction('/auctions/getcount/beginner'); ?>

<div id="select-categories">
	<ul id="nav">
		<li>
			<a>Select a Category</a>
			<ul>
				<li><a href="/categories">All Categories</a>
				<li><a href="/auctions">Live Auctions (<?php echo $liveCount; ?>)</a>
				<li><a href="/auctions/beginner">Beginner Auctions (<?php echo $beginnerCount; ?>)</a>
				<?php if(!empty($menuCategories)) : ?>
					<?php foreach($menuCategories as $menuCategory): ?>
						<li class="child"><a href="/categories/view/<?php echo $menuCategory['Category']['id']; ?>"><?php echo $menuCategory['Category']['name']; ?> (<?php echo $menuCategory['Category']['count']; ?>)</a></li>
					<?php endforeach; ?>
				<?php endif; ?>
				<li><a href="/auctions/closed">Ended Auctions</a></li>
				<?php if($session->check('Auth.User')):?>
					<?php $watchlistCount = $this->requestAction('/watchlists/count');?>
					<?php if($watchlistCount > 0) : ?>
						<li><strong><a href="/watchlists">My Watchlist (<?php echo $watchlistCount; ?>)</a></strong></li>
					<?php else: ?>
						<li><a href="/watchlists">My Watchlist (<?php echo $watchlistCount; ?>)</a></li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
		</li>
	</ul>
</div>