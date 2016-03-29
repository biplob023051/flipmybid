<li><?php echo $html->link(__('Home', true), array('controller' => 'dashboards', 'action' => 'index'), array('class'=>'navs', 'style' => 'color:#FFF !important;'));?></li>
<li class="dropdown">
        <?php echo $html->link(__('Manage Auctions <span class="caret"></span>', true),
            array(
            'controller' => 'auctions',
            'action' => 'index'),
            array(
                'class'=>'navs drops dropdown-toggle',
                'style' => 'color:#FFF !important;',
                'data-toggle' => 'dropdown',
                'role' => 'button',
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false',
                'escape'=>false)
        );
        ?>
    <ul class="dropdown-menu">
        <li><?php echo $html->link(__('Products', true), array('controller' => 'products', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
            <li><?php echo $html->link(__('Rewards Store', true), array('controller' => 'products', 'action' => 'index', true), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <li><?php echo $html->link(__('Live Auctions', true), array('controller' => 'auctions', 'action' => 'live'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Coming Soon', true), array('controller' => 'auctions', 'action' => 'comingsoon'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Closed Auctions', true), array('controller' => 'auctions', 'action' => 'closed'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Won Auctions', true), array('controller' => 'auctions', 'action' => 'won'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <?php if($this->requestAction('/settings/get/charity_auctions')) : ?>
            <li><?php echo $html->link(__('Charity Auctions', true), array('controller' => 'auctions', 'action' => 'charity'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/buy_now')) : ?>
            <li><?php echo $html->link(__('Products Purchased', true), array('controller' => 'exchanges', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/reward_points') && $this->requestAction('/settings/get/rewards_store')) : ?>
            <li><?php echo $html->link(__('Redeemed Rewards', true), array('controller' => 'rewards', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <li><?php echo $html->link(__('Bids Placed', true), array('controller' => 'bids', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Packages Purchased', true), array('controller' => 'accounts', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
    </ul>
</li>
<li class="dropdown">
        <?php echo $html->link(__('Manage Content <span class="caret"></span>', true), array('controller' => 'pages', 'action' => 'index'), array(
            'class'=>'navs drops dropdown-toggle',
            'style' => 'color:#FFF !important;',
            'data-toggle' => 'dropdown',
            'role' => 'button',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'escape'=>false));?>
    <ul class="dropdown-menu">
        <li><?php echo $html->link(__('Pages', true), array('controller' => 'pages', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php if($this->requestAction('/settings/enabled/latest_news')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Latest News', true), array('controller' => 'news', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/get/news_comments')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('News Comments', true), array('controller' => 'comments', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/forum')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Forum', true), array('controller' => 'posts', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/testimonials')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Testimonials', true), array('controller' => 'testimonials', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/help_section')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Help Section', true), array('controller' => 'sections', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/banners')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Banners', true), array('controller' => 'banners', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/landing_pages')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Landing Pages', true), array('controller' => 'landings', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
    </ul>
</li>
<li class="dropdown">
        <?php echo $html->link(__('Manage Users <span class="caret"></span>', true), array('controller' => 'users', 'action' => 'index'), array(
            'class'=>'navs drops dropdown-toggle',
            'style' => 'color:#FFF !important;',
            'data-toggle' => 'dropdown',
            'role' => 'button',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'escape'=>false));?>
    <ul class="dropdown-menu">
        <li><?php echo $html->link(__('Users', true), array('controller' => 'users', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Online Users', true), array('controller' => 'users', 'action' => 'online'), array('style' => 'color:#FFF !important;'));?></li>
        <?php if($this->requestAction('/settings/enabled/referrals')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Referrals', true), array('controller' => 'referrals', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
        <?php if($this->requestAction('/settings/enabled/testing_mode')) : ?>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Autobidders', true), array('controller' => 'users', 'action' => 'autobidders'), array('style' => 'color:#FFF !important;'));?></li>
        <?php endif; ?>
    </ul>
</li>
<?php if($this->requestAction('/settings/enabled/newsletters')) : ?>
    <li><?php echo $html->link(__('Manage Newsletters', true), array('controller' => 'newsletters', 'action' => 'index'), array('class'=>'navs', 'style' => 'color:#FFF !important;'));?></li>
<?php endif; ?>
<li class="dropdown">
        <?php echo $html->link(__('Settings <span class="caret"></span>', true), array('controller' => 'settings', 'action' => 'index'), array(
            'class'=>'navs drops dropdown-toggle',
            'style' => 'color:#FFF !important;',
            'data-toggle' => 'dropdown',
            'role' => 'button',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
            'escape'=>false));?>
    <ul class="dropdown-menu">
        <li><?php echo $html->link(__('Packages', true), array('controller' => 'packages', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <!-- Change By Andrew Buchan: Add link to admin list of buy it packages -->
        <li><?php echo $html->link(__('Buy It Packages', true), array('controller' => 'buy_it_packages', 'action' => 'index/page:1/sort:created/direction:desc'), array('style' => 'color:#FFF !important;'));?></li>
        <!-- End Change -->
        <li role="separator" class="divider"></li>

        <?php if($this->requestAction('/settings/enabled/coupons')) : ?>
            <li><?php echo $html->link(__('Coupons', true), array('controller' => 'coupons', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif;?>

        <?php if($this->requestAction('/settings/enabled/forum')) : ?>
            <li><?php echo $html->link(__('Forum Topics', true), array('controller' => 'topics', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>

        <li><?php echo $html->link(__('Categories', true), array('controller' => 'categories', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Countries', true), array('controller' => 'countries', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Currencies', true), array('controller' => 'currencies', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('Languages', true), array('controller' => 'languages', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>

        <?php if($this->requestAction('/settings/enabled/win_limits')) : ?>
            <li><?php echo $html->link(__('Win Limits', true), array('controller' => 'limits', 'action' => 'index'), array('style' => 'color:#FFF !important;')); ?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>

        <?php if($this->requestAction('/settings/enabled/memberships')) : ?>
            <li><?php echo $html->link(__('Memberships', true), array('controller' => 'memberships', 'action' => 'index'), array('style' => 'color:#FFF !important;')); ?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>

        <li><?php echo $html->link(__('Auction Statuses', true), array('controller' => 'statuses', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>

        <?php if($this->requestAction('/settings/get/departments')) : ?>
            <li><?php echo $html->link(__('Departments', true), array('controller' => 'departments', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>

        <?php if($this->requestAction('/settings/get/registration_options')) : ?>
            <li><?php echo $html->link(__('Registration Sources', true), array('controller' => 'sources', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>

        <?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
            <li><?php echo $html->link(__('Genders', true), array('controller' => 'genders', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
            <li><?php echo $html->link(__('Address Types', true), array('controller' => 'user_address_types', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
            <li role="separator" class="divider"></li>
        <?php endif;?>

        <li><?php echo $html->link(__('Modules', true), array('controller' => 'modules', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
        <li role="separator" class="divider"></li>
        <li><?php echo $html->link(__('General Settings', true), array('controller' => 'settings', 'action' => 'index'), array('style' => 'color:#FFF !important;'));?></li>
    </ul>
</li>
