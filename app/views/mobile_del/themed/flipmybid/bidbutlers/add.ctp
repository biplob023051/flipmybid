<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Add a Bid Buddy to the auction:');?> <a href="/auction/<?php echo $auction['Auction']['id']; ?>"><?php echo $auction['Product']['title']; ?></a></2>
		</div>
		<div class="account">
			<div class="">
				<?php echo $form->create(null, array('url' => '/bidbuddies/add/'.$auction['Auction']['id']));?>
					<fieldset>
				<?php
					if(empty($auction['Product']['fixed'])) {
						echo $form->input('minimum_price', array('label' => __('Minimum Price *', true)));
						echo $form->input('maximum_price', array('label' => __('Maximum Price *', true)));
					}

					echo $form->input('bids', array('label' => __('Number of Bids to use *', true)));

					echo $form->error('pending_bids');
					echo $form->error('balance');

					echo $form->submit(__('Add your Bid Buddy', true), array('class' => 'submit', 'div' => false));
				?>
				</fieldset>
				<?php echo $form->end(); ?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
