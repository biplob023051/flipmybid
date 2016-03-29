<div id="tabs" class="visible-lg visible-md">
    <ul class="nav nav-links-top" style="min-width: 200px !important;display: table !important;">
        <li <?php if ('Live' == $active || ($this->params['controller'] == 'auctions' && $this->params['action'] == 'home')): ?> class="menuactive" <?php endif; ?> style="display: block;float: left;">
            <a href="/auctions" class="liveAuctionClick">Live Auctions</a>
        </li>
        <li <?php if ('Future' == $active): ?> class="menuactive" <?php endif; ?> style="display: block;float: left;">
            <a href="/auctions/future" class="upcomingAuctionClick">Upcoming Auctions</a></li>
        <li <?php if ('Closed' == $active): ?> class="menuactive" <?php endif; ?> style="display: block;float: left;">
            <a href="/auctions/closed" class="closedAuctionClick">Closed Auctions</a></li>
    </ul>
</div>
<div class="visible-sm" style="background-color: #eaeaea">
    <ul class="nav nav-pills" style="min-width:200px !important; display: table !important;margin: 0 auto;">
        <li role="presentation" <?php if ('Live' == $active || ($this->params['controller'] == 'auctions' && $this->params['action'] == 'home')): ?> class="active" <?php endif; ?>>
            <a href="/auctions" class="liveAuctionClick">Live</a></li>
        <li role="presentation" <?php if ('Future' == $active): ?> class="active" <?php endif; ?>><a
                href="/auctions/future" class="upcomingAuctionClick">Upcoming</a></li>
        <li role="presentation" <?php if ('Closed' == $active): ?> class="active" <?php endif; ?>><a
                href="/auctions/closed" class="closedAuctionClick">Closed</a></li>
    </ul>
</div>

<div class="visible-xs" style="background-color: #eaeaea">
    <ul class="nav nav-pills nav-stacked " style="min-width:200px !important; display: table !important;margin: 0 auto;">
        <li role="presentation" <?php if ('Live' == $active || ($this->params['controller'] == 'auctions' && $this->params['action'] == 'home')): ?> class="active" <?php endif; ?>>
            <a href="/auctions" class="liveAuctionClick">Live</a></li>
        <li role="presentation" <?php if ('Future' == $active): ?> class="active" <?php endif; ?>><a
                href="/auctions/future" class="upcomingAuctionClick">Upcoming</a></li>
        <li role="presentation" <?php if ('Closed' == $active): ?> class="active" <?php endif; ?>><a
                href="/auctions/closed" class="closedAuctionClick">Closed</a></li>
    </ul>
</div>
<div class="clearfix"></div>