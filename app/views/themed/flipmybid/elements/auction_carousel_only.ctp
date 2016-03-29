<div id="carousel-home-generic3"
     class="carousel slide" data-ride="carousel">
    <div class="carousel-inner"
         role="listbox"
         id="carouselChange3">
        <?php foreach ($auctions as $l => $auction) : ?>
            <?php if ($l % 4 == 0): ?>
                <div class="clearfix"></div>
            <?php endif; ?>
            <div class="item <?php if(0 == $l): ?>active<?php endif; ?> auction-item" key="<?php echo $auction['Auction']['id']; ?>"
                 id="auction_<?php echo $auction['Auction']['id']; ?>">
                <div class="carousel-caption" style="font-size:18px;position: static;padding: 0;right:0;left:0;">
                    <?php if(!empty($auction['Product']['title'])): ?>
                    <h3>
                        <?php echo $html->link($auction['Product']['title'], array(
                            'controller' => 'auctions',
                            'action' => 'view', $auction['Auction']['id'])); ?>
                    </h3>
                    <?php endif; ?>
                </div>
                <a href="/auction/<?php echo $auction['Auction']['id']; ?>" style="margin: 0 auto;">
                <?php if (!empty($auction['Auction']['image'])): ?>
                    <?php echo $html->image($auction['Auction']['image'], array('style' => 'margin: 0 auto;',
                        'alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
                <?php else: ?>
                    <?php echo $html->image('product_images/thumbs/no-image.gif', array('style' => 'margin: 0 auto;')); ?>
                <?php endif; ?>
                </a>
                <div class="carousel-caption-bottom">
                    <?php if (!empty($auction['Product']['rrp'])) : ?>
                        <p><?php __('RRP'); ?>
                            : <?php echo $number->currency($auction['Product']['rrp'], $appConfigurations['currency']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($auction['Auction']['closed'])): ?>
                        <p class="timer"><?php __('GONE'); ?></p>
                    <?php elseif (!empty($auction['Auction']['isFuture'])) : ?>
                        <p><?php __('Starts:'); ?><?php echo $time->niceShort($auction['Auction']['start_time']); ?></p>
                    <?php else : ?>
                        <p id="timer_<?php echo $auction['Auction']['id']; ?>" class="timer countdown"><?php __('Loading...'); ?></p>
                    <?php endif; ?>

                    <p class="price">
                        <?php if (!empty($auction['Product']['fixed'])): ?>
                            <?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']); ?>
                            <span class="bid-price-fixed"
                                  style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
                        <?php else: ?>
                            <?php if (!empty($auction['Auction']['reverse']) && $auction['Auction']['price'] < 0 && empty($auction['Auction']['price_past_zero'])) : ?>
                                <span class="bid-price-fixed"
                                      style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
                                <span class="bid-price"><?php echo $number->currency(0, $appConfigurations['currency']); ?></span>
                            <?php else : ?>
                                <span
                                    class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </p>


                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control no-background" href="#carousel-home-generic3" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control no-background" href="#carousel-home-generic3" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <div class="clearfix" style="padding-top:20px;"></div>
    <ol class="carousel-indicators">
        <?php foreach ($auctions as $k => $auction) : ?>
            <li data-target="#carousel-home-generic" data-slide-to="<?php echo $k ?>" <?php if(0 == $k): ?>class="active"<?php endif; ?>></li>
        <?php endforeach; ?>
    </ol>
</div>