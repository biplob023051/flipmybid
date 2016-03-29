<div class="row" id="footer-columns">
	<div class="container">
		<div class="col-sm-4 right-divider image-links">
			<h1>connect with us</h1>
			<a target="_blank" href="https://www.facebook.com/FlipMyBid">
				<?php echo $html->image('icon-facebook.jpg', array('width'=>'54px', 'height'=>'50px', 'alt'=>'facebook')); ?>
			</a>
			<a target="_blank" href="http://www.twitter.com/flipmybid">
				<?php echo $html->image('icon-twitter.jpg', array('width'=>'56px', 'height'=>'50px', 'alt'=>'twitter')); ?>
			</a>
			<a target="_blank" href="http://www.youtube.com/FlipMyBid">
				<?php echo $html->image('icon-youtube.jpg', array('width'=>'56px', 'height'=>'50px', 'alt'=>'YouTube')); ?>
			</a>
		</div>
		<div class="col-sm-4 right-divider">
			<h1>latest news</h1>
			<?php $latestNews = $this->requestAction('/news/getlatest'); ?>
			<h2>
				<?php echo $html->link($latestNews['News']['title'], array(
						'controller' => 'news',
						'action'=>'view', $latestNews['News']['id']));
				?>
			</h2>
			<p>
				<?php echo nl2br($latestNews['News']['brief']); ?>...
				<?php echo $html->link('read more', array(
						'controller' => 'news',
						'action'=>'view', $latestNews['News']['id'])); ?>
			</p>
		</div>
		<div class="col-sm-4">
			<h1>latest auctions</h1>
			<?php $latestAuctions = $this->requestAction('/auctions/getlatest/3'); ?>
			<?php if(!empty($latestAuctions)) : ?>
			<ul>
				<?php foreach ($latestAuctions as $auction) : ?>
					<li><h2><?php echo $html->link($text->truncate($auction['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></h2></li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
					<h2>No last auctions</h2>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="row" id="footer-copyright">
	<div class="container">
		<div class="col-sm-12" >
			<p>
				<?php $pages = $this->requestAction('/pages/getpages/bottom');?>
				<?php if(!empty($pages)):?>
					<?php foreach($pages as $page):?>
						<?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?> |
					<?php endforeach;?>
				<?php endif;?>
				<?php echo $html->link(__('Contact Us', true), array('controller' => 'pages', 'action'=>'contact')); ?>
			</p>
			<p style="font-size:13px;"><a href="/">FlipMyBid.com</a> - <?php echo date('Y'); ?> - All rights reserved.</p>
			<p>
				<a target="_blank" href="http://www.instantssl.com">
					<img src="/theme/flipmybid/img/comodo_secure_76x26_transp.png"
						 alt="SSL Certificates" width="76" height="26" style="border: 0px;">
				</a>
			</p>
		</div>
	</div>
</div>
