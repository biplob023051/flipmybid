<?php if(!$session->check('Auth.User')):?>
	<?php echo $this->element('register'); ?>
<?php else: ?>
	<?php echo $this->element('tab'); ?>
<?php endif; ?>
	<div class="g5">
    	<div id="auctions" class="rounded">
            <?php echo $this->element('user_submenu'); ?>
            <?php if(!empty($auctions_end_soon)) : ?>
				<?php foreach ($auctions_end_soon as $auction) : ?>
                    <?php echo $this->element('auction', array('auction' => $auction)); ?>
                <?php endforeach; ?>
            <?php else : ?>
				<div class="c-content">
					<h2>Check Again Soon</h2>

		<p>There are currently no live auctions. Please check again soon.</p>

				</div>
            <?php endif; ?>
        <!--/ Listing -->
        </div>
    <!--/ Auctions -->
</div>
