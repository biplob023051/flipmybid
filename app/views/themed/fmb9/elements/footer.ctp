<div class="pure-g footer">
<div id="center">
	<div class="pure-u-1 pure-u-md-1-3 footer13">
	<h1>connect with us</h1>
	<a target="_blank" href="https://www.facebook.com/FlipMyBid"><?php echo $html->image('icon-facebook.jpg', array('width'=>'54px', 'height'=>'50px', 'alt'=>'facebook')); ?></a>
	<a target="_blank" href="http://www.twitter.com/flipmybid"><?php echo $html->image('icon-twitter.jpg', array('width'=>'56px', 'height'=>'50px', 'alt'=>'twitter')); ?></a>
	<a target="_blank" href="http://www.youtube.com/FlipMyBid"><?php echo $html->image('icon-youtube.jpg', array('width'=>'56px', 'height'=>'50px', 'alt'=>'YouTube')); ?></a>
	</div>
	<?php $latestNews = $this->requestAction('/news/getlatest'); ?>
	<?php if(!empty($latestNews)) : ?>	
	<div class="pure-u-1 pure-u-md-1-3 footer23">
	<h1>latest news</h1>
	<h1><?php echo $html->link($latestNews['News']['title'], array('controller' => 'news', 'action'=>'view', $latestNews['News']['id'])); ?></h1>
	<p><?php echo nl2br($latestNews['News']['brief']); ?>... <?php echo $html->link('read more', array('controller' => 'news', 'action'=>'view', $latestNews['News']['id'])); ?></p>	
	</div>
	<?php endif; ?>
	<div class="pure-u-1 pure-u-md-1-3 footer33">
	<h1>latest auctions</h1>
	<?php $latestAuctions = $this->requestAction('/auctions/getlatest/8'); ?>
	<?php if(!empty($latestAuctions)) : ?>	
	<ul>
		<?php foreach ($latestAuctions as $auction) : ?>
			<li><?php echo $html->link($text->truncate($auction['Product']['title'],35), array('controller' => 'auctions', 'action' => 'view', $auction['Auction']['id']));?></li>
		<?php endforeach; ?>
	</ul>	
	</div>
	<?php endif; ?>	
	</div>
</div>
</div>


<div class="pure-g footercopyright">
	<div id="center">
	<div class="pure-u-1 copyright">
	<p>
		<?php $pages = $this->requestAction('/pages/getpages/bottom');?>
		<?php if(!empty($pages)):?>
			<?php foreach($pages as $page):?>
				<?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action'=>'view', $page['Page']['slug'])); ?> |
			<?php endforeach;?>
		<?php endif;?>
		<?php echo $html->link(__('Contact Us', true), array('controller' => 'pages', 'action'=>'contact')); ?>
	</p>
	<p><a href="/">FlipMyBid.com</a> - <?php echo date('Y'); ?> - All rights reserved.</p>
	<p><a target="_blank" href="http://www.instantssl.com"><img src="/theme/flipmybid/img/comodo_secure_76x26_transp.png" alt="SSL Certificates" width="76" height="26" style="border: 0px;"></a></p>	
	</div>
	</div>
</div>


