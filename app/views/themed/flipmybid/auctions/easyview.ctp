<div class="col-md-12 col-sm-12">
	<div id="auctions" class="rounded">
		<?php echo $this->element('user_submenu', array('active' => 'Easy')); ?>

		<?php if (!empty($auctions)) : ?>
			<?php echo $this->element('auction_carousel', array('auctions' => $auctions)); ?>
		<?php else : ?>
			<div class="c-content">
				<h2>Check Again Soon</h2>

				<p><?php __('There are no live auctions at the moment.');?></p>

			</div>
		<?php endif; ?>
		<!--/ Listing -->
	</div>
	<!--/ Auctions -->
</div>
