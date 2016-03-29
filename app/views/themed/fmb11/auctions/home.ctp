<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
<div class="col-md-8 auctions">

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
		
        <!-- Slide 4 -->
        <div class="sp-slide">
			
			<p style="width:250px;height:300px;">click here to view upcoming auctions</p>
			<p class="sp-layer sp-black sp-padding" data-position="bottomLeft" data-height="40" data-width="100%" ></p>
			
        </div>
		
    </div>
</div>


	<ul class="nav nav-tabs nav-justified m-none">
		<li class="menuactive"><a href="/">Home</a></li>
		<li><a href="/auctions">Live Auctions</a></li>
		<li><a href="/auctions/closed">Closed Auctions</a></li>
		<li><a href="/auctions/future">Upcoming Auctions</a></li>
	</ul>
	<ul class="nav nav-tabs nav-justified d-none" style="border-bottom: 2px solid #08afd8;border-top: 2px solid #08afd8;
    margin-top: 5px;">
		<!-- <div class="col-xs-4" style="width:20%; text-align:center; font-size: 18px;"><li style="padding:5px 0 3px 0; text-align:right;"><a href="/auctions">Live</a></li></div>
		<div class="col-xs-4" style="width: 1px; padding-left: 0 !important;   padding-right: 0 !important;     height: 30px;     margin: 4px 0;     padding-top: 0;     font-size: 25px;">|</div>
		<div class="col-xs-4" style="width:26%; text-align:center; font-size: 18px;"><li style="padding:5px 0 3px 0;"><a href="/auctions/closed">Closed</a></li></div>
		-->
		<div class="col-xs-4" style="font-size: 18px;"><li style="text-align:right;"><a href="/auctions">Live</a></li></div>
		<div class="col-xs-4" style="padding-left: 0 !important;   padding-right: 0 !important;     height: 30px;     margin: 0;     padding-top: 0;     font-size: 25px;">|</div>
		<div class="col-xs-4" style="font-size: 18px;"><li style="text-align:left;"><a href="/auctions/closed">Closed</a></li></div>		
	</ul>					
	<div class="auction-content">
		<?php if(!empty($auctions_end_soon)) : ?>
		<div class="paging-auct col-md-12"><?php echo $this->element('pagination'); ?></div>
		<?php foreach ($auctions as $auction) : ?>
		<?php echo $this->element('auction', array('auction' => $auction)); ?>
		<?php endforeach; ?>
		<div class="paging-auct col-md-12"><?php echo $this->element('pagination'); ?></div>
		<?php else : ?>
		<div class="no-auction"><?php __('<h2>Check Again Soon</h2><p>There are no live auctions at the moment.</p>');?></div>
		<?php endif; ?>
	</div>
</div>