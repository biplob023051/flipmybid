<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
<?php $paginator->options(array('url'=>Router::getParam('pass'))); ?>
<div class="col-md-8 auctions">
	<ul class="nav nav-tabs nav-justified m-none">
		<li><a href="/">Home</a></li>
		<li><a href="/auctions">Live Auctions</a></li>
		<li class="menuactive"><a href="/auctions/closed">Closed Auctions</a></li>
		<li><a href="/auctions/future">Upcoming Auctions</a></li>
	</ul>
	<ul class="nav nav-tabs nav-justified d-none">
		<div class="col-xs-4"><li><a href="/auctions">Live</a></li></div>
		<div class="col-xs-4"><li class="menuactive"><a href="/auctions/closed">Closed</a></li></div>
		<div class="col-xs-4"><li><a href="/auctions/future">Upcoming</a></li></div>
	</ul>				



<div class="slider-pro" id="my-slider">
    <div class="sp-slides"> 
        <!-- Slide 1 -->
        <div class="sp-slide">
			<img class="sp-image" src="http://www.flipmybid.com/img/product_images/max/38a43bcca549c0157e408826c858a62cbd89c70c.jpeg"/>
			<p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-height="40" data-width="100%" >Amazon Kindle Fire</p>
        </div>

        <!-- Slide 2 -->
        <div class="sp-slide">
			<img class="sp-image" src="http://www.flipmybid.com/img/product_images/max/707ca0ae5b55451daa25dc3474b53caf8c3ecd37.jpeg"/>
			<p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-height="40" data-width="100%" >IPad Mini</p>
        </div>

        <!-- Slide 3 -->
        <div class="sp-slide">
			<img class="sp-image" src="http://www.flipmybid.com/img/product_images/max/145833f28925ff9ae2af687f3900ece454c8b95c.jpeg"/>
			<p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-height="40" data-width="100%" >Amazon Gift Card</p>
        </div>
    </div>
</div>

	<!--<div class="auction-content">-->
		<?php if(!empty($auctions)) : ?>
		<div class="col-md-12 totalresults"><strong><?php echo $paginator->counter(array('format' => 'Showing %start% - %end%</strong> (%count%)')); ?></div>
		<?php foreach ($auctions as $auction) : ?>
		<?php echo $this->element('auction', array('auction' => $auction)); ?>
		<?php endforeach; ?>
		<div class="col-md-12 pagenumber">
		  <ul class="pagination">
			<?php if($paginator->hasPrev()) : ?>
			<li><?php echo $paginator->first('<< Start ', null, null, array('class' => 'disabled')); ?></li>
			<li><?php echo $paginator->prev('<< Prev ', null, null, array('class' => 'disabled')); ?></li>
			<?php endif; ?>
			<?php if (is_string($paginator->numbers())): ?>
			<?php echo $paginator->numbers(array('separator' => '</li><li>', 'before' => '<li>', 'after' => '</li>'));?>
			<?php endif; ?>
			<?php if($paginator->hasNext()): ?>
			<li><?php echo $paginator->next(' Next >>', null, null, array('class' => 'disabled')); ?></li>
			<li><?php echo $paginator->last(' End >>', null, null, array('class' => 'disabled')); ?></li>
			<?php endif; ?>
		  </ul>
		</div>
		<?php else : ?>
		<div class="no-auction"><?php __('<h2>Check Again Soon</h2><p>There are no closed auctions at the moment.</p>');?></div>
		<?php endif; ?>
	<!--</div>-->
</div>