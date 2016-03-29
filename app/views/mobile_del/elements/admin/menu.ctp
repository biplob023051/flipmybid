<div id="nav">
    <ul class="sf-menu">
        <li><?php echo $html->link(__('Home', true), array('controller' => 'dashboards', 'action' => 'index'));?></li>
        <li><?php echo $html->link(__('Manage Auctions', true), array('controller' => 'auctions', 'action' => 'index'));?>
            <ul>
                <li><?php echo $html->link(__('Products', true), array('controller' => 'products', 'action' => 'index'));?></li>
                <?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
                	<li><?php echo $html->link(__('Rewards Store', true), array('controller' => 'products', 'action' => 'index', true));?>
                <?php endif; ?>
                <li><?php echo $html->link(__('Live Auctions', true), array('controller' => 'auctions', 'action' => 'live'));?></li>
                <li><?php echo $html->link(__('Coming Soon', true), array('controller' => 'auctions', 'action' => 'comingsoon'));?></li>
                <li><?php echo $html->link(__('Closed Auctions', true), array('controller' => 'auctions', 'action' => 'closed'));?></li>
                <li><?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'won'));?></li>
                <?php if($this->requestAction('/settings/get/charity_auctions')) : ?>
                	<li><?php echo $html->link(__('Charity Auctions', true), array('controller' => 'auctions', 'action' => 'charity'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/buy_now')) : ?>
                	<li><?php echo $html->link(__('Products Purchased', true), array('controller' => 'exchanges', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
                	<li><?php echo $html->link(__('Redeemed Rewards', true), array('controller' => 'rewards', 'action' => 'index'));?></li>
                <?php endif; ?>
                <li><?php echo $html->link(__('Bids Placed', true), array('controller' => 'bids', 'action' => 'index'));?></li>
                <li><?php echo $html->link(__('Packages Purchased', true), array('controller' => 'accounts', 'action' => 'index'));?></li>
            </ul>
        </li>
        <li><?php echo $html->link(__('Manage Content', true), array('controller' => 'pages', 'action' => 'index'));?>
            <ul>
                <li><?php echo $html->link(__('Pages', true), array('controller' => 'pages', 'action' => 'index'));?></li>
                <?php if($this->requestAction('/settings/enabled/latest_news')) : ?>
                	<li><?php echo $html->link(__('Latest News', true), array('controller' => 'news', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/get/news_comments')) : ?>
                	<li><?php echo $html->link(__('News Comments', true), array('controller' => 'comments', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/forum')) : ?>
                	<li><?php echo $html->link(__('Forum', true), array('controller' => 'posts', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/testimonials')) : ?>
                	<li><?php echo $html->link(__('Testimonials', true), array('controller' => 'testimonials', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/help_section')) : ?>
                	<li><?php echo $html->link(__('Help Section', true), array('controller' => 'sections', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/banners')) : ?>
                	<li><?php echo $html->link(__('Banners', true), array('controller' => 'banners', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/landing_pages')) : ?>
                	<li><?php echo $html->link(__('Landing Pages', true), array('controller' => 'landings', 'action' => 'index'));?></li>
                <?php endif; ?>
            </ul>
        </li>
        <li><?php echo $html->link(__('Manage Users', true), array('controller' => 'users', 'action' => 'index'));?>
            <ul>
                <li><?php echo $html->link(__('Users', true), array('controller' => 'users', 'action' => 'index'));?></li>
                <li><?php echo $html->link(__('Online Users', true), array('controller' => 'users', 'action' => 'online'));?></li>
                <?php if($this->requestAction('/settings/enabled/referrals')) : ?>
                	<li><?php echo $html->link(__('Referrals', true), array('controller' => 'referrals', 'action' => 'index'));?></li>
                <?php endif; ?>
                <?php if($this->requestAction('/settings/enabled/testing_mode')) : ?>
                	<li><?php echo $html->link(__('Autobidders', true), array('controller' => 'users', 'action' => 'autobidders'));?></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php if($this->requestAction('/settings/enabled/newsletters')) : ?>
        	<li><?php echo $html->link(__('Manage Newsletters', true), array('controller' => 'newsletters', 'action' => 'index'));?></li>
        <?php endif; ?>
        <li><?php echo $html->link(__('Settings', true), array('controller' => 'settings', 'action' => 'index'));?>
            <ul>
                <li><?php echo $html->link(__('Packages', true), array('controller' => 'packages', 'action' => 'index'));?></li>

				<?php if($this->requestAction('/settings/enabled/coupons')) : ?>
					<li><?php echo $html->link(__('Coupons', true), array('controller' => 'coupons', 'action' => 'index'));?></li>
				<?php endif;?>

				<?php if($this->requestAction('/settings/enabled/forum')) : ?>
                	<li><?php echo $html->link(__('Forum Topics', true), array('controller' => 'topics', 'action' => 'index'));?></li>
                <?php endif; ?>

                <li><?php echo $html->link(__('Categories', true), array('controller' => 'categories', 'action' => 'index'));?></li>
                <li><?php echo $html->link(__('Countries', true), array('controller' => 'countries', 'action' => 'index'));?></li>

                <li><?php echo $html->link(__('Currencies', true), array('controller' => 'currencies', 'action' => 'index'));?></li>
                <li><?php echo $html->link(__('Languages', true), array('controller' => 'languages', 'action' => 'index'));?></li>

				<?php if($this->requestAction('/settings/enabled/win_limits')) : ?>
					<li><?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'index')); ?></li>
				<?php endif; ?>

				<?php if($this->requestAction('/settings/enabled/memberships')) : ?>
					<li><?php echo $html->link(__('Memberships', true), array('controller' => 'memberships', 'action' => 'index')); ?></li>
				<?php endif; ?>

                <li><?php echo $html->link(__('Auction Statuses', true), array('controller' => 'statuses', 'action' => 'index'));?></li>

                <?php if($this->requestAction('/settings/get/departments')) : ?>
                	<li><?php echo $html->link(__('Departments', true), array('controller' => 'departments', 'action' => 'index'));?></li>
                <?php endif; ?>

                <?php if($this->requestAction('/settings/get/registration_options')) : ?>
                	<li><?php echo $html->link(__('Registration Sources', true), array('controller' => 'sources', 'action' => 'index'));?></li>
                <?php endif; ?>

                <?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
					<li><?php echo $html->link(__('Genders', true), array('controller' => 'genders', 'action' => 'index'));?></li>
					<li><?php echo $html->link(__('Address Types', true), array('controller' => 'user_address_types', 'action' => 'index'));?></li>
				<?php endif;?>

				<li><?php echo $html->link(__('Modules', true), array('controller' => 'modules', 'action' => 'index'));?></li>
                <li><?php echo $html->link(__('General Settings', true), array('controller' => 'settings', 'action' => 'index'));?></li>
            </ul>
        </li>
    </ul>
    <div class="clear"></div>
</div>