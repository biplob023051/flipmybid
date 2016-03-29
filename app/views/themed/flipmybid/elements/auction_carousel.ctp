<div id="carousel-home-generic<?php if(!($this->params['controller'] == 'auctions' && $this->params['action'] == 'future')): ?>2<?php endif; ?>"
     class="carousel slide" data-ride="carousel">
    <div class="carousel-inner"
         role="listbox"
         id="carouselChange<?php if(!($this->params['controller'] == 'auctions' && $this->params['action'] == 'future')): ?>2<?php endif; ?>">
        <?php foreach ($auctions as $l => $auction) : ?>
            <?php if ($l % 4 == 0): ?>
                <div class="clearfix"></div>
            <?php endif; ?>
            <div class="item <?php if(0 == $l): ?>active<?php endif; ?> auction-item" key="<?php echo $auction['Auction']['id']; ?>"
                 id="auction_<?php echo $auction['Auction']['id']; ?>">
                <div class="carousel-caption">
                    <h3>
                        <?php echo $html->link($auction['Product']['title'], array(
                            'controller' => 'auctions',
                            'action' => 'view', $auction['Auction']['id'])); ?>
                    </h3>
                </div>
                <a href="/auction/<?php echo $auction['Auction']['id']; ?>">
                <?php if (!empty($auction['Auction']['image'])): ?>
                    <?php echo $html->image($auction['Auction']['image'], array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
                <?php else: ?>
                    <?php echo $html->image('product_images/thumbs/no-image.gif'); ?>
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

                    <?php if (!empty($auction['Auction']['closed'])): ?>
                        <?php if (!empty($auction['Winner']['username'])): ?>
                            <p class="username"><?php echo $auction['Winner']['username']; ?></p>
                        <?php else : ?>
                            <p class="username"><?php __('No winner!'); ?></p>
                        <?php endif; ?>
                    <?php elseif (empty($auction['Auction']['isFuture'])): ?>
                        <p class="username"><span class="bid-bidder"><?php __('username'); ?></span></p>
                    <?php endif; ?>

                    <?php if (empty($auction['Auction']['closed']) && empty($auction['Auction']['isFuture'])): ?>
                        <?php if ($session->check('Auth.User')): ?>
                            <a href="/bid.php?id=<?php echo $auction['Auction']['id']; ?>" class="bidbutton bid-button-link"
                               title="<?php echo $auction['Auction']['id']; ?>">
                                <?php $bidDebit = $this->requestAction('/settings/get/bid_debit/' . $auction['Auction']['id']);
                                if (!empty($bidDebit)) : ?><?php echo $bidDebit; ?><?php else : ?>1<?php endif; ?>x
                                bid<?php if (!empty($bidDebit) && $bidDebit > 1) : ?>s<?php endif; ?></a>
                            <div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif'); ?></div>
                            <div class="bid-message" style="display: none;">&nbsp;</div>
                        <?php else : ?>
                            <a href="/users/register" class="bidbutton">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- Controls -->
    <a class="left carousel-control visible-xs visible-sm" href="#carousel-home-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control visible-xs visible-sm" href="#carousel-home-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

    <ol class="carousel-indicators visible-xs visible-sm">
        <?php foreach ($auctions as $k => $auction) : ?>
            <li data-target="#carousel-home-generic" data-slide-to="<?php echo $k ?>" <?php if(0 == $k): ?>class="active"<?php endif; ?>></li>
        <?php endforeach; ?>
    </ol>
</div>