<div class="auction-item" key="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
    <div class="g6 rounded">
        <h1>auction details</h1>

        <?php if(!empty($auction['Auction']['closed'])) : ?>
            <p class="timer"><?php __('Closed'); ?></p>
        <?php else : ?>
            <p id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown"><?php __('Loading...'); ?></p>
        <?php endif; ?>

        <h2>price</h2>

        <h3 class="price">
            <?php if(!empty($auction['Product']['fixed'])):?>
                <?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
                <span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
            <?php else: ?>
                <span class="bid-price">
                    <?php if(!empty($auction['Auction']['reverse']) && $auction['Auction']['price'] < 0 && empty($auction['Auction']['price_past_zero'])) : ?>
                        <span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
                        <?php echo $number->currency(0, $appConfigurations['currency']); ?>
                    <?php else : ?>
                        <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </h3>

        <?php if(empty($auction['Auction']['closed']) && empty($auction['Auction']['isFuture'])):?>
            <?php if($session->check('Auth.User')):?>
                <a href="/bid.php?id=<?php echo $auction['Auction']['id']; ?>" class="bidbutton bidbuttonsidebar bid-button-link" title="<?php echo $auction['Auction']['id']; ?>"><?php $bidDebit = $this->requestAction('/settings/get/bid_debit/'.$auction['Auction']['id']); if(!empty($bidDebit)) : ?><?php echo $bidDebit; ?><?php else : ?>1<?php endif; ?>x bid<?php if(!empty($bidDebit) && $bidDebit > 1) :?>s<?php endif; ?></a>
                <div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
                <div class="bid-message" style="display: none;">&nbsp;</div>
            <?php else : ?>
                <a href="/users/register" class="bidbutton bidbuttonsidebar">Register</a>
            <?php endif; ?>
        <?php endif; ?>
		
		<p class="buyitnow"></p>

        <p class="bidder">
            <?php if(!empty($auction['Auction']['closed'])) : ?>
                Won By<br>
                <?php if(!empty($auction['Winner']['id'])):?>
                    <span><?php echo $auction['Winner']['username']; ?></span>
                <?php elseif(!empty($auction['Auction']['reserve'])):?>
                    <span>Reserve Not Met</span>
                <?php else:?>
                    <span><?php __('There was no winner');?></span>
                <?php endif;?>
            <?php else : ?>
                Highest Bidder<br>
                <!--<span class="bid-bidder"><?php __('username');?></span>-->
				<?php echo "<span class='bid-bidder'>" . $auction['LastBid']['username'] . "</span>";?>
            <?php endif; ?>
        </p>

        <p>
            <?php if($session->check('Auth.User') && empty($auction['Auction']['closed'])):?>
                <?php if(!empty($watchlist)):?>
                    <?php echo $html->link(__('Remove from Watchlist', true), array('controller' => 'watchlists', 'action'=>'delete', $watchlist['Watchlist']['id']), array('class' => 'remind'), sprintf(__('Are you sure you want to delete the auction from your watchlist??', true), $watchlist['Watchlist']['id'])); ?>
                <?php else:?>
                    <?php echo $html->link(__('Add to Watchlist', true), array('controller' => 'watchlists', 'action' => 'add', $auction['Auction']['id']), array('class' => 'remind'));?>
                <?php endif;?>
            <?php endif; ?>
        </p>

        <div id="latest-bidders">
            <div class="bid-histories" id="bidHistoryTable<?php echo $auction['Auction']['id'];?>" title="<?php echo $auction['Auction']['id'];?>">
                <h3><?php __('Bidding History');?></h3>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php __('TIME');?></th>
                            <th><?php __('BIDDER');?></th>
                            <th><?php __('TYPE');?></th>
                        </tr>
                    </thead>
                    <?php if(!empty($bidHistories)):?>
                        <tbody>
                            <?php foreach($bidHistories as $bid):?>
                                <tr>
                                    <td><?php echo $time->niceShort($bid['Bid']['created']);?></td>
                                    <td><?php echo $bid['User']['username'];?></td>
                                    <td><?php echo $bid['Bid']['description'];?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    <?php elseif(!empty($auction['Winner']['id'])): ?>
                        <tr><td colspan="3"><?php __('The bidding history is no longer available for this auction.');?></td></tr>
                    <?php elseif(!empty($auction['Auction']['closed'])): ?>
                        <tr><td colspan="3"><?php __('No bids were placed.');?></td></tr>
                    <?php else: ?>
                        <tr><td colspan="3"><?php __('No bids have been placed yet.');?></td></tr>
                    <?php endif;?>
                </table>
            </div>
        </div>


		<?php if($session->check('Auth.User') && empty($auction['Auction']['closed']) && empty($auction['Auction']['nail_biter']) && $exchanged == 0 && $this->requestAction('/settings/enabled/bid_butler')):?>
            <div id="latest-bidders" class="rounded">
                <?php $bidbutler = $this->requestAction('/bidbutlers/check/'.$auction['Auction']['id'].'/'.$session->read('Auth.User.id'));?>
                    <?php if(!empty($bidbutler)) : ?>
                        <h3>Bid Buddy</h3>
                        <ul>
                        <li><?php echo sprintf(__('You currently have a bid buddy on this auction.  You have <strong>%s</strong> remaining bids left on the bid buddy.', true), $bidbutler['Bidbutler']['bids']);?></li>

                        <?php if(empty($auction['Product']['fixed'])) : ?>
                            <li><?php echo sprintf(__('The minimum price is <strong>%s</strong> and the maximum price is <strong>%s</strong>.', true), $number->currency($bidbutler['Bidbutler']['minimum_price'], $appConfigurations['currency']), $number->currency($bidbutler['Bidbutler']['maximum_price'], $appConfigurations['currency']));?></li>
                        <?php endif; ?>

                        <li><?php echo $html->link(__('Delete this Bid Buddy', true), array('controller' => 'bidbutlers', 'action' => 'delete', $bidbutler['Bidbutler']['id'], true), array('class' => 'remind'), sprintf(__('Are you sure you want to delete this bid buddy?', true))); ?></li>

                        </ul>

                        <h3><?php __('Replace Bid Buddy'); ?></h3>
                    <?php else : ?>
                        <h3>Add Bid Buddy</h3>
                    <?php endif; ?>

                    <?php echo $form->create('Bidbutler', array('url' => '/bidbuddies/add/'.$auction['Auction']['id']));?>
                        <?php if(empty($auction['Product']['fixed'])) : ?>
                            <p><label>Min price:</label><input name="data[Bidbutler][minimum_price]" type="text" style="width: 100px;" ></p>
                            <p><label>Max price:</label><input name="data[Bidbutler][maximum_price]" type="text" style="width: 100px;" ></p>
                        <?php endif; ?>

                        <p><label>Bids:</label><input name="data[Bidbutler][bids]" type="text" style="width: 100px;" ></p>

                        <?php echo $form->submit(__('Add Bid Buddy', true), array('class' => 'submit', 'div' => false));?>
                    <?php echo $form->end();?>
            </div>
        <?php endif; ?>
    </div>
    <div class="g5">
        <div id="auctions" class="rounded">
            <div id="tabs">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/auctions">Live Auctions</a></li>
                    <li><a href="/auctions/closed">Closed Auctions</a></li>
                    <li><a href="/auctions/future">Upcoming Auctions</a></li>
                    <li><a href="/auctions/easyview">Easy View</a></li>
                </ul>
            </div>
            <div class="auction-detail">
                <h1><?php echo $auction['Product']['title']; ?></h1>

                <?php if(!empty($auction['Product']['Image'])): ?>
                <ul class="gallery">
                    <?php foreach($auction['Product']['Image'] as $image):?>
                        <li>
                            <a href="/img/product_images/<?php echo $image['image']; ?>" rel="prettyPhoto[gallery]">
                                <?php echo $html->image('product_images/max/'.$image['image']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <div class="auction-detail">
                <h2>Product Overview</h2>
                <?php echo $auction['Product']['description']; ?>

            </div>
        </div>
        <!--/ Auctions -->
    </div>
</div>