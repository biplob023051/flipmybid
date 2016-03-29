<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
	<div class="g5">
    	<div id="auctions" class="rounded">
            <?php echo $this->element('user_submenu'); ?>

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
        <!--/ Listing -->
        </div>
    <!--/ Auctions -->
</div>