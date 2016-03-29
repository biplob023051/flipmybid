<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>

	<title><?php echo $title_for_layout; ?> :: <?php echo $appConfigurations['name']; ?></title>

	<link rel="shortcut icon" href="/img/favicon.ico" />

	<?php
		if(!empty($meta_description)) :
			echo $html->meta('description', $meta_description);
		endif;
		if(!empty($meta_keywords)) :
			echo $html->meta('keywords', $meta_keywords);
		endif;
	?>

	<?php echo $html->css('style'); ?>
	<?php echo $html->css('superfish'); ?>
	<?php echo $html->css('facebox'); ?>
	<?php echo $html->css('timeout'); ?>

	<?php
		echo $javascript->link('jquery/jquery');
		echo $javascript->link('jquery/ui');
		echo $javascript->link('default');
		echo $javascript->link('superfish');
		echo $javascript->link('cufon');
		echo $javascript->link('HelveticaNeue_LT_57_Cn_400.font');
		echo $javascript->link('facebox');
	?>

	<script type="text/javascript">
		Cufon.replace('#left h3, #right h1, #right h2, #right h3', { fontFamily: 'HelveticaNeue LT 57 Cn' });
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loadingImage : '/img/facebox/loading.gif',
			closeImage   : '/img/facebox/closelabel.gif'
		  })
		})
	</script>

	<?php echo $this->element('live_support'); ?>

    <!--[if lt IE 7]>
		<?php echo $html->css('ie6'); ?>
        <?php echo $javascript->link('DD_belatedPNG_0.0.7a'); ?>
        <script>
            DD_belatedPNG.fix('div, img, h3, li, a');
        </script>
    <![endif]-->

    <!-- Sliding Login Effects -->
	<script src="/js/slide.js" type="text/javascript"></script>
  	<link rel="stylesheet" href="/css/slide.css" type="text/css" media="screen" />
    <!-- Sliding effect -->
</head>

<body>

<div id="maincontent">
	<div id="content" class="container">

<div id="content_top_auc"><?php echo $auction['Product']['title']; ?></div>

<div id="content_bg_auc">
<div id="auction-details" class="boxed">
	<ul class="auction-details">
		<li class="auction-item" title="<?php echo $auction['Auction']['id'];?>" id="auction_<?php echo $auction['Auction']['id'];?>">
			<div class="content">
				<div class="bg-wrap">

<!-- Bid / Time Box -->
				<div class="data">
				<div class="info">

					<div class="left-data">
						<div class="timer-stat">
						<?php if(!empty($auction['Auction']['isClosed'])) : ?>
							<div class="b-closed"><?php echo $html->image('b-closed.png');?></div>
						<?php else: ?>
							<div id="timer_<?php echo $auction['Auction']['id'];?>" class="timer countdown" title="<?php echo $auction['Auction']['end_time'];?>"><?php __('Loading...'); ?></div>
						<?php endif; ?>
					</div>
					<?php if(empty($auction['Auction']['closed'])) : ?>
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

						<div class="username"><span class="bid-bidder"><?php __('username');?></span></div>
					<?php endif; ?>
					<div class="bid-now">
						<?php if(!empty($auction['Auction']['isFuture'])) : ?>
							<div><?php echo $html->image('b-soon2.gif');?></div>
						 <?php else:?>
							 <?php if($session->check('Auth.User')):?>
								<?php if(empty($auction['Auction']['isClosed']) && $exchanged == 0) : ?>
									<div class="bid-loading" style="display: none"><?php echo $html->image('ajax-arrows.gif');?></div>
								 	<div class="bid-button">
								 		<?php echo $html->link($html->image('bid_now.png'), '/bid.php?id='.$auction['Auction']['id'], array('class' => 'bid-button-link', 'title' => $auction['Auction']['id'], 'escape' => false));?>
								 	</div>
								 	<div class="bid-message clearfix" style="display: none;">&nbsp;</div>

								 	<?php if(!empty($auction['Auction']['beginner'])) : ?>
										<div class="beginner"><?php __('Beginner Auction'); ?></div>
									<?php endif; ?>

									<?php if(!empty($auction['Auction']['penny'])) : ?>
										<div class="beginner"><?php __('This is a Penny Auction'); ?></div>
									<?php endif; ?>
								<?php endif;?>
							<?php else:?>
								<?php if(empty($auction['Auction']['isClosed'])) : ?>
									<div class="bid-button"><?php echo $html->link($html->image('b-login.gif'), array('controller' => 'users', 'action' => 'login'), array('escape' => false));?></div>
								<?php endif;?>
							<?php endif;?>
						<?php endif; ?>
					</div>
<!-- END Bid / Time Box -->

					<?php if(!empty($auction['Auction']['closed'])) : ?>
						<div class="winner">
							<?php if(!empty($auction['Winner']['id'])):?>
								<div class="text"><?php echo sprintf(__('Congratulations to %s', true), $auction['Winner']['username']);?></div>
								<div class="saving"><?php __('A saving of');?> <span class="bid-savings-price"><?php echo $number->currency($auction['Auction']['savings']['price'], $appConfigurations['currency']);?></span></div>
							<?php else:?>
							<?php __('There was no winner');?><br />
						<?php endif;?>
						</div>
					<?php endif; ?>
					</div> <!-- leftdata -->
<!-- END Watchlist -->

<!-- Savings -->
					<div class="middle-data">
					<div class="count-saving">
						<label><?php __('Price');?></label> :

						<?php if(!empty($auction['Product']['fixed'])):?>
							<span><?php echo $number->currency($auction['Product']['fixed_price'], $appConfigurations['currency']);?></span>
                            <span class="bid-price-fixed" style="display: none"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
						<?php else: ?>
							<span class="bid-price"><?php echo $number->currency($auction['Auction']['price'], $appConfigurations['currency']); ?></span>
						<?php endif; ?>

						</span>


						<?php if(!empty($auction['Auction']['reverse'])) : ?>
							<p><?php __('This is a reverse auction!'); ?></p>
						<?php endif; ?>
					</div>

				</div>
<!-- END Savings -->

<!-- Bid History -->
                    <div class="right-data">
						<div class="bid-histories" id="bidHistoryTable<?php echo $auction['Auction']['id'];?>" title="<?php echo $auction['Auction']['id'];?>">
						<div class="content">
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
							<?php else: ?>
								<tr><td colspan="3"><?php __('No bids have been placed yet.');?></td></tr>
							<?php endif;?>
						</table>
						</div>
					</div>
					</div> <!-- right data -->
					<div style="clear: both;"></div>
<!-- END Bid History -->


				</div> <!-- data -->
				<div style="clear: both"></div>
				</div> <!-- .bg-wrap -->

			</div>
		</li>
	</ul>
</div>
</div><!-- content_bg -->


<?php echo $this->element('timeout'); ?>

</div></div>