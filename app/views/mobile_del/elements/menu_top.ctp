<?php $pages = $this->requestAction('/pages/getpages/top');?>
<?php $liveCount = $this->requestAction('/auctions/getcount/live'); ?>

<div id="menu">
	<ul class="sf-menu">
	<li><?php echo $html->link(__('Home', true), '/'); ?></li>
	<li><a href="/auctions"><?php __('Live Auctions'); ?> (<?php echo $liveCount; ?>)</a></li>
	<?php if($this->requestAction('/settings/enabled/latest_news')) : ?>
		<li><?php echo $html->link(__('News', true), '/news'); ?></li>
	<?php endif; ?>

	<?php if($this->requestAction('/settings/enabled/help_section')) : ?>
		<li><?php echo $html->link(__('Help', true), '/help'); ?></li>
	<?php endif; ?>

	<?php if($this->requestAction('/settings/enabled/testimonials')) : ?>
		<li><?php echo $html->link(__('Testimonials', true), '/testimonials'); ?></li>
	<?php endif; ?>

	<?php if(!empty($pages)):?>
		<?php foreach($pages as $page):?>
			<li><?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?></li>
		<?php endforeach;?>
	<?php endif;?>

	<?php if($this->requestAction('/settings/enabled/forum')) : ?>
		<li><?php echo $html->link(__('Forum', true), '/forum'); ?></li>
	<?php endif; ?>

	<?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
		<li><?php echo $html->link(__('Rewards Store', true), '/rewards'); ?></li>
	<?php endif; ?>

	<?php if($session->check('Auth.User')):?>
		<li><?php echo $html->link(__('My Account', true), array('controller' => 'users', 'action'=> 'index')); ?></li>
	<?php else: ?>
		<li><?php echo $html->link(__('Login', true), array('controller' => 'users', 'action'=> 'login')); ?></li>
		<li class="reg-menu"><?php echo $html->link(__('Register', true), array('controller' => 'users', 'action'=> 'register')); ?></li>
	<?php endif; ?>

	<?php $menuCategories = $this->requestAction('/categories/getlist/parent/all/count'); ?>
	<?php $futureCount = $this->requestAction('/auctions/getcount/future'); ?>
    <?php $beginnerCount = $this->requestAction('/auctions/getcount/beginner'); ?>
	<li>
		<a href="/categories"><?php __('Categories'); ?></a>
		<ul class="sf-ul">
			<li><a href="/auctions/beginner"><?php __('Beginner Auctions'); ?> (<?php echo $beginnerCount; ?>)</a></li>
			<?php if(!empty($menuCategories)) : ?>
				<?php foreach($menuCategories as $menuCategory): ?>
					<li><a href="/categories/view/<?php echo $menuCategory['Category']['id']; ?>"><?php echo $menuCategory['Category']['name']; ?> (<?php echo $menuCategory['Category']['count']; ?>)</a></li>
				<?php endforeach; ?>
			<?php endif; ?>
			<li><a href="/auctions/closed"><?php __('Ended Auctions'); ?></a></li>
			<?php if($session->check('Auth.User')):?>
				<?php $watchlistCount = $this->requestAction('/watchlists/count');?>
				<?php if($watchlistCount > 0) : ?>
					<li><strong><a href="/watchlists"><?php __('My Watchlist'); ?> (<?php echo $watchlistCount; ?>)</a></strong></li>
				<?php else: ?>
					<li><a href="/watchlists"><?php __('My Watchlist'); ?> (<?php echo $watchlistCount; ?>)</a></li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</li>
	</ul>
</div>