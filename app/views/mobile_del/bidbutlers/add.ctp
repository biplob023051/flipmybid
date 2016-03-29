<div id="left">
    <?php echo $this->element('menu_user');?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Add a Bid Buddy to the auction:');?> <a href="/auction/<?php echo $auction['Auction']['id']; ?>"><?php echo $auction['Product']['title']; ?></a></h1>



		<?php echo $form->create(null, array('url' => '/bidbuddies/add/'.$auction['Auction']['id']));?>
			<fieldset>
			<legend><?php __('Add a Bid Buddy for Auction');?> <?php echo $auction['Product']['title']; ?></legend>
		<?php
			if(empty($auction['Product']['fixed'])) {
				echo $form->input('minimum_price', array('label' => __('Minimum Price *', true)));
				echo $form->input('maximum_price', array('label' => __('Maximum Price *', true)));
			}

			echo $form->input('bids', array('label' => __('Number of Bids to use *', true)));

			echo $form->error('pending_bids');
			echo $form->error('balance');
		?>
		</fieldset>
		<?php echo $form->end(__('Add your Bid Buddy >>', true));?>
	</div>
</div>
