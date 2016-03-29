<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>


<div class="pure-u-1 pure-u-md-3-4 auctions">
	<div class="pure-menu pure-menu-horizontal tabs">
		<ul class="pure-menu-list">
			<li class="pure-menu-item"><a href="/" class="pure-menu-link mobi">Home</a></li>
			<li class="pure-menu-item"><a href="/auctions" class="pure-menu-link">Live <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/closed" class="pure-menu-link">Closed <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/future" class="pure-menu-link">Upcoming <span class="mobi">Auctions</span></a></li>
			<li class="pure-menu-item"><a href="/auctions/easyview" class="pure-menu-link">Easy View</a></li>
		</ul>
	</div>

			
			<div class="c-content">
			
            <?php if(!empty($auctions)) : ?>
                <div class="paging-auct">
                    <?php echo $this->element('pagination'); ?>
                </div>

                <?php foreach ($auctions as $auction) : ?>
                    <?php echo $this->element('auction', array('auction' => $auction)); ?>
                <?php endforeach; ?>
                
                <div class="paging-auct">
                    <?php echo $this->element('pagination'); ?>
                </div>
            <?php else : ?>
                <p class="no-auction"><?php __('There are no live auctions at the moment.');?></p>
            <?php endif; ?>
			</div>
        <!--/ Listing -->
        </div>
    <!--/ Auctions -->
</div>