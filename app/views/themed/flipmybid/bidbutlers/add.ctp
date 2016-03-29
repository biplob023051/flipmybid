<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
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
						echo $form->input('minimum_price', array('label' => __('Minimum Price *', true), 'class' => 'form-control'));
						echo $form->input('maximum_price', array('label' => __('Maximum Price *', true), 'class' => 'form-control'));
					}

					echo $form->input('bids', array('label' => __('Number of Bids to use *', true), 'class' => 'form-control'));

					echo $form->error('pending_bids');
					echo $form->error('balance');

					echo $form->submit(__('Add your Bid Buddy', true), array('class' => 'submit center-button', 'div' => false));
				?>
				</fieldset>
				<?php echo $form->end(); ?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
