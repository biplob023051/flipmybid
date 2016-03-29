<div id="auctions">
	<ul class="horizontal-auctions">
	<?php foreach($auctions as $auction):?>
    	<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
        	<div class="content">
            	<h3><?php echo $html->link($text->truncate($auction['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></h3>
                <div class="wrapper">
                    <div class="thumb">
                        <a href="/auction/<?php echo $auction['Auction']['id']; ?>">
						<?php if(!empty($auction['Auction']['image'])):?>
							<?php echo $html->image($auction['Auction']['image'], array('alt' => $auction['Product']['title'], 'title' => $auction['Product']['title'])); ?>
						<?php else:?>
							<?php echo $html->image('product_images/thumbs/no-image.gif');?>
						<?php endif;?>
						</a>
                    </div>
                    <div class="info">
                        <?php if(!empty($auction['Auction']['closed'])):?>
                        	<div class="timer"><?php __('GONE'); ?></div>
                        <?php else : ?>
                        	<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>">--:--:--</div>
                        <?php endif; ?>
					</div>
                    <div class="price">
						<?php if(!empty($auction['Product']['fixed'])):?>
                            <?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?>
                            <span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
                        <?php else: ?>
                            <span class="bid-price">
                                <?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="username">
                    	<?php if(!empty($auction['Auction']['closed'])):?>
							<?php if(!empty($auction['Winner']['username'])):?>
								<span><?php echo $auction['Winner']['username']; ?></span>
							<?php else : ?>
								<span><?php __('There was no winner!');?></span>
							<?php endif; ?>
                    	<?php else : ?>
                    		<span class="bid-bidder"><?php __('username');?></span>
                    	<?php endif; ?>
                    </div>
                    <div class="bid-now">
                    	<?php if(!empty($auction['Auction']['isFuture'])) : ?>
                            <div><?php echo $html->image('b-soon.gif', array('alt' => __('Coming Soon', true), 'title' => __('Coming Soon', true)));?></div>
                         <?php elseif(!empty($auction['Auction']['isClosed'])) : ?>
                            <div><?php echo $html->image('b-closed.png', array('alt' => __('Auction Closed', true), 'title' => __('Auction Closed', true)));?></div>
                         <?php else:?>
                             <?php if($session->check('Auth.User')):?>
                                 <div class="bid-button">
                                    <?php echo $html->link($html->image('b-bid.gif', array('alt' => __('Place Bid', true), 'title' => __('Place Bid', true))), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
                                    <div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
                                    <div class="bid-message" style="display: none;">&nbsp;</div>
                                </div>
                            <?php else:?>
                                <div class="bid-button"><?php echo $html->link($html->image('b-login.gif', array('alt' => __('Login', true), 'title' => __('Login', true))), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
                            <?php endif;?>

                            <?php if(!empty($auction['Auction']['beginner'])) : ?>
                                <div class="beginner"><?php __('Beginner Auction'); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
	<?php endforeach; ?>
    </ul>
</div>